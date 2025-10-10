<?php
	require_once "../config/APP.php";
	include "../vistas/inc/session_start.php";

	if(isset($_POST['modulo_carrito'])){

		/*--------- Instancia al controlador - Instance to controller ---------*/
		require_once "../controladores/carritoControlador.php";
        $ins_carrito = new carritoControlador();
        

        /*--------- Agregar producto - Add product ---------*/
        if($_POST['modulo_carrito']=="agregar"){
            echo $ins_carrito->agregar_producto_carrito_controlador();
		}

		/*--------- Remover producto - Remove product ---------*/
        if($_POST['modulo_carrito']=="remover"){
            echo $ins_carrito->remover_producto_carrito_controlador();
		}

		/*--------- Actualizar producto - Update product ---------*/
        if($_POST['modulo_carrito']=="actualizar"){
            echo $ins_carrito->actualizar_producto_carrito_controlador();
		}

	}else{
		session_destroy();
		header("Location: ".SERVERURL."index/");
	}