<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="far fa-calendar-times fa-fw"></i> &nbsp; Pedidos cancelados
    </h3>
</div>

<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/order-new/" ><i class="fas fa-shopping-basket fa-fw"></i> &nbsp; Nuevo pedido</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/order-list/" ><i class="fas fa-file-invoice-dollar fa-fw"></i> &nbsp; Pedidos realizados</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/order-pending/" ><i class="fas fa-truck-loading fa-fw"></i> &nbsp; Pedidos pendientes</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="<?php echo SERVERURL.DASHBOARD; ?>/order-canceled/" ><i class="far fa-calendar-times fa-fw"></i> &nbsp; Pedidos cancelados</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/order-search/" ><i class="fas fa-search-dollar fa-fw"></i> &nbsp; Buscar pedido</a>
        </li>
    </ul>
</div>

<div class="container-fluid">
    <div class="dashboard-container">
        <?php
            require_once "./controladores/pedidoControlador.php";
            $ins_pedido = new pedidoControlador();

            echo $ins_pedido->paginador_pedido_controlador($pagina[2],15,$pagina[1],"");

            include "./vistas/inc/".LANG."/print_invoice_script.php";
        ?>
    </div>
</div>