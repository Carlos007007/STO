<?php

    if($peticion_ajax){
        require_once "../modelos/mainModel.php";
    }else{
        require_once "./modelos/mainModel.php";
    }

	class clienteControlador extends mainModel{

        /*--------- Controlador registrar cliente - Controller register client ---------*/
        public function registrar_cliente_controlador(){

        } /*-- Fin controlador - End controller --*/
    }