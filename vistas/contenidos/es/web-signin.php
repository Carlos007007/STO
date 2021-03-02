<section class="container-cart container-signin">
    <div class="login-content mb-4">
        <figure class="full-box mb-4">
            <img src="<?php echo SERVERURL; ?>vistas/assets/avatar/Avatar_default_male.png" alt="" class="img-fluid login-icon">
        </figure>
        <form action="" method="POST" autocomplete="off">
            <div class="form-outline mb-4">
                <input type="email" class="form-control" id="login_email" name="login_email" maxlength="50" required="" >
                <label for="login_email" class="form-label"><i class="fas fa-envelope-open-text"></i> &nbsp; Email</label>
            </div>
            <div class="form-outline mb-4">
                <input type="password" class="form-control" id="login_clave" name="login_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required="" >
                <label for="login_clave" class="form-label"><i class="fas fa-key"></i> &nbsp; Contraseña</label>
            </div>
            <button type="submit" class="btn btn-primary text-center mb-4 w-100">LOG IN</button>
        </form>
    </div>
    <p class="text-center poppins-regular">¿No tienes cuenta? <a href="<?php echo SERVERURL; ?>registration/" class="font-weight-bold">Regístrate aquí</a></p>
</section>