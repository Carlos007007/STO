<div class="login-container">
    <div class="login-content">
        <figure class="full-box mb-4">
            <img src="<?php echo SERVERURL; ?>vistas/assets/avatar/Avatar_default_male.png" alt="" class="img-fluid login-icon">
        </figure>
        <form action="" method="POST" autocomplete="off">
            <div class="form-outline mb-4">
                <input type="text" class="form-control" id="login_usuario" name="dashboard_usuario" pattern="[a-zA-Z0-9]{4,30}" maxlength="30" required="" >
                <label for="login_usuario" class="form-label"><i class="fas fa-user-secret"></i> &nbsp; Usuario</label>
            </div>
            <div class="form-outline mb-4">
                <input type="password" class="form-control" id="login_clave" name="dashboard_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required="" >
                <label for="login_clave" class="form-label"><i class="fas fa-key"></i> &nbsp; Contraseña</label>
            </div>
            <button type="submit" class="btn btn-primary text-center mb-4 w-100">LOG IN</button>
        </form>
    </div>
    <a href="<?php echo SERVERURL;?>" class="login-icon-home" data-toggle="tooltip" data-placement="top" title="Inicio" ><i class="fas fa-home"></i></a>
</div>
<?php
    if(isset($_POST['dashboard_usuario']) && isset($_POST['dashboard_clave'])){
		require_once "./controladores/loginControlador.php";

		$ins_login= new loginControlador();
		$ins_login->iniciar_sesion_administrador_controlador();
	}
?>