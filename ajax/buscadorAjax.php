<?php
	require_once "../config/APP.php";
	include "../vistas/inc/session_start.php";
	
	if(isset($_POST['modulo_buscador'])){

		/*--------- Instancia al controlador - Instance to controller ---------*/
		require_once "../controladores/buscadorControlador.php";
        $ins_buscador = new buscadorControlador();

		/*--------- Iniciar búsqueda - Start search ---------*/
		if($_POST['modulo_buscador']=="buscar"){
			echo $ins_buscador->iniciar_buscador_controlador();
		}


		/*--------- Eliminar búsqueda - End search ---------*/
		if($_POST['modulo_buscador']=="eliminar"){
			echo $ins_buscador->eliminar_buscador_controlador();
		}

		
	}else{
        session_destroy();
		header("Location: ".SERVERURL."index/");
	}