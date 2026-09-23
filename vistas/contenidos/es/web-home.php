<?php
    include "./vistas/inc/client_security.php";
?>
<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fab fa-dashcube fa-fw"></i> &nbsp; DASHBOARD
    </h3>
</div>

<div class="container-fluid pb-5">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
    	<li class="nav-item" role="presentation">
            <a class="nav-link active" href="<?php echo SERVERURL; ?>home/" ><i class="fab fa-dashcube fa-fw"></i> &nbsp; Dashboard</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL; ?>orders/" ><i class="fas fa-shopping-basket fa-fw"></i> &nbsp; Pedidos</a>
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
<div class="full-box pt-2 pb-2 text-center">
	<figure class="full-box mb-4">
        <img src="<?php echo SERVERURL; ?>vistas/assets/avatar/<?php echo $_SESSION['cliente_foto_sto']; ?>" alt="" class="img-fluid login-icon">
    </figure>
	<p class="lead">
        ¡Bienvenid@ <strong><?php echo $_SESSION['cliente_nombre_sto']." ".$_SESSION['cliente_apellido_sto'];?></strong>!
    </p>
</div>
<div class="full-box tile-container pt-5 pb-5">
    <?php 
        $total_pedidos=$ins_login->datos_tabla("Normal","venta WHERE cliente_id='".$_SESSION['cliente_id_sto']."'","cliente_id",0); 
    ?>
    <a href="<?php echo SERVERURL; ?>orders/" class="tile">
        <div class="tile-tittle">Pedidos</div>
        <div class="tile-icon">
            <i class="fas fa-shopping-basket fa-fw"></i>
            <p><?php echo $total_pedidos->rowCount(); ?> Registrados</p>
        </div>
    </a>
    <?php 
        $total_pedidos->closeCursor();
        $total_pedidos=$ins_login->desconectar($total_pedidos);

        $total_favoritos=$ins_login->datos_tabla("Normal","favorito WHERE cliente_id='".$_SESSION['cliente_id_sto']."'","cliente_id",0);
    ?>
    <a href="<?php echo SERVERURL; ?>wish-list/" class="tile">
        <div class="tile-tittle">Favoritos</div>
        <div class="tile-icon">
            <i class="fas fa-heart fa-fw"></i>
            <p><?php echo $total_favoritos->rowCount(); ?> Registrados</p>
        </div>
    </a>
    <?php
        $total_favoritos->closeCursor();
        $total_favoritos=$ins_login->desconectar($total_favoritos);
    ?>
    <a href="<?php echo SERVERURL; ?>account/" class="tile">
        <div class="tile-tittle">Cuenta</div>
        <div class="tile-icon">
            <i class="fas fa-user-circle fa-fw"></i>
            <p>&nbsp;</p>
        </div>
    </a>
</div>