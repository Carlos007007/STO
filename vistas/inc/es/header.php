<header class="header full-box bg-white">
    <div class="header-brand full-box">
        <a href="<?php echo SERVERURL; ?>index/">
            <img src="<?php echo SERVERURL; ?>vistas/assets/img/logo.png" alt="<?php echo COMPANY; ?>" class="img-fluid">
        </a>
    </div>

    <div class="header-options full-box">
        <nav class="header-navbar full-box poppins-regular font-weight-bold scroll" onclick="show_menu_mobile()" >
            <ul class="list-unstyled full-box" >
                <li>
                    <a href="<?php echo SERVERURL; ?>index/" >Inicio</a>
                </li>
                <li>
                    <a href="<?php echo SERVERURL; ?>product/all/" >Productos</a>
                </li>

                <?php if(!isset($_SESSION['cargo_sto'])){ ?>
                <li>
                    <a href="<?php echo SERVERURL; ?>registration/" >Regístrate</a>
                </li>
                <li>
                    <a href="<?php echo SERVERURL; ?>signin/" >Login</a>
                </li>
                <?php } ?>
            </ul>
        </nav>
        <a href="<?php echo SERVERURL; ?>bag/" class="header-button full-box text-center" title="Carrito" >
            <i class="fas fa-shopping-bag"></i>
            <span class="badge bg-primary rounded-pill bag-count" >2</span>
        </a>

        <?php if(isset($_SESSION['cargo_sto']) && ($_SESSION['cargo_sto']=="Administrador" || $_SESSION['cargo_sto']=="Cajero")){ ?>
            <div class="header-button full-box text-center" id="userMenu" data-mdb-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo $_SESSION['usuario_sto']; ?>" >
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="dropdown-menu div-bordered popup-login" aria-labelledby="userMenu">
                <p class="text-center" style="padding-top: 10px;">
                    <i class="fas fa-user-circle fa-3x"></i><br>
                    <small><?php echo $_SESSION['usuario_sto']; ?></small>
                </p>
                <a class="dropdown-item" href="<?php echo SERVERURL.DASHBOARD; ?>/home/">
                    <i class="fab fa-dashcube fa-fw"></i> &nbsp; Dashboard
                </a>
                <a class="dropdown-item" href="javascript:void(0);" onclick="cerrar_sesion_administrador()">
                    <i class="fas fa-sign-out-alt"></i> &nbsp; Cerrar sesión
                </a>
            </div>
        <?php } ?>

        <a href="javascript:void(0);" class="header-button full-box text-center d-lg-none" title="Menú" onclick="show_menu_mobile()" >
            <i class="fas fa-bars"></i>
        </a>
    </div>
</header>