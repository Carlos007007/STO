<?php
    include "./vistas/inc/admin_security.php";
?>

<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de cajas
    </h3>
</div>

<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/cashRegister-new/" ><i class="fas fa-plus fa-fw"></i> &nbsp; Nueva caja</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="<?php echo SERVERURL.DASHBOARD; ?>/cashRegister-list/" ><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de cajas</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/cashRegister-search/" ><i class="fas fa-search fa-fw"></i> &nbsp; Buscar caja</a>
        </li>
    </ul>
</div>

<div class="container-fluid">
    <div class="dashboard-container">
        <?php
            require_once "./controladores/cajaControlador.php";
            $ins_caja = new cajaControlador();

            echo $ins_caja->paginador_caja_controlador($pagina[2],15,$pagina[1],"");
        ?>
    </div>
</div>