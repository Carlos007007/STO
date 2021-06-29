<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-boxes fa-fw"></i> &nbsp; Inventario de productos
    </h3>
</div>

<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <?php if($_SESSION['cargo_sto']=="Administrador"){ ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/product-new/" ><i class="fas fa-plus fa-fw"></i> &nbsp; Agregar producto</a>
            </li>
        <?php } ?>
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="<?php echo SERVERURL.DASHBOARD; ?>/product-list/" ><i class="fas fa-boxes fa-fw"></i> &nbsp; Inventario de productos</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/product-minimum/" ><i class="fas fa-stopwatch-20 fa-fw"></i> &nbsp; Productos en stock mínimo</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/product-search/" ><i class="fas fa-search fa-fw"></i> &nbsp; Buscar producto</a>
        </li>
    </ul>
</div>

<div class="container-fluid">
    <div class="full-box dashboard-container">
        <?php
            require_once "./controladores/productoControlador.php";
            $ins_producto = new productoControlador();

            echo $ins_producto->administrador_paginador_producto_controlador($pagina[2],15,$pagina[1],"");
        ?>
    </div>
</div>