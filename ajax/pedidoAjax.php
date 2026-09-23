<?php
	require_once "../config/APP.php";
	include "../vistas/inc/session_start.php";

	if(isset($_POST['modulo_pedido']) && $_SERVER['REQUEST_METHOD'] === 'POST'){

		/*--------- Instancia al controlador - Instance to controller ---------*/
		require_once "../controladores/pedidoControlador.php";
        $ins_pedido = new pedidoControlador();


        /*--------- Agregar producto - Add product ---------*/
        if($_POST['modulo_pedido']=="agregar_producto"){
            echo $ins_pedido->agregar_producto_pedido_controlador();
		}

		/*--------- Guardar pedido administrador - Save order admin ---------*/
        if($_POST['modulo_pedido']=="guardar_pedido_administrador"){
            echo $ins_pedido->guardar_pedido_administrador_controlador();
		}

		/*--------- Buscar producto - Search product ---------*/
        if($_POST['modulo_pedido']=="buscar_codigo"){
            echo $ins_pedido->buscar_codigo_pedido_controlador();
		}

		/*--------- Buscar cliente - Search client ---------*/
        if($_POST['modulo_pedido']=="buscar_cliente"){
            echo $ins_pedido->buscar_cliente_pedido_controlador();
		}

		/*--------- Agregar cliente - Add client ---------*/
        if($_POST['modulo_pedido']=="agregar_cliente"){
            echo $ins_pedido->agregar_cliente_pedido_controlador();
		}

		/*--------- Remover cliente - Remove client ---------*/
        if($_POST['modulo_pedido']=="remover_cliente"){
            echo $ins_pedido->remover_cliente_pedido_controlador();
		}

		/*--------- Actualizar pedido - Update order ---------*/
        if($_POST['modulo_pedido']=="actualizar_pedido"){
            echo $ins_pedido->actualizar_pedido_controlador();
		}

		/*--------- Agregar pago - Add payment ---------*/
        if($_POST['modulo_pedido']=="agregar_pago"){
            echo $ins_pedido->agregar_pago_pedido_controlador();
		}

		/*--------- Cancelar pedido - Cancel order ---------*/
        if($_POST['modulo_pedido']=="cancelar_pedido"){
            echo $ins_pedido->cancelar_pedido_controlador();
		}

	}else{
		session_destroy();
		header("Location: ".SERVERURL."index/");
		exit();
	}