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

            /*-- Verificando producto en el carrito - Checking product in cart --*/
            if(empty($_SESSION['carrito_sto'][$id])){
            	
            	$detalle_precio_final=$campos['producto_precio_venta']-($campos['producto_precio_venta']*($campos['producto_descuento']/100));
            	$detalle_precio_final=number_format($detalle_precio_final,COIN_DECIMALS,'.','');

            	$detalle_total=$cantidad*$detalle_precio_final;
                $detalle_total=number_format($detalle_total,COIN_DECIMALS,'.','');

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
                    "venta_detalle_costo"=>$detalle_costos,
                    "venta_detalle_utilidad"=>$detalle_utilidad,
                    "venta_detalle_descripcion"=>$campos['producto_nombre'],
                    "producto_stock_total"=>$campos['producto_stock'],
					"producto_stock_total_old"=>$campos['producto_stock'],
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
					"Texto"=>"No $codigohemos encontrado el producto en el sistema",
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
                    $diferencia_productos="agrego +".($cantidad-$_SESSION['carrito_sto'][$id]["venta_detalle_cantidad"]);
                }else{
                    $diferencia_productos="quito -".($_SESSION['carrito_sto'][$id]["venta_detalle_cantidad"]-$cantidad);
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
                    "venta_detalle_costo"=>$detalle_costos,
                    "venta_detalle_utilidad"=>$detalle_utilidad,
                    "venta_detalle_descripcion"=>$campos['producto_nombre'],
                    "producto_stock_total"=>$campos['producto_stock'],
					"producto_stock_total_old"=>$campos['producto_stock'],
					"producto_descuento"=>$campos['producto_descuento'],
					"producto_portada"=>$campos['producto_portada']
                ];

                $_SESSION['alerta_producto_agregado_carrito']="Se $diferencia_productos <strong>".$campos['producto_nombre']."</strong> al carrito. Total en carrito <strong>$detalle_cantidad</strong>";

                $alerta=[
					"Alerta"=>"redireccionar",
					"URL"=>SERVERURL."bag/"
				];

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
	}