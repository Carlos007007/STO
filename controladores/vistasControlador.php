<?php

	require_once "./modelos/vistasModelo.php";

	class vistasControlador extends vistasModelo{

		/*---------- Controlador obtener plantilla ----------*/
		public function obtener_plantilla_controlador(){
			return require_once "./vistas/plantilla.php";
		}

		/*---------- Controlador obtener vistas ----------*/
		public function obtener_vistas_controlador($modulo,$idioma){
			if(isset($_GET['views'])){
				$ruta=explode("/", $_GET['views']);

				if($modulo=="dashboard"){
					if(isset($ruta[1]) && $ruta[1]!=""){
						$vista=$ruta[1];
					}else{
						$vista="";
					}
				}else{
					$vista=$ruta[0];
				}

				if($vista!=""){
					$respuesta=vistasModelo::obtener_vistas_modelo($vista,$modulo,$idioma);
				}else{
					if($modulo=="dashboard"){
						$respuesta="login";
					}else{
						$respuesta="./vistas/contenidos/".$idioma."/web-index.php";
					}
				}
			}else{
				if($modulo=="dashboard"){
					$respuesta="login";
				}else{
					$respuesta="./vistas/contenidos/".$idioma."/web-index.php";
				}
			}
			return $respuesta;
		}
	}