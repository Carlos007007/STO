<?php

	require_once __DIR__."/../modelos/vistasModelo.php";

	class vistasControlador extends vistasModelo{

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