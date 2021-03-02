<?php
    include "./vistas/inc/admin_security.php";
?>
<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de administradores
    </h3>
</div>


<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/admin-new/" ><i class="fas fa-plus fa-fw"></i> &nbsp; Nuevo administrador</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="<?php echo SERVERURL.DASHBOARD; ?>/admin-list/" ><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de administradores</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/admin-search/" ><i class="fas fa-search fa-fw"></i> &nbsp; Buscar administrador</a>
        </li>
    </ul>
</div>


<div class="container-fluid">
    <div class="dashboard-container">
        <?php
            require_once "./controladores/administradorControlador.php";
            $ins_administrador = new administradorControlador();

            echo $ins_administrador->paginador_administrador_controlador($pagina[2],15,$pagina[1],"");
        ?>
    </div>
</div>