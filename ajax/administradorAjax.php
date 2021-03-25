<?php
	$peticion_ajax=true;
	require_once "../config/APP.php";
	include "../vistas/inc/session_start.php";

	if(isset($_POST['modulo_administrador'])){

		/*--------- Instancia al controlador - Instance to controller ---------*/
		require_once "../controladores/administradorControlador.php";
        $ins_administrador = new administradorControlador();
        

        /*--------- Registrar administrador - Register administrator ---------*/
        if($_POST['modulo_administrador']=="registro"){
            echo $ins_administrador->registrar_administrador_controlador();
		}
		
		/*--------- Eliminar administrador - Delete administrator ---------*/
        if($_POST['modulo_administrador']=="eliminar"){
            echo $ins_administrador->eliminar_administrador_controlador();
		}
		
		/*--------- Actualizar administrador - Update administrator ---------*/
        if($_POST['modulo_administrador']=="actualizar"){
            echo $ins_administrador->actualizar_administrador_controlador();
        }

	}else{
		session_destroy();
		header("Location: ".SERVERURL."index/");
	}