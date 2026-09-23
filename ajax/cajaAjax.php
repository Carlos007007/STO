<?php
	require_once "../config/APP.php";
	include "../vistas/inc/session_start.php";

	if(isset($_POST['modulo_caja']) && $_SERVER['REQUEST_METHOD'] === 'POST'){

		/*--------- Instancia al controlador - Instance to controller ---------*/
		require_once "../controladores/cajaControlador.php";
        $ins_caja = new cajaControlador();
        

        /*--------- Registrar caja - Register client ---------*/
        if($_POST['modulo_caja']=="registro"){
            echo $ins_caja->registrar_caja_controlador();
		}

		/*--------- Eliminar caja - Delete client ---------*/
        if($_POST['modulo_caja']=="eliminar"){
            echo $ins_caja->eliminar_caja_controlador();
		}

		/*--------- Actualizar caja - Update client ---------*/
        if($_POST['modulo_caja']=="actualizar"){
            echo $ins_caja->actualizar_caja_controlador();
        }

	}else{
		session_destroy();
		header("Location: ".SERVERURL."index/");
		exit();
	}