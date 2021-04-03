<?php
    include "./vistas/inc/admin_security.php";
?>
<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de categorías
    </h3>
</div>


<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/category-new/" ><i class="fas fa-plus fa-fw"></i> &nbsp; Nueva categoría</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="<?php echo SERVERURL.DASHBOARD; ?>/category-list/" ><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de categorías</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/category-search/" ><i class="fas fa-search fa-fw"></i> &nbsp; Buscar categoría</a>
        </li>
    </ul>
</div>


<div class="container-fluid">
    <div class="dashboard-container">
        <?php
            require_once "./controladores/categoriaControlador.php";
            $ins_categoria = new categoriaControlador();

            echo $ins_categoria->paginador_categoria_controlador($pagina[2],15,$pagina[1],"");
        ?>
    </div>
</div>