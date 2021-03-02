<nav class="full-box navbar-info">
    <a href="javascript:void(0);" class="float-start" onclick="show_nav_lateral()">
        <i class="fas fa-exchange-alt"></i>
    </a>
    <a href="<?php echo SERVERURL;?>" title="Web" >
        <i class="fas fa-home"></i>
    </a>
    <a href="<?php echo SERVERURL.DASHBOARD."/admin-update/".$ins_login->encryption($_SESSION['id_sto']); ?>/" title="Cuenta" >
        <i class="fas fa-user-cog"></i>
    </a>
    <a href="javascript:void(0);" onclick="cerrar_sesion_administrador()" title="Cerrar sesión" >
        <i class="fas fa-sign-out-alt"></i>
    </a>
</nav>