<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de clientes
    </h3>
</div>


<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/client-new/" ><i class="fas fa-plus fa-fw"></i> &nbsp; Nuevo cliente</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="<?php echo SERVERURL.DASHBOARD; ?>/client-list/" ><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de clientes</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/client-search/" ><i class="fas fa-search fa-fw"></i> &nbsp; Buscar cliente</a>
        </li>
    </ul>
</div>

<div class="container-fluid">
    <div class="dashboard-container">
        <?php
            require_once "./controladores/clienteControlador.php";
            $ins_cliente = new clienteControlador();

            echo $ins_cliente->paginador_cliente_controlador($pagina[2],15,$pagina[1],"");
        ?>
    </div>
</div>