<?php

    require_once __DIR__."/../modelos/mainModel.php";

	class pedidoControlador extends mainModel{

		/*--------- Controlador agregar producto - Controller add product ---------*/
        public function agregar_producto_pedido_controlador(){

        	/*-- Recibiendo codigo del producto - Receiving product code --*/
        	$codigo=mainModel::limpiar_cadena($_POST['producto_codigo_add']);

        	/*-- Comprobando producto en la DB - Checking product in DB --*/
			$check_producto=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE producto_codigo='$codigo'");
			if($check_producto->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Producto no encontrado",
					"Texto"=>"No hemos encontrado el producto en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}else{
				$campos=$check_producto->fetch();
			}
			$check_producto->closeCursor();
			$check_producto=mainModel::desconectar($check_producto);

			/*-- Obteniendo datos de la empresa - Obtaining company data --*/
            $check_empresa=mainModel::ejecutar_consulta_simple("SELECT * FROM empresa LIMIT 1");
            if($check_empresa->rowCount()<1){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido obtener algunos datos de los impuestos para agregar el producto.",
					"Icon"=>"error",
					"TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }else{
                $datos_empresa=$check_empresa->fetch();
            }
            $check_empresa->closeCursor();
			$check_empresa=mainModel::desconectar($check_empresa);

            if($datos_empresa['empresa_impuesto_nombre']!=$_SESSION['venta_impuesto_nombre'] || $datos_empresa['empresa_impuesto_porcentaje']!=$_SESSION['venta_impuesto_porcentaje']){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Hemos detectado un cambio en los datos de la empresa e impuestos, por favor recargue la página e intente nuevamente o verifique los datos de la empresa.",
					"Icon"=>"error",
					"TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

			/*-- ID de producto - Product ID --*/
            $id=$campos['producto_id'];


            /*-- Verificando producto en el carrito - Checking product in cart --*/
            if(empty($_SESSION['carrito_sto'][$id])){

            	$cantidad=1;

				$_SESSION['alerta_producto_agregado']="<i class='far fa-check-circle fa-fw'></i> Se agrego <strong>".$campos['producto_nombre']."</strong> al pedido";

            }else{

            	$cantidad=($_SESSION['carrito_sto'][$id]['venta_detalle_cantidad'])+1;

                $_SESSION['alerta_producto_agregado']="<i class='far fa-check-circle fa-fw'></i> Se agrego +1 <strong>".$campos['producto_nombre']."</strong> a la venta. Total en carrito: <strong>$cantidad</strong>";
            }

            /*-- Verificando el stock del producto - Checking product stock --*/
            if($campos['producto_tipo']=="Fisico"){
	            if($campos['producto_stock']<$cantidad){

	            	unset($_SESSION['alerta_producto_agregado']);

	            	$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Existencias no disponibles",
						"Texto"=>"No hay suficientes existencias disponibles, solo hay ".$campos['producto_stock']." en stock",
	                    "Icon"=>"error",
	                    "TxtBtn"=>"Aceptar"
					];
					echo json_encode($alerta);
					exit();
	            }
            }
        	
        	$detalle_precio_final=$campos['producto_precio_venta']-($campos['producto_precio_venta']*($campos['producto_descuento']/100));
        	$detalle_precio_final=number_format($detalle_precio_final,COIN_DECIMALS,'.','');

        	$detalle_total=$cantidad*$detalle_precio_final;
            $detalle_total=number_format($detalle_total,COIN_DECIMALS,'.','');

            $detalle_subtotal=$detalle_total/(($datos_empresa['empresa_impuesto_porcentaje']/100)+1);
            $detalle_subtotal=number_format($detalle_subtotal,COIN_DECIMALS,'.','');

            $detalle_impuestos=$detalle_total-$detalle_subtotal;
            $detalle_impuestos=number_format($detalle_impuestos,COIN_DECIMALS,'.','');

            $detalle_costos=$campos['producto_precio_compra']*$cantidad;
            $detalle_costos=number_format($detalle_costos,COIN_DECIMALS,'.','');

            $detalle_utilidad=$detalle_total-$detalle_costos;
            $detalle_utilidad=number_format($detalle_utilidad,COIN_DECIMALS,'.','');


        	$_SESSION['carrito_sto'][$id]=[
                "producto_id"=>$id,
                "venta_detalle_cantidad"=>$cantidad,
				"producto_codigo"=>$campos['producto_codigo'],
                "venta_detalle_precio_compra"=>$campos['producto_precio_compra'],
                "venta_detalle_precio_regular"=>$campos['producto_precio_venta'],
                "venta_detalle_precio_venta"=>$detalle_precio_final,
                "venta_detalle_total"=>$detalle_total,
                "venta_detalle_subtotal"=>$detalle_subtotal,
                "venta_detalle_impuestos"=>$detalle_impuestos,
                "venta_detalle_costo"=>$detalle_costos,
                "venta_detalle_utilidad"=>$detalle_utilidad,
                "venta_detalle_descripcion"=>$campos['producto_nombre'],
                "producto_stock_total"=>$campos['producto_stock'],
				"producto_descuento"=>$campos['producto_descuento'],
				"producto_portada"=>$campos['producto_portada']
            ];

            $alerta=[
                "Alerta"=>"redireccionar",
                "URL"=>SERVERURL.DASHBOARD."/order-new/"
            ];

            echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador buscar producto - Controller search product ---------*/
        public function buscar_codigo_pedido_controlador(){

        	/*== Recuperando codigo de busqueda ==*/
			$producto=mainModel::limpiar_cadena($_POST['buscar_codigo']);

			/*== Comprobando que no este vacio el campo ==*/
			if($producto==""){
				return '<div class="alert alert-warning" role="alert">
					<p class="text-center mb-0">
						<i class="fas fa-exclamation-triangle fa-2x"></i><br>
						Debes de introducir el Nombre, Marca o Modelo del producto
					</p>
				</div>';
				exit();
            }

            /*== Seleccionando productos en la DB ==*/
            $datos_productos=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE ((producto_estado='Habilitado') AND (producto_nombre LIKE '%$producto%' OR producto_marca LIKE '%$producto%' OR producto_modelo LIKE '%$producto%')) ORDER BY producto_nombre ASC");
            
            if($datos_productos->rowCount()>=1){

				$datos_productos=$datos_productos->fetchAll();

				$tabla='<div class="table-responsive" ><table class="table table-hover table-bordered table-sm"><tbody>';

				foreach($datos_productos as $rows){
					$tabla.='
					<tr class="text-center">
                        <td>'.$rows['producto_nombre'].'</td>
                        <td>
                            <button type="button" class="btn btn-primary" onclick="agregar_codigo(\''.$rows['producto_codigo'].'\')"><i class="fas fa-plus-circle"></i></button>
                        </td>
                    </tr>
                    ';
				}

				$tabla.='</tbody></table></div>';
				return $tabla;
			}else{
				return '<div class="alert alert-warning" role="alert">
					<p class="text-center mb-0">
						<i class="fas fa-exclamation-triangle fa-2x"></i><br>
						No hemos encontrado ningún producto en el sistema que coincida con <strong>“'.$producto.'”</strong>
					</p>
				</div>';
				exit();
			}

        } /*-- Fin controlador - End controller --*/


        /*---------- Controlador buscar cliente - Controller search client ----------*/
        public function buscar_cliente_pedido_controlador(){

            /*== Recuperando termino de busqueda ==*/
			$cliente=mainModel::limpiar_cadena($_POST['buscar_cliente']);

			/*== Comprobando que no este vacio el campo ==*/
			if($cliente==""){
				return '<div class="alert alert-warning" role="alert">
					<p class="text-center mb-0">
						<i class="fas fa-exclamation-triangle fa-2x"></i><br>
						Debes de introducir el Nombre, Apellido o Teléfono del cliente
					</p>
				</div>';
				exit();
            }
            
            /*== Seleccionando clientes en la DB ==*/
            $datos_cliente=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE (cliente_id!='1') AND (cliente_nombre LIKE '%$cliente%' OR cliente_apellido LIKE '%$cliente%' OR cliente_telefono LIKE '%$cliente%') ORDER BY cliente_nombre ASC");
            
            if($datos_cliente->rowCount()>=1){

				$datos_cliente=$datos_cliente->fetchAll();

				$tabla='<div class="table-responsive" ><table class="table table-hover table-bordered table-sm"><tbody>';

				foreach($datos_cliente as $rows){
					$tabla.='
					<tr class="text-center">
                        <td>'.$rows['cliente_nombre'].' '.$rows['cliente_apellido'].' (Tel: '.$rows['cliente_telefono'].')</td>
                        <td>
                            <button type="button" class="btn btn-primary" onclick="agregar_cliente('.$rows['cliente_id'].')"><i class="fas fa-user-plus"></i></button>
                        </td>
                    </tr>
                    ';
				}

				$tabla.='</tbody></table></div>';
				return $tabla;
			}else{
				return '<div class="alert alert-warning" role="alert">
					<p class="text-center mb-0">
						<i class="fas fa-exclamation-triangle fa-2x"></i><br>
						No hemos encontrado ningún cliente en el sistema que coincida con <strong>“'.$cliente.'”</strong>
					</p>
				</div>';
				exit();
			}
        } /*-- Fin controlador - End controller --*/


        /*---------- Controlador agregar cliente - Controller add client ----------*/
        public function agregar_cliente_pedido_controlador(){

            /*== Recuperando id del cliente ==*/
			$id=mainModel::limpiar_cadena($_POST['cliente_id_add']);

			/*== Comprobando cliente en la DB ==*/
			$check_cliente=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_id='$id'");
			if($check_cliente->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido agregar el cliente debido a un error, por favor intente nuevamente.",
					"Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
			}else{
				$campos=$check_cliente->fetch();

                $_SESSION['datos_cliente_venta']=[
                    "cliente_id"=>$campos['cliente_id'],
                    "cliente_nombre"=>$campos['cliente_nombre'],
                    "cliente_apellido"=>$campos['cliente_apellido'],
                    "cliente_telefono"=>$campos['cliente_telefono']
                ];

                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"¡Cliente agregado!",
                    "Texto"=>"El cliente se agregó para realizar un pedido.",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];
            }
            $check_cliente->closeCursor();
			$check_cliente=mainModel::desconectar($check_cliente);	

            echo json_encode($alerta); 
        } /*-- Fin controlador - End controller --*/


        /*---------- Controlador remover cliente - Controller remove client ----------*/
        public function remover_cliente_pedido_controlador(){

			unset($_SESSION['datos_cliente_venta']);

			if(empty($_SESSION['datos_cliente_venta'])){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Cliente removido!",
					"Texto"=>"Los datos del cliente se han removido.",
					"Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido remover el cliente, por favor intente nuevamente.",
					"Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
			}
			echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/


		/*--------- Controlador guardar pedido administrador - Save order admin Controller ---------*/
		public function guardar_pedido_administrador_controlador(){

			/*-- Comprobando tipo de usuario - Checking user type --*/
        	if($_SESSION['tipo_sto']!="Administrador"){
        		$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No tienes los permisos necesarios para realizar esta operación",
					"Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
        	}

        	/*-- Recibiendo datos del formulario - Receiving data from the form --*/
        	$caja_id=mainModel::limpiar_cadena($_POST['venta_caja']);
        	$venta_pagado=mainModel::limpiar_cadena($_POST['venta_abono']);
        	$venta_tipo_envio=mainModel::limpiar_cadena($_POST['venta_tipo_envio']);

        	/*-- Verificando integridad de los datos - Checking data integrity --*/
            if(mainModel::verificar_datos("[0-9.]{1,25}",$venta_pagado)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El total pagado no coincide con el formato solicitado",
					"Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if($venta_tipo_envio!="Contra Entrega"){
            	$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El tipo de envió no coincide con el formato solicitado",
					"Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Comprobando totales de la venta - Checking sale totals --*/
            if($_SESSION['venta_subtotal']<=0 || $_SESSION['venta_impuestos']<=0 || $_SESSION['venta_total']<=0 || $_SESSION['venta_costos']<=0 || (!isset($_SESSION['carrito_sto']) && count($_SESSION['carrito_sto'])<=0)){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No ha agregado productos a esta venta o no ha agregado los impuestos en los datos de la empresa",
					"Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

        	/*-- Comprobando cliente en la DB - Checking client in DB --*/
        	if(!isset($_SESSION['datos_cliente_venta'])){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No ha seleccionado ningún cliente para realizar esta venta",
					"Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

			$check_cliente=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_id='".$_SESSION['datos_cliente_venta']['cliente_id']."'");
			if($check_cliente->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Cliente no encontrado",
					"Texto"=>"No hemos encontrado los datos del cliente en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}else{
				$campos_cliente=$check_cliente->fetch();
			}
			$check_cliente->closeCursor();
			$check_cliente=mainModel::desconectar($check_cliente);

			/*-- Comprobando empresa en la DB - Checking company in DB --*/
			$check_empresa=mainModel::ejecutar_consulta_simple("SELECT * FROM empresa LIMIT 1");
			if($check_empresa->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos encontrado algunos datos en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}else{
				$campos_empresa=$check_empresa->fetch();
			}
			$check_empresa->closeCursor();
			$check_empresa=mainModel::desconectar($check_empresa);

			/*-- Comprobando caja en la DB - Checking cash register in DB --*/
			$check_caja=mainModel::ejecutar_consulta_simple("SELECT * FROM caja WHERE $caja_id='$caja_id'");
			if($check_caja->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Caja no encontrada",
					"Texto"=>"No hemos encontrado los datos de la caja en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}else{
				$campos_caja=$check_caja->fetch();
			}
			$check_caja->closeCursor();
			$check_caja=mainModel::desconectar($check_caja);

			/*-- Formateando variables - Formatting variables --*/
			$venta_total=0;
			$venta_costo=0;
			$venta_utilidad=0;
            foreach ($_SESSION['carrito_sto'] as $campos){
            	$venta_total+=$campos['venta_detalle_total'];
            	$venta_costo+=$campos['venta_detalle_costo'];
            	$venta_utilidad+=$campos['venta_detalle_utilidad'];
            }

            $venta_impuesto_nombre=$campos_empresa['empresa_impuesto_nombre'];
            $venta_impuesto_porcentaje=$campos_empresa['empresa_impuesto_porcentaje'];


            $venta_pagado=number_format($venta_pagado,COIN_DECIMALS,'.','');

            /*-- Comprobando total a pagar - Checking total to pay --*/
            if($venta_pagado<$venta_total){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"Esta es una venta al contado, el total a pagar por el cliente no puede ser menor al total a pagar.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Calculando el cambio - Calculating the change --*/
            $venta_cambio=$venta_pagado-$venta_total;
            $venta_cambio=number_format($venta_cambio,COIN_DECIMALS,'.','');

            /*-- Calculando total en caja - Calculating total at cash register --*/
            $movimiento_cantidad=$venta_pagado-$venta_cambio;
            $movimiento_cantidad=number_format($movimiento_cantidad,COIN_DECIMALS,'.','');

            $total_caja=$campos_caja['caja_efectivo']+$movimiento_cantidad;
            $total_caja=number_format($total_caja,COIN_DECIMALS,'.','');

            $venta_estado_pagado="Pagada";
            $venta_estado_estado="Pedido confirmado";
            $venta_estado_envio="Pedido enviado";

            $venta_total=number_format($venta_total,COIN_DECIMALS,'.','');
            $venta_costo=number_format($venta_costo,COIN_DECIMALS,'.','');
            $venta_utilidad=number_format($venta_utilidad,COIN_DECIMALS,'.','');

            $venta_fecha=date("Y-m-d");
            $venta_hora=date("h:i a");

            $venta_subtotal=$venta_total/(($venta_impuesto_porcentaje/100)+1);
            $venta_subtotal=number_format($venta_subtotal,COIN_DECIMALS,'.','');

            $venta_impuestos=$venta_total-$venta_subtotal;
            $venta_impuestos=number_format($venta_impuestos,COIN_DECIMALS,'.','');

            /*== generando codigo de venta ==*/
            $codigo_venta=mainModel::ejecutar_consulta_simple("SELECT venta_id FROM venta");
			$codigo_venta=($codigo_venta->rowCount())+1;
            $codigo_venta=mainModel::generar_codigo_aleatorio(10,$codigo_venta);

            /*-- Conectando a bd y activando transacciones - Connecting to database and activating transactions --*/
            $gbd=mainModel::conectar();
            $gbd->beginTransaction();

            /*-- Preparando consulta - Preparing query --*/
            $query="INSERT INTO venta (venta_codigo,venta_fecha,venta_hora,venta_tipo_envio,venta_impuesto_nombre,venta_impuesto_porcentaje,venta_estado_envio,venta_estado_pagado,venta_estado_estado,venta_subtotal,venta_impuestos,venta_total,venta_costo,venta_utilidad,venta_pagado,venta_cambio,cliente_id,usuario_id,empresa_id,caja_id) VALUES('$codigo_venta','$venta_fecha','$venta_hora','$venta_tipo_envio','$venta_impuesto_nombre','$venta_impuesto_porcentaje','$venta_estado_envio','$venta_estado_pagado','$venta_estado_estado','$venta_subtotal','$venta_impuestos','$venta_total','$venta_costo','$venta_utilidad','$venta_pagado','$venta_cambio','".$campos_cliente['cliente_id']."','".$_SESSION['id_sto']."','".$campos_empresa['empresa_id']."','$caja_id')";

			if(!$gbd->exec($query)){

				$gbd->rollBack();

                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Error al confirmar el pedido",
                    "Texto"=>"No podemos procesar el pedido en este momento por favor intente nuevamente. (001)",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
				exit();
			}

			/*-- Guardando detalles del pedido - Saving order details --*/
			foreach($_SESSION['carrito_sto'] as $venta_detalle){

				/*-- Preparando consulta - Preparing query --*/
				$query="INSERT INTO venta_detalle (venta_detalle_cantidad,venta_detalle_precio_compra,venta_detalle_precio_regular,venta_detalle_precio_venta,venta_detalle_total,venta_detalle_costo,venta_detalle_utilidad,venta_detalle_descripcion,venta_codigo,producto_id) VALUES('".$venta_detalle['venta_detalle_cantidad']."','".$venta_detalle['venta_detalle_precio_compra']."','".$venta_detalle['venta_detalle_precio_regular']."','".$venta_detalle['venta_detalle_precio_venta']."','".$venta_detalle['venta_detalle_total']."','".$venta_detalle['venta_detalle_costo']."','".$venta_detalle['venta_detalle_utilidad']."','".$venta_detalle['venta_detalle_descripcion']."','$codigo_venta','".$venta_detalle['producto_id']."')";

                if(!$gbd->exec($query)){

                	$gbd->rollBack();

                    $alerta=[
	                    "Alerta"=>"simple",
	                    "Titulo"=>"Error al confirmar el pedido",
	                    "Texto"=>"No podemos procesar el pedido en este momento por favor intente nuevamente. (002)",
	                    "Icon"=>"error",
	                    "TxtBtn"=>"Aceptar"
	                ];
	                echo json_encode($alerta);
					exit();
                }
			}

			/*-- Actualizando productos - Updating products --*/
			foreach($_SESSION['carrito_sto'] as $productos){

                /*-- Obteniendo datos del producto - Obtaining product data --*/
                $check_producto=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE producto_id='".$productos['producto_id']."' AND producto_codigo='".$productos['producto_codigo']."'");

                if($check_producto->rowCount()<1){

                    $gbd->rollBack();

                    $alerta=[
	                    "Alerta"=>"simple",
	                    "Titulo"=>"Error al confirmar el pedido",
	                    "Texto"=>"No podemos procesar el pedido en este momento por favor intente nuevamente. (003)",
	                    "Icon"=>"error",
	                    "TxtBtn"=>"Aceptar"
	                ];
                    echo json_encode($alerta);
                    exit();

                }else{
                    $datos_producto=$check_producto->fetch();
                }
                $check_producto->closeCursor();
                $check_producto=mainModel::desconectar($check_producto);

                if($datos_producto['producto_tipo']=="Fisico"){

	                /*-- Calculando stock total - Calculating total stock --*/
	                $stock_total=$datos_producto['producto_stock']-$productos['venta_detalle_cantidad'];

	                if($stock_total<0){
	                	$alerta=[
		                    "Alerta"=>"simple",
		                    "Titulo"=>"Error al confirmar el pedido",
		                    "Texto"=>"No hay existencias disponibles del producto: ".$datos_producto['producto_nombre'],
		                    "Icon"=>"error",
		                    "TxtBtn"=>"Aceptar"
		                ];
	                    echo json_encode($alerta);
	                    exit();
	                }

	                /*-- Preparando consulta - Preparing query --*/
	                $query="UPDATE producto SET producto_stock='$stock_total' WHERE producto_id='".$productos['producto_id']."'";

	                if(!$gbd->exec($query)){

	                    $gbd->rollBack();

	                    $alerta=[
		                    "Alerta"=>"simple",
		                    "Titulo"=>"Error al confirmar el pedido",
		                    "Texto"=>"No podemos procesar el pedido en este momento por favor intente nuevamente. (003)",
		                    "Icon"=>"error",
		                    "TxtBtn"=>"Aceptar"
		                ];
	                    echo json_encode($alerta);
	                    exit();
	                }
                }
            }

            /*-- Actualizando efectivo en caja - Updating cash in the cash register --*/
            if($campos_caja['caja_efectivo']!=$total_caja){

                $query="UPDATE caja SET caja_efectivo='$total_caja' WHERE caja_id='$caja_id'";

                if(!$gbd->exec($query)){

                    $gbd->rollBack();

                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"No podemos procesar el pedido en este momento por favor intente nuevamente. (004)",
                        "Icon"=>"error",
	                    "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();

                }
            }

			/*-- Vaciando variables de sesion - Clearing session variables --*/
            unset($_SESSION['carrito_sto']);

            $_SESSION['venta_codigo_factura']=$codigo_venta;

            $gbd->commit();

            $alerta=[
                "Alerta"=>"recargar",
                "Titulo"=>"¡Pedido confirmado!",
                "Texto"=>"El pedido se realizó con éxito",
                "Icon"=>"success",
                "TxtBtn"=>"Aceptar"
            ];
            echo json_encode($alerta);
		} /*-- Fin controlador - End controller --*/


		/*--------- Controlador paginador pedidos - Orders Pager Controller  ---------*/
        public function paginador_pedido_controlador($pagina,$registros,$url,$busqueda){
            $pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);

			$url=mainModel::limpiar_cadena($url);

            $tipo_lista=["order-list","order-pending","order-canceled","order-search"];

			if(!in_array($url, $tipo_lista)){
				return '
                    <div class="alert alert-danger text-center" role="alert" data-mdb-color="danger">
                        <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
                        <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
                        <p class="mb-0">Lo sentimos, no podemos realizar la búsqueda ya que al parecer a ingresado un dato incorrecto.</p>
                    </div>
				';
				exit();
			}else{
				$tipo=$url;
			}

			$url=SERVERURL.DASHBOARD."/".$url."/";

            $busqueda=mainModel::limpiar_cadena($busqueda);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
            $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

            $campos="*";
            
            if(isset($busqueda) && $busqueda!="" && $tipo=="order-search"){

				$consulta_datos="SELECT $campos FROM venta INNER JOIN cliente ON venta.cliente_id=cliente.cliente_id INNER JOIN usuario ON venta.usuario_id=usuario.usuario_id WHERE venta_codigo LIKE '%$busqueda%' ORDER BY venta.venta_id DESC LIMIT $inicio,$registros";

                $consulta_total="SELECT COUNT(venta_id) FROM venta WHERE venta_codigo LIKE '%$busqueda%'";

			}elseif($tipo=="order-list"){

				$consulta_datos="SELECT $campos FROM venta INNER JOIN cliente ON venta.cliente_id=cliente.cliente_id INNER JOIN usuario ON venta.usuario_id=usuario.usuario_id ORDER BY venta.venta_id DESC LIMIT $inicio,$registros";

                $consulta_total="SELECT COUNT(venta_id) FROM venta";

			}elseif($tipo=="order-pending"){

				$consulta_datos="SELECT $campos FROM venta INNER JOIN cliente ON venta.cliente_id=cliente.cliente_id INNER JOIN usuario ON venta.usuario_id=usuario.usuario_id WHERE venta.venta_estado_estado='Pedido sin confirmar' ORDER BY venta.venta_id DESC LIMIT $inicio,$registros";

                $consulta_total="SELECT COUNT(venta_id) FROM venta WHERE venta.venta_estado_estado='Pedido sin confirmar'";

			}elseif($tipo=="order-canceled"){

				$consulta_datos="SELECT $campos FROM venta INNER JOIN cliente ON venta.cliente_id=cliente.cliente_id INNER JOIN usuario ON venta.usuario_id=usuario.usuario_id WHERE venta.venta_estado_estado='Pedido cancelado' ORDER BY venta.venta_id DESC LIMIT $inicio,$registros";

                $consulta_total="SELECT COUNT(venta_id) FROM venta WHERE venta.venta_estado_estado='Pedido cancelado'";

			}

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta_datos);
            $datos = $datos->fetchAll();

            $total = $conexion->query($consulta_total);
            $total = (int) $total->fetchColumn();

            $Npaginas =ceil($total/$registros);

            /*-- Encabezado de la tabla - Table header --*/
			$tabla.='
            <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr class="text-center font-weight-bold">
                        <th>#</th>
                        <th>Codigo</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
						<th>Vendedor</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th><i class="fas fa-tools"></i>&nbsp; Opciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
            ';

            if($total>=1 && $pagina<=$Npaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($datos as $rows){
					$tabla.='
						<tr class="text-center" >
							<td>'.$contador.'</td>
							<td>'.$rows['venta_codigo'].'</td>
							<td>'.$rows['venta_fecha'].'</td>
							<td>'.$rows['cliente_nombre'].' '.$rows['cliente_apellido'].'</td>
							<td>'.$rows['usuario_nombre'].' '.$rows['usuario_apellido'].'</td>
							<td>'.COIN_SYMBOL.number_format($rows['venta_total'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME.'</td>';

							if($rows['venta_estado_estado']=="Pedido confirmado"){
                                $tabla.='<td><span class="badge badge-info text-info btn-outline-info"><i class="far fa-check-circle fa-fw"></i>&nbsp; '.$rows['venta_estado_estado'].'</span></td>';
                            }elseif($rows['venta_estado_estado']=="Pedido sin confirmar"){
                                $tabla.='<td><span class="badge badge-warning text-warning btn-outline-warning"><i class="fas fa-history fa-fw"></i>&nbsp; '.$rows['venta_estado_estado'].'</span></td>';
                            }elseif($rows['venta_estado_estado']=="Pedido cancelado"){
                                $tabla.='<td><span class="badge badge-danger text-danger btn-outline-danger"><i class="far fa-times-circle fa-fw"></i>&nbsp; '.$rows['venta_estado_estado'].'</span></td>';
                            }

							$tabla.='<td>
                                <div class="btn-group" role="group">
								  <a class="btn btn-primary btn-sale-options" data-mdb-ripple-init data-mdb-popover-init href="'.SERVERURL.DASHBOARD.'/order-detail/'.mainModel::encryption($rows['venta_id']).'/" data-mdb-popover-initialized="true" data-mdb-trigger="hover" title="Detalle venta Nro. '.$rows['venta_id'].'" data-mdb-content="Detalles, pagos & devoluciones de venta Nro.'.$rows['venta_id'].' - código: '.$rows['venta_codigo'].'">
                                        <i class="fas fa-cart-plus fa-fw"></i>
                                    </a>
                                    <button type="button" class="btn btn-primary btn-sale-options" data-mdb-ripple-init data-mdb-popover-init onclick="print_invoice(\''.SERVERURL.'pdf/invoice.php?code='.$rows['venta_codigo'].'\')" data-mdb-popover-initialized="true" data-mdb-trigger="hover" title="Imprimir factura Nro. '.$rows['venta_id'].'" data-mdb-content="CÓDIGO: '.$rows['venta_codigo'].'">
                                        <i class="fas fa-file-invoice-dollar fa-fw"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sale-options" data-mdb-ripple-init data-mdb-popover-init onclick="print_ticket(\''.SERVERURL.'pdf/ticket_'.THERMAL_PRINT_SIZE.'mm.php?code='.$rows['venta_codigo'].'\')" data-mdb-popover-initialized="true" data-mdb-trigger="hover" title="Imprimir ticket Nro. '.$rows['venta_id'].'" data-mdb-content="CÓDIGO: '.$rows['venta_codigo'].'">
                                        <i class="fas fa-receipt fa-fw"></i>
                                    </button>
								</div>
							</td>
						</tr>
					';
					$contador++;
				}
				$pag_final=$contador-1;
			}else{
				if($total>=1){
					$tabla.='
						<tr class="text-center" >
							<td colspan="8">
								<a href="'.$url.'" class="btn btn-primary btn-sm">
									Haga clic acá para recargar el listado
								</a>
							</td>
						</tr>
					';
				}else{
					$tabla.='
						<tr class="text-center" >
							<td colspan="8">
								No hay registros en el sistema
							</td>
						</tr>
					';
				}
			}

            $tabla.='</tbody></table></div>';

			if($total>0 && $pagina<=$Npaginas){
				$tabla.='<hr><p class="text-end">Mostrando pedidos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
			}

			/*--Paginacion - Pagination --*/
			if($total>=1 && $pagina<=$Npaginas){
				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7,LANG);
			}

			return $tabla;
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador actualizar pedidos - Update orders Controller  ---------*/
        public function actualizar_pedido_controlador(){

        	/*-- Comprobando privilegios - Checking privileges --*/
            if($_SESSION['cargo_sto']!="Administrador"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Acceso no permitido",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Recuperando id del pedido - Retrieving order id - --*/
            $id=mainModel::decryption($_POST['pedido_id_up']);
            $id=mainModel::limpiar_cadena($id);

            /*-- Comprobando pedido en la DB - Checking order in DB --*/
            $check_pedido=mainModel::ejecutar_consulta_simple("SELECT * FROM venta WHERE venta_id='$id'");
            if($check_pedido->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Pedido no encontrado",
                    "Texto"=>"No hemos encontrado el pedido en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }
            $check_pedido->closeCursor();
            $check_pedido=mainModel::desconectar($check_pedido);

            /*-- Recibiendo datos del formulario - Receiving form data --*/
            $estado=mainModel::limpiar_cadena($_POST['venta_estado_estado']);
            $envio=mainModel::limpiar_cadena($_POST['venta_estado_envio']);

            /*-- Comprobando campos vacios - Checking empty fields --*/
            if($estado=="" || $envio==""){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No has llenado todos los campos que son obligatorios",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Comprobando estado - Checking status --*/
            if($estado!="Pedido confirmado" && $estado!="Pedido sin confirmar"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Opción no valida",
                    "Texto"=>"Ha seleccionado un ESTADO no valido",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Comprobando envio - Checking shipment --*/
            if($envio!="Pedido enviado" && $envio!="Pendiente de envío"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Opción no valida",
                    "Texto"=>"Ha seleccionado un ENVIO no valido",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Preparando datos para enviarlos al modelo - Preparing data to send to the model --*/
            $datos_pedido_up=[
                "venta_estado_estado"=>[
                    "campo_marcador"=>":Estado",
                    "campo_valor"=>$estado
                ],
                "venta_estado_envio"=>[
                    "campo_marcador"=>":Envio",
                    "campo_valor"=>$envio
                ]
            ];

            $condicion=[
                "condicion_campo"=>"venta_id",
                "condicion_marcador"=>":ID",
                "condicion_valor"=>$id
            ];

            if(mainModel::actualizar_datos("venta",$datos_pedido_up,$condicion)){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"¡Pedido actualizado!",
                    "Texto"=>"Los datos del pedido se actualizaron con éxito en el sistema",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido actualizar los datos del pedido, por favor intente nuevamente",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
            }
            echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador agregar pago - Add payment Controller  ---------*/
        public function agregar_pago_pedido_controlador(){

        	/*-- Comprobando privilegios - Checking privileges --*/
            if($_SESSION['cargo_sto']!="Administrador"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Acceso no permitido",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Recuperando id del pedido - Retrieving order id - --*/
            $id=mainModel::decryption($_POST['pedido_id_up']);
            $id=mainModel::limpiar_cadena($id);

            /*-- Comprobando pedido en la DB - Checking order in DB --*/
            $check_pedido=mainModel::ejecutar_consulta_simple("SELECT * FROM venta WHERE venta_id='$id'");
            if($check_pedido->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Pedido no encontrado",
                    "Texto"=>"No hemos encontrado el pedido en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }else{
            	$campos_pedido=$check_pedido->fetch();
            }
            $check_pedido->closeCursor();
            $check_pedido=mainModel::desconectar($check_pedido);

            /*-- Comprobando estado del pedido - Checking order status --*/
            if($campos_pedido['venta_estado_pagado']=="Pagada" && $campos_pedido['venta_pagado']>=$campos_pedido['venta_total']){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El pedido ya se encuentra pagado totalmente",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Recibiendo datos del formulario - Receiving form data --*/
            $monto=mainModel::limpiar_cadena($_POST['pago_monto']);
            $caja_id=mainModel::limpiar_cadena($_POST['pago_caja']);

            /*-- Comprobando campos vacios - Checking empty fields --*/
            if($monto=="" || $caja_id==""){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No has llenado todos los campos que son obligatorios",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Verificando integridad de los datos - Checking data integrity --*/
            if(mainModel::verificar_datos("[0-9.]{1,25}",$monto)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Formato no valido",
                    "Texto"=>"El MONTO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Comprobando monto - Checking amount --*/
            if($monto<=0){
            	$alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Cantidad no valida",
                    "Texto"=>"El monto no puede ser menor o igual a 0, debe de introducir una cantidad valida",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Comprobando caja en la DB - Checking cash register in DB --*/
            $check_caja=mainModel::ejecutar_consulta_simple("SELECT * FROM caja WHERE caja_id='$caja_id'");
            if($check_caja->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Caja no encontrada",
                    "Texto"=>"No hemos encontrado la caja en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $campos_caja=$check_caja->fetch();
            }
            $check_caja->closeCursor();
            $check_caja=mainModel::desconectar($check_caja);

            /*-- Calculando el cambio y total pagado - Calculating the change and total paid --*/
            $venta_pendiente=$campos_pedido['venta_total']-$campos_pedido['venta_pagado'];
            $venta_cambio=0;
            $venta_pagado=$campos_pedido['venta_pagado']+$monto;

            if($venta_pendiente>$monto){
            	$venta_estado_pagado="Pendiente de pago";
            }else{
            	if($monto>=$venta_pendiente){
            		$venta_cambio=$monto-$venta_pendiente;
            	}
            	$venta_estado_pagado="Pagada";
            }

            $caja_efectivo=$campos_caja['caja_efectivo']+($monto-$venta_cambio);

            /*-- Formateando variables - Formatting variables --*/
            $monto=number_format($monto,COIN_DECIMALS,'.','');
            $venta_pendiente=number_format($venta_pendiente,COIN_DECIMALS,'.','');
            $venta_cambio=number_format($venta_cambio,COIN_DECIMALS,'.','');
            $venta_pagado=number_format($venta_pagado,COIN_DECIMALS,'.','');
            $caja_efectivo=number_format($caja_efectivo,COIN_DECIMALS,'.','');


            /*-- Conectando a bd y activando transacciones - Connecting to database and activating transactions --*/
            $gbd=mainModel::conectar();
            $gbd->beginTransaction();

            /*-- Actualizando datos del pedido - Updating order data --*/
            $query="UPDATE venta SET venta_estado_pagado='$venta_estado_pagado',venta_pagado='$venta_pagado',venta_cambio='$venta_cambio' WHERE venta_id='$id'";

            if(!$gbd->exec($query)){

                $gbd->rollBack();

                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No podemos procesar el pago en este momento por favor intente nuevamente. (001)",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();

            }

            /*-- Actualizando efectivo en caja - Updating cash in the cash register --*/
            $query="UPDATE caja SET caja_efectivo='$caja_efectivo' WHERE caja_id='$caja_id'";

            if(!$gbd->exec($query)){

                $gbd->rollBack();

                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No podemos procesar el pago en este momento por favor intente nuevamente. (002)",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();

            }

            $gbd->commit();

            $alerta=[
                "Alerta"=>"recargar",
                "Titulo"=>"¡Pago realizado!",
                "Texto"=>"El pago se realizó con éxito",
                "Icon"=>"success",
                "TxtBtn"=>"Aceptar"
            ];
            echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador cancelar pedido - Cancel order Controller  ---------*/
        public function cancelar_pedido_controlador(){

        	/*-- Comprobando privilegios - Checking privileges --*/
            if($_SESSION['cargo_sto']!="Administrador"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Acceso no permitido",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Recuperando id del pedido - Retrieving order id - --*/
            $id=mainModel::decryption($_POST['pedido_id']);
            $id=mainModel::limpiar_cadena($id);

            /*-- Comprobando pedido en la DB - Checking order in DB --*/
            $check_pedido=mainModel::ejecutar_consulta_simple("SELECT * FROM venta WHERE venta_id='$id'");
            if($check_pedido->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Pedido no encontrado",
                    "Texto"=>"No hemos encontrado el pedido en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }else{
            	$campos_pedido=$check_pedido->fetch();
            }
            $check_pedido->closeCursor();
            $check_pedido=mainModel::desconectar($check_pedido);

            /*-- Comprobando estado del pedido - Checking order status --*/
            if($campos_pedido['venta_estado_estado']=="Pedido cancelado"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El pedido ya se encuentra cancelado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Comprobando caja en la DB - Checking cash register in DB --*/
            $check_caja=mainModel::ejecutar_consulta_simple("SELECT * FROM caja WHERE caja_id='".$campos_pedido['caja_id']."'");
            if($check_caja->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Caja no encontrada",
                    "Texto"=>"No hemos encontrado la caja en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $campos_caja=$check_caja->fetch();
            }
            $check_caja->closeCursor();
            $check_caja=mainModel::desconectar($check_caja);

            /*-- Formateando variables - Formatting variables --*/
            $venta_estado_envio="Envío cancelado";
            $venta_estado_pagado="Pendiente de pago";
            $venta_estado_estado="Pedido cancelado";

            $venta_pagado=number_format(0,COIN_DECIMALS,'.','');
            $venta_cambio=number_format(0,COIN_DECIMALS,'.','');

            $caja_efectivo=$campos_caja['caja_efectivo']-($campos_pedido['venta_pagado']-$campos_pedido['venta_cambio']);
            if($caja_efectivo<0){ $caja_efectivo=0; }
            $caja_efectivo=number_format($caja_efectivo,COIN_DECIMALS,'.','');

            /*-- Conectando a bd y activando transacciones - Connecting to database and activating transactions --*/
            $gbd=mainModel::conectar();
            $gbd->beginTransaction();

            /*-- Actualizando datos del pedido - Updating order data --*/
            $query="UPDATE venta SET venta_estado_envio='$venta_estado_envio',venta_estado_pagado='$venta_estado_pagado',venta_estado_estado='$venta_estado_estado',venta_pagado='$venta_pagado',venta_cambio='$venta_cambio' WHERE venta_id='$id'";

            if(!$gbd->exec($query)){

                $gbd->rollBack();

                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No podemos procesar la cancelación en este momento por favor intente nuevamente. (001)",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();

            }

            /*-- Actualizando efectivo en caja - Updating cash in the cash register --*/
            if($campos_pedido['venta_pagado']>0 && $caja_efectivo!=$campos_caja['caja_efectivo']){

                $query="UPDATE caja SET caja_efectivo='$caja_efectivo' WHERE caja_id='".$campos_pedido['caja_id']."'";

                if(!$gbd->exec($query)){

                    $gbd->rollBack();

                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"No podemos procesar la cancelación en este momento por favor intente nuevamente. (002)",
                        "Icon"=>"error",
	                    "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();

                }
            }

            /*-- Actualizando productos - Updating products --*/
            $check_detalles=mainModel::ejecutar_consulta_simple("SELECT * FROM venta_detalle WHERE venta_codigo='".$campos_pedido['venta_codigo']."'");
            $check_detalles=$check_detalles->fetchAll();

			foreach($check_detalles as $productos){

                /*-- Obteniendo datos del producto - Obtaining product data --*/
                $check_producto=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE producto_id='".$productos['producto_id']."'");

                if($check_producto->rowCount()<1){

                    $gbd->rollBack();

                    $alerta=[
	                    "Alerta"=>"simple",
	                    "Titulo"=>"Error al confirmar el pedido",
	                    "Texto"=>"No podemos procesar la cancelación en este momento por favor intente nuevamente. (003)",
	                    "Icon"=>"error",
	                    "TxtBtn"=>"Aceptar"
	                ];
                    echo json_encode($alerta);
                    exit();

                }else{
                    $datos_producto=$check_producto->fetch();
                }
                $check_producto->closeCursor();
                $check_producto=mainModel::desconectar($check_producto);

                if($datos_producto['producto_tipo']=="Fisico"){

	                /*-- Calculando stock total - Calculating total stock --*/
	                $stock_total=$datos_producto['producto_stock']+$productos['venta_detalle_cantidad'];

	                /*-- Preparando consulta - Preparing query --*/
	                $query="UPDATE producto SET producto_stock='$stock_total' WHERE producto_id='".$productos['producto_id']."'";

	                if(!$gbd->exec($query)){

	                    $gbd->rollBack();

	                    $alerta=[
		                    "Alerta"=>"simple",
		                    "Titulo"=>"Error al confirmar el pedido",
		                    "Texto"=>"No podemos procesar la cancelación en este momento por favor intente nuevamente. (003)",
		                    "Icon"=>"error",
		                    "TxtBtn"=>"Aceptar"
		                ];
	                    echo json_encode($alerta);
	                    exit();
	                }
                }
            }

            $gbd->commit();

            $alerta=[
                "Alerta"=>"recargar",
                "Titulo"=>"¡Pedido cancelado!",
                "Texto"=>"El pedido se canceló con éxito",
                "Icon"=>"success",
                "TxtBtn"=>"Aceptar"
            ];
            echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/

	}