<?php

	$peticion_ajax=true;
	require_once "../config/APP.php";
	include "../vistas/inc/session_start.php";

	if(isset($_POST['modulo_cliente'])){

		/*--------- Instancia al controlador - Instance to controller ---------*/
		require_once "../controladores/clienteControlador.php";
        $ins_cliente = new clienteControlador();
        

        /*--------- Registrar cliente - Register client ---------*/
        if($_POST['modulo_cliente']=="registro"){
            echo $ins_cliente->registrar_cliente_controlador();
		}
		


	}else{
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."index/");
		exit();
	}