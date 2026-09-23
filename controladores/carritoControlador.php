<?php

    require_once __DIR__."/../modelos/mainModel.php";

	class carritoControlador extends mainModel{


		/*--------- Controlador agregar producto - Controller add product ---------*/
        public function agregar_producto_carrito_controlador(){

        	/*-- Recibiendo id del producto - Receiving product id --*/
        	$id=mainModel::decryption($_POST['producto_id']);
        	$id=mainModel::limpiar_cadena($id);

        	/*-- Comprobando producto en la DB - Checking product in DB --*/
			$check_producto=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE producto_id='$id'");
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

			/*-- Recibiendo datos del formulario - Receiving form data --*/
			$cantidad=mainModel::limpiar_cadena($_POST['producto_cantidad']);

			/*-- Comprobando campos vacios - Checking empty fields --*/
            if($cantidad==""){
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
            if(mainModel::verificar_datos("[0-9]{1,10}",$cantidad)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"La CANTIDAD no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Verificando que la cantidad sea mayor a 0 - Checking that the amount is greater than 0 --*/
            if($cantidad<=0){
            	$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Cantidad no valida",
					"Texto"=>"Debe de introducir una cantidad mayor a 0",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Verificando el stock del producto - Checking product stock --*/
            if($campos['producto_tipo']=="Fisico"){
	            if($campos['producto_stock']<$cantidad){
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

            /*-- Verificando producto en el carrito - Checking product in cart --*/
            if(empty($_SESSION['carrito_sto'][$id])){
            	
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
					"Alerta"=>"recargar",
					"Titulo"=>"Producto agregado al carrito",
					"Texto"=>"El producto se agregó correctamente al carrito",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
				];

            }else{
            	$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Producto en carrito",
					"Texto"=>"Este producto ya esta agregado en el carrito",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
            }

            echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador remover producto - Controller remove product ---------*/
        public function remover_producto_carrito_controlador(){

        	/*-- Recibiendo id del producto - Receiving product id --*/
        	$id=mainModel::decryption($_POST['producto_id']);
        	$id=mainModel::limpiar_cadena($id);

        	unset($_SESSION['carrito_sto'][$id]);

        	/*-- Verificando producto en el carrito - Checking product in cart --*/
            if(empty($_SESSION['carrito_sto'][$id])){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Producto removido!",
					"Texto"=>"Producto removido correctamente del carrito.",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
				];
            }else{
            	$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido remover el producto, por favor intente nuevamente.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
            }
            echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador actualizar producto - Controller update product ---------*/
        public function actualizar_producto_carrito_controlador(){

        	/*-- Recuperando codigo & cantidad del producto - Retrieving product code and quantity --*/
            $codigo=mainModel::limpiar_cadena($_POST['producto_codigo']);
            $cantidad=mainModel::limpiar_cadena($_POST['producto_cantidad']);
            $view_url=mainModel::limpiar_cadena($_POST['view_url']);

            /*-- Comprobando campos vacios - Checking empty fields --*/
            if($codigo=="" || $cantidad==""){
		        $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos actualizar la cantidad de productos debido a que faltan algunos parámetros de configuración",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Comprobando cantidad de productos - Checking quantity of products --*/
            if($cantidad<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Debes de introducir una cantidad mayor a 0",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				return json_encode($alerta);
		        exit();
            }

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

			$id=$campos['producto_id'];

			/*-- Comprobando producto en carrito - Checking product in cart --*/
            if(!empty($_SESSION['carrito_sto'][$id])){

            	if($_SESSION['carrito_sto'][$id]["venta_detalle_cantidad"]==$cantidad){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No has modificado la cantidad de productos",
	                    "Icon"=>"error",
	                    "TxtBtn"=>"Aceptar"
					];
					return json_encode($alerta);
			        exit();
                }

                if($cantidad>$_SESSION['carrito_sto'][$id]["venta_detalle_cantidad"]){
                    $diferencia_productos="<i class='far fa-check-circle fa-fw'></i> Se agrego +".($cantidad-$_SESSION['carrito_sto'][$id]["venta_detalle_cantidad"]);
                }else{
                    $diferencia_productos="<i class='far fa-times-circle fa-fw'></i> Se quito -".($_SESSION['carrito_sto'][$id]["venta_detalle_cantidad"]-$cantidad);
                }

                $detalle_cantidad=$cantidad;

                $stock_total=$campos['producto_stock']-$detalle_cantidad;

                if($stock_total<0 && $campos['producto_tipo']=="Fisico"){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Lo sentimos, no hay existencias suficientes del producto seleccionado. Existencias disponibles: ".($stock_total+$detalle_cantidad)."",
	                    "Icon"=>"error",
	                    "TxtBtn"=>"Aceptar"
					];
					return json_encode($alerta);
			        exit();
                }

                $precio_venta=$_SESSION['carrito_sto'][$id]['venta_detalle_precio_venta'];
                
                $detalle_total=$detalle_cantidad*$precio_venta;
                $detalle_total=number_format($detalle_total,COIN_DECIMALS,'.','');

                $detalle_subtotal=$detalle_total/(($datos_empresa['empresa_impuesto_porcentaje']/100)+1);
	            $detalle_subtotal=number_format($detalle_subtotal,COIN_DECIMALS,'.','');

	            $detalle_impuestos=$detalle_total-$detalle_subtotal;
	            $detalle_impuestos=number_format($detalle_impuestos,COIN_DECIMALS,'.','');

                $detalle_costos=$campos['producto_precio_compra']*$detalle_cantidad;
                $detalle_costos=number_format($detalle_costos,COIN_DECIMALS,'.','');

                $detalle_utilidad=$detalle_total-$detalle_costos;
                $detalle_utilidad=number_format($detalle_utilidad,COIN_DECIMALS,'.','');

                $_SESSION['carrito_sto'][$id]=[
                    "producto_id"=>$id,
                    "venta_detalle_cantidad"=>$detalle_cantidad,
					"producto_codigo"=>$campos['producto_codigo'],
                    "venta_detalle_precio_compra"=>$campos['producto_precio_compra'],
                    "venta_detalle_precio_regular"=>$campos['producto_precio_venta'],
                    "venta_detalle_precio_venta"=>$precio_venta,
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

                if($view_url=="dashboard"){
                	$_SESSION['alerta_producto_agregado']="$diferencia_productos <strong>".$campos['producto_nombre']."</strong> al carrito. Total en carrito <strong>$detalle_cantidad</strong>";

	                $alerta=[
						"Alerta"=>"redireccionar",
						"URL"=>SERVERURL.DASHBOARD."/order-new/"
					];
                }else{
	                $_SESSION['alerta_producto_agregado_carrito']="$diferencia_productos <strong>".$campos['producto_nombre']."</strong> al carrito. Total en carrito <strong>$detalle_cantidad</strong>";

	                $alerta=[
						"Alerta"=>"redireccionar",
						"URL"=>SERVERURL."bag/"
					];
                }

				return json_encode($alerta);
            }else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos encontrado el producto que desea actualizar en el carrito",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];

				return json_encode($alerta);
            }

        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador guardar pedido - Controller save order ---------*/
        public function guardar_pedido_cliente_controlador(){

        	/*-- Comprobando tipo de usuario - Checking user type --*/
        	if($_SESSION['tipo_sto']!="Cliente"){
        		$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos procesar el pedido en este momento",
					"Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
        	}

        	/*-- Comprobando cliente en la DB - Checking client in DB --*/
			$check_cliente=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_id='".$_SESSION['cliente_id_sto']."'");
			if($check_cliente->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Cuenta no encontrada",
					"Texto"=>"No hemos encontrado la cuenta en el sistema",
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

            $venta_pagado=number_format(0,COIN_DECIMALS,'.','');

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
            $query="INSERT INTO venta (venta_codigo,venta_fecha,venta_hora,venta_tipo_envio,venta_impuesto_nombre,venta_impuesto_porcentaje,venta_estado_envio,venta_estado_pagado,venta_estado_estado,venta_subtotal,venta_impuestos,venta_total,venta_costo,venta_utilidad,venta_pagado,venta_cambio,cliente_id,usuario_id,empresa_id,caja_id) VALUES('$codigo_venta','$venta_fecha','$venta_hora','Contra Entrega','$venta_impuesto_nombre','$venta_impuesto_porcentaje','Pendiente de envío','Pendiente de pago','Pedido sin confirmar','$venta_subtotal','$venta_impuestos','$venta_total','$venta_costo','$venta_utilidad','0.00','0.00','".$_SESSION['cliente_id_sto']."','1','".$campos_empresa['empresa_id']."','1')";

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

			/*-- Vaciando variables de sesion - Clearing session variables --*/
            unset($_SESSION['carrito_sto']);

            $_SESSION['pedido_codigo_factura']=$codigo_venta;

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


        /*--------- Controlador paginador pedidos - Orders Pager Controller ---------*/
        public function paginador_pedido_controlador($pagina,$registros,$url,$busqueda){
            $pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);

			$url=mainModel::limpiar_cadena($url);
			$url=SERVERURL.$url."/";

            $busqueda=mainModel::limpiar_cadena($busqueda);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
            $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
            
            if(isset($busqueda) && $busqueda!=""){

				$consulta_datos="SELECT * FROM venta WHERE (cliente_id='".$_SESSION['cliente_id_sto']."') AND (venta_codigo LIKE '%$busqueda%') ORDER BY venta_id DESC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(venta_id) FROM venta WHERE (cliente_id='".$_SESSION['cliente_id_sto']."') AND (venta_codigo LIKE '%$busqueda%')";

			}else{

				$consulta_datos="SELECT * FROM venta WHERE cliente_id='".$_SESSION['cliente_id_sto']."' ORDER BY venta_id DESC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(venta_id) FROM venta WHERE cliente_id='".$_SESSION['cliente_id_sto']."'";

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
                        <th>Código</th>
                        <th>Fecha</th>
                        <th>Tipo de envío</th>
                        <th>Estado de envío</th>
                        <th>Estado de pedido</th>
                        <th>Detalles</th>
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
							<td>'.date("d-m-Y", strtotime($rows['venta_fecha'])).'</td>
							<td>'.$rows['venta_tipo_envio'].'</td>';

							if($rows['venta_estado_envio']=="Pedido enviado"){
								$tabla.='<td><span class="chip btn-outline-primary"><i class="fas fa-shipping-fast fa-fw"></i> &nbsp;'.$rows['venta_estado_envio'].'</span></td>';
							}elseif($rows['venta_estado_envio']=="Pendiente de envío"){
								$tabla.='<td><span class="chip btn-outline-warning"><i class="fas fa-truck-loading fa-fw"></i> &nbsp;'.$rows['venta_estado_envio'].'</span></td>';
							}elseif($rows['venta_estado_envio']=="Envío cancelado"){
								$tabla.='<td><span class="chip btn-outline-danger"><i class="far fa-times-circle fa-fw"></i> &nbsp;'.$rows['venta_estado_envio'].'</span></td>';
							}


							if($rows['venta_estado_estado']=="Pedido confirmado"){
								$tabla.='<td><span class="chip btn-outline-primary"><i class="far fa-check-circle fa-fw"></i> &nbsp;'.$rows['venta_estado_estado'].'</span></td>';
							}elseif($rows['venta_estado_estado']=="Pedido sin confirmar"){
								$tabla.='<td><span class="chip btn-outline-warning"><i class="far fa-clock fa-fw"></i> &nbsp;'.$rows['venta_estado_estado'].'</span></td>';
							}elseif($rows['venta_estado_estado']=="Pedido cancelado"){
								$tabla.='<td><span class="chip btn-outline-danger"><i class="far fa-times-circle fa-fw"></i> &nbsp;'.$rows['venta_estado_estado'].'</span></td>';
							}
							

							$tabla.='<td><a class="btn btn-link text-info" href="'.SERVERURL.'orders-details/'.mainModel::encryption($rows['venta_id']).'/"><i class="fas fa-shopping-bag fa-fw"></i> &nbsp; Detalles</a></td>
						</tr>
					';
					$contador++;
				}
				$pag_final=$contador-1;
			}else{
				if($total>=1){
					$tabla.='
						<tr class="text-center" >
							<td colspan="7">
								<a href="'.$url.'" class="btn btn-primary btn-sm">
									Haga clic acá para recargar el listado
								</a>
							</td>
						</tr>
					';
				}else{
					$tabla.='
						<tr class="text-center" >
							<td colspan="7">
								No hay registros en el sistema
							</td>
						</tr>
					';
				}
			}

            $tabla.='</tbody></table></div>';

			if($total>0 && $pagina<=$Npaginas){
				$tabla.='<p class="text-end">Mostrando pedidos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
			}

			/*--Paginacion - Pagination --*/
			if($total>=1 && $pagina<=$Npaginas){
				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7,LANG);
			}

			return $tabla;
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador agregar/quitar favoritos - Add/Remove favorites Controller ---------*/
        public function favoritos_controlador(){

        	/*-- Recuperando ID de cliente & producto - Retrieve customer and product ID --*/
        	$accion=mainModel::limpiar_cadena($_POST['accion']);
            $cliente_id=mainModel::limpiar_cadena($_POST['cliente_id']);
            $producto_id=mainModel::limpiar_cadena($_POST['producto_id']);

            /*-- Comprobando producto en la DB - Checking product in DB --*/
            $check_producto=mainModel::ejecutar_consulta_simple("SELECT producto_id FROM producto WHERE producto_id='$producto_id'");
            if($check_producto->rowCount()<=0){
            	$alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos encontrado el producto registrado en el sistema.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
            }
			$check_producto->closeCursor();
			$check_producto=mainModel::desconectar($check_producto);


			/*-- Comprobando cliente en la DB - Checking client in DB --*/
			$check_cliente=mainModel::ejecutar_consulta_simple("SELECT cliente_id FROM cliente WHERE cliente_id='$cliente_id'");
			if($check_cliente->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Cuenta no encontrada",
					"Texto"=>"No hemos encontrado su cuenta en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_cliente->closeCursor();
			$check_cliente=mainModel::desconectar($check_cliente);


			if($accion=="Add"){

				/*-- Comprobando favorito en BD - Checking favorite in DB --*/
				$check_favorito=mainModel::ejecutar_consulta_simple("SELECT favorito_id FROM favorito WHERE cliente_id='$cliente_id' AND producto_id='$producto_id'");
				if($check_favorito->rowCount()>=1){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El producto ya se encuentra agregado a favoritos",
	                    "Icon"=>"error",
	                    "TxtBtn"=>"Aceptar"
					];
					echo json_encode($alerta);
					exit();
				}
				$check_favorito->closeCursor();
				$check_favorito=mainModel::desconectar($check_favorito);


				/*-- Preparando datos para enviarlos al modelo - Preparing data to send to the model --*/
	            $datos_favorito=[
	                "favorito_fecha"=>[
						"campo_marcador"=>":Fecha",
						"campo_valor"=>date("Y-m-d")
					],
	                "cliente_id"=>[
						"campo_marcador"=>":Cliente",
						"campo_valor"=>$cliente_id
					],
	                "producto_id"=>[
						"campo_marcador"=>":Producto",
						"campo_valor"=>$producto_id
					]
				];

				/*-- Guardando datos del producto - Saving product data --*/
				$agregar_favorito=mainModel::guardar_datos("favorito",$datos_favorito);

				if($agregar_favorito->rowCount()==1){
	                $alerta=[
	                    "Alerta"=>"simple",
	                    "Titulo"=>"¡Favorito agregado!",
	                    "Texto"=>"Producto agregado a favoritos con éxito",
	                    "Icon"=>"success",
	                    "TxtBtn"=>"Aceptar"
	                ];
				}else{
	                $alerta=[
	                    "Alerta"=>"simple",
	                    "Titulo"=>"Ocurrió un error inesperado",
	                    "Texto"=>"No hemos podido agregar el producto a favoritos, por favor intente nuevamente",
	                    "Icon"=>"error",
	                    "TxtBtn"=>"Aceptar"
	                ];
				}

				$agregar_favorito->closeCursor();
				$agregar_favorito=mainModel::desconectar($agregar_favorito);

			}elseif($accion=="Delete"){

				/*-- Eliminando favorito - Deleting favorite --*/
				$eliminar_favorito=mainModel::ejecutar_consulta_simple("DELETE FROM favorito WHERE cliente_id='$cliente_id' AND producto_id='$producto_id'");

				if($eliminar_favorito->rowCount()>=1){
					$alerta=[
	                    "Alerta"=>"simple",
	                    "Titulo"=>"¡Favorito eliminado!",
	                    "Texto"=>"Producto eliminado de favoritos con éxito",
	                    "Icon"=>"success",
	                    "TxtBtn"=>"Aceptar"
	                ];
				}else{
					$alerta=[
	                    "Alerta"=>"simple",
	                    "Titulo"=>"Ocurrió un error inesperado",
	                    "Texto"=>"No hemos podido eliminar el producto de favoritos, por favor intente nuevamente",
	                    "Icon"=>"error",
	                    "TxtBtn"=>"Aceptar"
	                ];
				}

				$eliminar_favorito->closeCursor();
				$eliminar_favorito=mainModel::desconectar($eliminar_favorito);

			}

			echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador paginador de favoritos - Favorites Pagination Controller ---------*/
        public function paginador_favorito_controlador($pagina,$registros,$url,$orden,$categoria,$busqueda){
        	$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);

			$url=mainModel::limpiar_cadena($url);
            $orden=mainModel::limpiar_cadena($orden);
            $categoria=mainModel::limpiar_cadena($categoria);
            $busqueda=mainModel::limpiar_cadena($busqueda);
            $url=SERVERURL.$url."/".$categoria."/";
			$tabla="";


            /*-- Lista blanca para orden de busqueda - Whitelist for search order --*/
            $orden_lista=["ASC","DESC","MAX","MIN"];

			if(!in_array($orden, $orden_lista)){
				return '
                    <div class="alert alert-danger text-center" role="alert" data-mdb-color="danger">
                        <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
                        <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
                        <p class="mb-0">Lo sentimos, no podemos realizar la búsqueda de productos ya que al parecer a ingresado un dato incorrecto.</p>
                    </div>
				';
				exit();
			}

            /*-- Estableciendo orden de busqueda - Establishing search order --*/
            if($orden=="ASC" || $orden=="DESC"){
                $campo_orden="producto.producto_nombre $orden";
            }elseif($orden=="MAX" || $orden=="MIN"){
                if($orden=="MAX"){
                    $campo_orden="producto.producto_precio_venta DESC";
                }else{
                    $campo_orden="producto.producto_precio_venta ASC";
                }
            }else{
                $campo_orden="producto.producto_nombre ASC";
            }
            
            /*-- Comprobando categoria - Checking category --*/
            if($categoria!="all"){
                $check_categoria=mainModel::ejecutar_consulta_simple("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria' AND categoria_estado='Habilitada'");
                if($check_categoria->rowCount()<=0){
                    return '
                        <div class="alert alert-danger text-center" role="alert" data-mdb-color="danger">
                            <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
                            <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
                            <p class="mb-0">Lo sentimos, no podemos realizar la búsqueda de productos ya que al parecer a ingresado una categoría incorrecta.</p>
                        </div>
                    ';
                    exit();
                }
                $check_categoria->closeCursor();
                $check_categoria=mainModel::desconectar($check_categoria);
            }
            

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
            $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;


            $campos="*";
            
            if(isset($busqueda) && $busqueda!=""){

                if($categoria!="all"){
                    $condicion_busqueda="producto.categoria_id='$categoria' AND";
                }else{
                    $condicion_busqueda="";
                }

				$consulta_datos="SELECT $campos FROM favorito INNER JOIN producto ON producto.producto_id=favorito.producto_id WHERE $condicion_busqueda producto.producto_estado='Habilitado' AND producto.producto_stock>0 AND producto.producto_nombre LIKE '%$busqueda%' AND favorito.cliente_id='".$_SESSION['cliente_id_sto']."' ORDER BY $campo_orden LIMIT $inicio,$registros";

                $consulta_total="SELECT COUNT(favorito_id) FROM favorito INNER JOIN producto ON producto.producto_id=favorito.producto_id WHERE $condicion_busqueda producto.producto_estado='Habilitado' AND producto.producto_stock>0 AND producto.producto_nombre LIKE '%$busqueda%' AND favorito.cliente_id='".$_SESSION['cliente_id_sto']."'";

			}elseif($categoria!="all"){

				$consulta_datos="SELECT $campos FROM favorito INNER JOIN producto ON producto.producto_id=favorito.producto_id WHERE producto.producto_estado='Habilitado' AND producto.categoria_id='$categoria' AND producto.producto_stock>0 AND favorito.cliente_id='".$_SESSION['cliente_id_sto']."' ORDER BY $campo_orden LIMIT $inicio,$registros";

                $consulta_total="SELECT COUNT(favorito_id) FROM favorito INNER JOIN producto ON producto.producto_id=favorito.producto_id WHERE producto.producto_estado='Habilitado' AND producto.categoria_id='$categoria' AND producto.producto_stock>0 AND favorito.cliente_id='".$_SESSION['cliente_id_sto']."'";

			}else{

				$consulta_datos="SELECT $campos FROM favorito INNER JOIN producto ON producto.producto_id=favorito.producto_id WHERE producto.producto_estado='Habilitado' AND producto.producto_stock>0 AND favorito.cliente_id='".$_SESSION['cliente_id_sto']."' ORDER BY $campo_orden LIMIT $inicio,$registros";

                $consulta_total="SELECT COUNT(favorito_id) FROM favorito INNER JOIN producto ON producto.producto_id=favorito.producto_id WHERE producto.producto_estado='Habilitado' AND producto.producto_stock>0 AND favorito.cliente_id='".$_SESSION['cliente_id_sto']."'";

			}

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta_datos);
            $datos = $datos->fetchAll();

            $total = $conexion->query($consulta_total);
            $total = (int) $total->fetchColumn();

            $Npaginas =ceil($total/$registros);

            $tabla.='<div class="container-cards full-box">';

            if($total>=1 && $pagina<=$Npaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($datos as $rows){

                    $total_price=$rows['producto_precio_venta']-($rows['producto_precio_venta']*($rows['producto_descuento']/100));

					$tabla.='
                        <div class="card-product div-bordered bg-white shadow-2">
                            <figure class="card-product-img">';
                                if(is_file("./vistas/assets/product/cover/".$rows['producto_portada'])){
                                    $tabla.='<img src="'.SERVERURL.'vistas/assets/product/cover/'.$rows['producto_portada'].'" class="img-fluid" alt="'.$rows['producto_nombre'].'" />';
                                }else{
                                    $tabla.='<img src="'.SERVERURL.'vistas/assets/product/cover/default.jpg" class="img-fluid" alt="'.$rows['producto_nombre'].'" />';
                                }
                            $tabla.='</figure>
                            <div class="card-product-body">
                                <div class="card-product-content scroll">
                                    <h5 class="text-center fw-bolder">'.mainModel::limitar_cadena($rows['producto_nombre'],70,"...").'</h5>
                                    <p class="card-product-price text-center fw-bolder">'.COIN_SYMBOL.number_format($total_price,COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME.'</p>';
                                    if($rows['producto_tipo']=="Fisico"){
                                        $tabla.='<span class="full-box text-center text-muted" style="display: block;">En stock: '.$rows['producto_stock'].'</span>';
                                    }
                                $tabla.='</div>
                                <div class="text-center card-product-options" style="padding: 10px 0;">
                                    <a href="'.SERVERURL.'details/'.mainModel::encryption($rows['producto_id']).'/" class="btn btn-link btn-sm btn-rounded" ><i class="fas fa-box-open fa-fw"></i> &nbsp; Más detalles</a>
                                    &nbsp; &nbsp;';

                                    if(isset($_SESSION['cliente_id_sto']) && ($_SESSION['cliente_id_sto']>0)){

                                        $check_favorite=$conexion->query("SELECT favorito_id FROM favorito WHERE cliente_id='".$_SESSION['cliente_id_sto']."' AND producto_id='".$rows['producto_id']."'");

                                        if($check_favorite->rowCount()>=1){
                                            $tabla.='<button type="button" class="btn btn-link" onclick="add_favorite(\'Delete\','.$rows['producto_id'].','.$_SESSION['cliente_id_sto'].',\'fav_button_'.$rows['producto_id'].'\')" id="fav_button_'.$rows['producto_id'].'" ><i class="fas fa-heart fa-fw" ></i> &nbsp; Quitar</button>';
                                        }else{
                                            $tabla.='<button type="button" class="btn btn-link" onclick="add_favorite(\'Add\','.$rows['producto_id'].','.$_SESSION['cliente_id_sto'].',\'fav_button_'.$rows['producto_id'].'\')" id="fav_button_'.$rows['producto_id'].'" ><i class="far fa-heart fa-fw" ></i> &nbsp; Agregar</button>';
                                        }
                                    }
                                    
                                $tabla.='</div>
                            </div>
                        </div>
					';
					$contador++;
				}
				$pag_final=$contador-1;
			}else{
				if($total>=1){
                    $tabla.='
                        <div class="alert alert-default text-center" role="alert" data-mdb-color="danger">
                            <p><i class="fas fa-boxes fa-fw fa-5x"></i></p>
                            <h4 class="alert-heading">Haga clic en el botón para listar nuevamente los productos que están registrados en la tienda.</h4>
                            <a href="'.$url.'" class="btn btn-primary btn-rounded btn-lg" data-mdb-ripple-color="dark">Haga clic acá para recargar el listado</a>
                        </div>
					';
				}else{
					$tabla.='
                        <div class="alert alert-default text-center" role="alert" data-mdb-color="danger">
                            <p><i class="fas fa-broadcast-tower fa-fw fa-5x"></i></p>
                            <h4 class="alert-heading">¡No hay favoritos agregados!</h4>
                            <p class="mb-0">No hemos encontrado productos agregados a favoritos .</p>
                        </div>
					';
				}
			}

            $tabla.='</div>';

			if($total>0 && $pagina<=$Npaginas){
				$tabla.='<p class="text-end">Mostrando productos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
			}

			/*--Paginacion - Pagination --*/
			if($total>=1 && $pagina<=$Npaginas){
				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7,LANG);
			}

			return $tabla;
        } /*-- Fin controlador - End controller --*/

	}