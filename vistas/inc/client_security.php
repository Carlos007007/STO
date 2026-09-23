<?php 
    if(!isset($_SESSION['cliente_id_sto']) || $_SESSION['tipo_sto']!="Cliente"){
        $ins_login->cierre_sesion_controlador();
        exit();
    }