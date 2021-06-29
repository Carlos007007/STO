<section class="full-box nav-lateral">
    <div class="full-box nav-lateral-bg" onclick="show_nav_lateral()" ></div>
    <div class="full-box nav-lateral-content scroll">
        <figure class="full-box nav-lateral-avatar">
            <i class="far fa-times-circle" onclick="show_nav_lateral()" ></i>
            <img src="<?php echo SERVERURL; ?>vistas/assets/avatar/<?php echo $_SESSION['foto_sto']; ?>" class="img-fluid" alt="Avatar">
            <figcaption class="roboto-medium text-center">
                <?php echo $_SESSION['nombre_sto']; ?> <br><small class="roboto-condensed-light"><?php echo $_SESSION['cargo_sto']; ?></small>
            </figcaption>
        </figure>
        <div class="full-box nav-lateral-bar"></div>
        <nav class="full-box nav-lateral-menu">
            <ul>
                <li>
                    <a href="<?php echo SERVERURL.DASHBOARD; ?>/home/"><i class="fab fa-dashcube fa-fw"></i> &nbsp; Dashboard</a>
                </li>

                <?php if($_SESSION['cargo_sto']=="Administrador"){ ?>
                <li>
                    <a href="javascript:void(0);" class="nav-btn-submenu"><i class="fas fa-tag fa-fw"></i> &nbsp; Categorías <i class="fas fa-chevron-down"></i></a>
                    <ul>
                        <li>
                            <a href="<?php echo SERVERURL.DASHBOARD; ?>/category-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; Nueva categoría</a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL.DASHBOARD; ?>/category-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de categorías</a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL.DASHBOARD; ?>/category-search/"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar categoría</a>
                        </li>
                    </ul>
                </li>
                <?php } ?>

                <li>
                    <a href="javascript:void(0);" class="nav-btn-submenu"><i class="fas fa-users fa-fw"></i> &nbsp; Clientes <i class="fas fa-chevron-down"></i></a>
                    <ul>
                        <li>
                            <a href="<?php echo SERVERURL.DASHBOARD; ?>/client-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; Nuevo cliente</a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL.DASHBOARD; ?>/client-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de clientes</a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL.DASHBOARD; ?>/client-search/"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar cliente</a>
                        </li>
                    </ul>
                </li>
                
                <li>
                    <a href="javascript:void(0);" class="nav-btn-submenu"><i class="fas fa-box-open fa-fw"></i> &nbsp; Productos <i class="fas fa-chevron-down"></i></a>
                    <ul>
                        <?php if($_SESSION['cargo_sto']=="Administrador"){ ?>
                        <li>
                            <a href="<?php echo SERVERURL.DASHBOARD; ?>/product-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; Agregar producto</a>
                        </li>
                        <?php } ?>
                        <li>
                            <a href="<?php echo SERVERURL.DASHBOARD; ?>/product-list/"><i class="fas fa-boxes fa-fw"></i> &nbsp; Inventario de productos</a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL.DASHBOARD; ?>/product-minimum/"><i class="fas fa-stopwatch-20 fa-fw"></i> &nbsp; Productos en stock mínimo</a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL.DASHBOARD; ?>/product-search/"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar producto</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="nav-btn-submenu"><i class="fas fa-file-invoice-dollar fa-fw"></i> &nbsp; Pedidos & Ventas <i class="fas fa-chevron-down"></i></a>
                    <ul>
                        <li>
                            <a href="#"><i class="fas fa-file-invoice-dollar fa-fw"></i> &nbsp; Ventas realizadas</a>
                        </li>
                        <li>
                            <a href="#"><i class="fas fa-truck-loading fa-fw"></i> &nbsp; Pedidos pendientes</a>
                        </li>
                        <li>
                            <a href="#"><i class="fas fa-search-dollar fa-fw"></i> &nbsp; Buscar pedido o venta</a>
                        </li>
                    </ul>
                </li>

                <?php if($_SESSION['cargo_sto']=="Administrador"){ ?>
                <li>
                    <a href="javascript:void(0);" class="nav-btn-submenu"><i class="fas  fa-user-secret fa-fw"></i> &nbsp; Administradores <i class="fas fa-chevron-down"></i></a>
                    <ul>
                        <li>
                            <a href="<?php echo SERVERURL.DASHBOARD; ?>/admin-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; Nuevo administrador</a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL.DASHBOARD; ?>/admin-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de administradores</a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL.DASHBOARD; ?>/admin-search/"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar administrador</a>
                        </li>
                    </ul>
                </li>
                <?php } ?>

                <li>
                    <a href="javascript:void(0);" class="nav-btn-submenu"><i class="fas fa-cogs fa-fw"></i> &nbsp; Configuraciones <i class="fas fa-chevron-down"></i></a>
                    <ul>
                        <?php if($_SESSION['cargo_sto']=="Administrador"){ ?>
                            <li>
                                <a href="<?php echo SERVERURL.DASHBOARD; ?>/company/"><i class="fas fa-store-alt fa-fw"></i> &nbsp; Empresa</a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="<?php echo SERVERURL.DASHBOARD."/admin-update/".$ins_login->encryption($_SESSION['id_sto']); ?>/"><i class="fas fa-user-cog fa-fw"></i> &nbsp; Cuenta</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="<?php echo SERVERURL;?>" ><i class="fas fa-home fa-fw"></i> &nbsp; Sitio web</a>
                </li>

                <li>
                    <a href="javascript:void(0);" onclick="cerrar_sesion_administrador()" ><i class="fas fa-sign-out-alt fa-fw"></i> &nbsp; Cerrar sesión</a>
                </li>
            </ul>
        </nav>
    </div>
</section>