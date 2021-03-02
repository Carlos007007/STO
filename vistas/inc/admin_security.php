<?php 
    if($_SESSION['cargo_sto']!="Administrador"){
        $ins_login->forzar_cierre_sesion_controlador();
        exit();
    }
