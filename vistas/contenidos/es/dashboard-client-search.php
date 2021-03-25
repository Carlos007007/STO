<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-search fa-fw"></i> &nbsp; Buscar cliente
    </h3>
</div>


<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/client-new/" ><i class="fas fa-plus fa-fw"></i> &nbsp; Nuevo cliente</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/client-list/" ><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de clientes</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="<?php echo SERVERURL.DASHBOARD; ?>/client-search/" ><i class="fas fa-search fa-fw"></i> &nbsp; Buscar cliente</a>
        </li>
    </ul>
</div>

<div class="container-fluid">
    <?php
        if(!isset($_SESSION['busqueda_cliente']) && empty($_SESSION['busqueda_cliente'])){
    ?>
    <form class="dashboard-container mb-4 FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="default" data-lang="<?php echo LANG; ?>" method="POST" autocomplete="off" style="padding-top: 40px">
        <input type="hidden" name="modulo" value="cliente">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-6">
                    <div class="form-outline mb-4">
                        <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" name="busqueda_inicial" id="busqueda_inicial" maxlength="30">
                        <label for="busqueda_inicial" class="form-label">¿Qué cliente estás buscando?</label>
                    </div>
                    <p class="text-center">
                        <button class="btn btn-primary"><i class="fas fa-search"></i> &nbsp; Buscar</button>
                    </p>
                </div>
            </div>
        </div>
    </form>
    <?php }else{ ?>
    <div class="dashboard-container mb-4">
        <form class="mb-4 FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="search" data-lang="<?php echo LANG; ?>" method="POST">
            <input type="hidden" name="modulo" value="cliente">
            <input type="hidden" name="eliminar_busqueda" value="eliminar">
            <p class="lead text-center roboto-condensed-regular">Resultados de la búsqueda <span class="font-weight-bold">“<?php echo $_SESSION['busqueda_cliente']; ?>”</span></p>
            <p class="text-center">
                <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i> &nbsp; Eliminar búsqueda</button>
            </p>
        </form>

        <?php
            require_once "./controladores/clienteControlador.php";
            $ins_cliente = new clienteControlador();

            echo $ins_cliente->paginador_cliente_controlador($pagina[2],15,$pagina[1],$_SESSION['busqueda_cliente']);
        ?>
    </div>
    <?php } ?>
</div>