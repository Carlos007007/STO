<?php
    if(isset($_SESSION['id_sto']) || isset($_SESSION['cliente_id_sto'])){
        $ins_login->cierre_sesion_controlador();
        exit();
    }