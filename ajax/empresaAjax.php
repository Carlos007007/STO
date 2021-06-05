<?php
	$peticion_ajax=true;
	require_once "../config/APP.php";
	include "../vistas/inc/session_start.php";

	if(isset($_POST['modulo_empresa'])){

		/*--------- Instancia al controlador - Instance to controller ---------*/
		require_once "../controladores/empresaControlador.php";
        $ins_empresa = new empresaControlador();
        

        /*--------- Registrar empresa - Register company ---------*/
        if($_POST['modulo_empresa']=="registro"){
            echo $ins_empresa->registrar_empresa_controlador();
		}

		/*--------- Actualizar empresa - Update company ---------*/
        if($_POST['modulo_empresa']=="actualizar"){
            echo $ins_empresa->actualizar_empresa_controlador();
        }
		
	}else{
		session_destroy();
		header("Location: ".SERVERURL."index/");
	}