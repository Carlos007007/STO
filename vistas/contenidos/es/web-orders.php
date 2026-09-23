<?php
    include "./vistas/inc/client_security.php";
?>
<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-shopping-basket fa-fw"></i> &nbsp; PEDIDOS
    </h3>
</div>

<div class="container-fluid pb-5">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL; ?>home/" ><i class="fab fa-dashcube fa-fw"></i> &nbsp; Dashboard</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="<?php echo SERVERURL; ?>orders/" ><i class="fas fa-shopping-basket fa-fw"></i> &nbsp; Pedidos</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL; ?>wish-list/" ><i class="fas fa-heart fa-fw"></i> &nbsp; Favoritos</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL; ?>account/" ><i class="fas fa-user-circle fa-fw"></i> &nbsp; Mi cuenta</a>
        </li>
    </ul>
</div>

<!-- Content -->
<div class="container-fluid">
    <div class="dashboard-container">
        <?php
            require_once "./controladores/carritoControlador.php";
            $ins_pedido = new carritoControlador();

            echo $ins_pedido->paginador_pedido_controlador($pagina[1],20,$pagina[0],"");
        ?>
    </div>
</div>