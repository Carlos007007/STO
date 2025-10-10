<?php

    require_once __DIR__."/../modelos/mainModel.php";

    class buscadorControlador extends mainModel{

        /*----------  Controlador modulos de busquedas  ----------*/
        public static function modulos_busqueda_controlador($modulo){

            $listaModulos=['product','admin-search','category-search','client-search','product-search'];

            if(in_array($modulo, $listaModulos)){
                return false;
            }else{
                return true;
            }
        }


        /*----------  Controlador iniciar busqueda  ----------*/
        public static function iniciar_buscador_controlador(){

            $url=mainModel::limpiar_cadena($_POST['modulo_url']);
            $texto=mainModel::limpiar_cadena($_POST['txt_buscador']);

            if(buscadorControlador::modulos_busqueda_controlador($url)){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos procesar la petición en este momento",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
                echo json_encode($alerta);
                exit();
            }

            if($texto==""){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"Por favor introduce un término de búsqueda para comenzar",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}",$texto)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El termino de busqueda no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            $_SESSION[$url]=$texto;

            if($url!="product"){
                $alerta=[
                    "Alerta"=>"redireccionar",
                    "URL"=>SERVERURL.DASHBOARD."/".$url."/"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"redireccionar",
                    "URL"=>SERVERURL.$url."/all/"
                ];
            }

            echo json_encode($alerta);
        }


        /*----------  Controlador eliminar busqueda  ----------*/
        public static function eliminar_buscador_controlador(){

            $url=mainModel::limpiar_cadena($_POST['modulo_url']);

            if(buscadorControlador::modulos_busqueda_controlador($url)){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos procesar la petición en este momento",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
                echo json_encode($alerta);
                exit();
            }

            unset($_SESSION[$url]);

            if($url!="product"){
                $alerta=[
                    "Alerta"=>"redireccionar",
                    "URL"=>SERVERURL.DASHBOARD."/".$url."/"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"redireccionar",
                    "URL"=>SERVERURL.$url."/all/"
                ];
            }

            echo json_encode($alerta);
        }

    }