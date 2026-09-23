<?php
    include "./vistas/inc/client_security.php";
?>
<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-user-circle fa-fw"></i> &nbsp; Mi cuenta
    </h3>
</div>

<div class="container-fluid pb-5">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL; ?>home/" ><i class="fab fa-dashcube fa-fw"></i> &nbsp; Dashboard</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL; ?>orders/" ><i class="fas fa-shopping-basket fa-fw"></i> &nbsp; Pedidos</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL; ?>wish-list/" ><i class="fas fa-heart fa-fw"></i> &nbsp; Favoritos</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="<?php echo SERVERURL; ?>account/" ><i class="fas fa-user-circle fa-fw"></i> &nbsp; Mi cuenta</a>
        </li>
    </ul>
</div>

<!-- Content -->
<div class="container">
    <?php     
        $cuenta=$ins_login->datos_tabla("Unico","cliente","cliente_id",$ins_login->encryption($_SESSION['cliente_id_sto']));
        if($cuenta->rowCount()==1){
            $campos=$cuenta->fetch();
    ?>
    <div class="row">
	    <div class="col-12">
	        <form class="div-bordered bg-white FormularioAjax" method="POST" data-form="update" data-lang="<?php echo LANG; ?>" autocomplete="off" action="<?php echo SERVERURL;?>ajax/clienteAjax.php"  style="padding: 15px;">

	            <input type="hidden" name="modulo_cliente" value="actualizar">
	            <input type="hidden" name="cliente_id_up" value="<?php echo $ins_login->encryption($_SESSION['cliente_id_sto']); ?>">

	            <fieldset class="mb-4">
			        <legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
	                <div class="container-fluid">
	                    <div class="row">
	                        <div class="col-12 col-md-4">
	                            <div class="form-outline mb-4">
	                                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="cliente_nombre_up" id="cliente_nombre" maxlength="35" value="<?php echo $campos['cliente_nombre']; ?>" >
	                                <label for="cliente_nombre" class="form-label">Nombres <?php echo FIELD_OBLIGATORY; ?></label>
	                            </div>
	                        </div>

	                        <div class="col-12 col-md-4">
	                            <div class="form-outline mb-4">
	                                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="cliente_apellido_up" id="cliente_apellido" maxlength="35" value="<?php echo $campos['cliente_apellido']; ?>" >
	                                <label for="cliente_apellido" class="form-label">Apellidos <?php echo FIELD_OBLIGATORY; ?></label>
	                            </div>
	                        </div>

	                        <div class="col-12 col-md-4">
	                            <div class="form-outline mb-4">
	                                <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="cliente_telefono_up" id="cliente_telefono" maxlength="20" value="<?php echo $campos['cliente_telefono']; ?>" >
	                                <label for="cliente_telefono" class="form-label">Teléfono <?php echo FIELD_OBLIGATORY; ?></label>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </fieldset>

	            <fieldset class="mb-4">
	                <div class="container-fluid">
	                    <div class="row">
	                        <div class="col-12 col-md-6">
	                            <legend><i class="fas fa-female"></i> <i class="fas fa-male"></i> &nbsp; Genero</legend>
	                            <div class="mb-4">
	                                <div class="form-check mb-2">
	                                    <input class="form-check-input" type="radio" name="cliente_genero_up" value="Masculino" id="cliente_genero_male" <?php if($campos['cliente_genero']=="Masculino"){ echo "checked"; } ?> />
	                                    <label class="form-check-label" for="cliente_genero_male">Masculino</label>
	                                </div>

	                                <div class="form-check">
	                                    <input class="form-check-input" type="radio" name="cliente_genero_up" value="Femenino" id="cliente_genero_female" <?php if($campos['cliente_genero']=="Femenino"){ echo "checked"; } ?> />
	                                    <label class="form-check-label" for="cliente_genero_female">Femenino</label>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </fieldset>

	            <fieldset class="mb-4">
	                <legend><i class="fas fa-map-marked-alt"></i> &nbsp; Información de envió</legend>
	                <div class="container-fluid">
	                    <div class="row">
	                        <div class="col-12 col-md-4">
	                            <div class="form-outline mb-4">
	                                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,29}" class="form-control" name="cliente_provincia_up" id="cliente_provincia" maxlength="29" value="<?php echo $campos['cliente_provincia']; ?>" >
	                                <label for="cliente_provincia" class="form-label">Estado, provincia o departamento <?php echo FIELD_OBLIGATORY; ?></label>
	                            </div>
	                        </div>
	                        <div class="col-12 col-md-4">
	                            <div class="form-outline mb-4">
	                                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,29}" class="form-control" name="cliente_ciudad_up" id="cliente_ciudad" maxlength="29" value="<?php echo $campos['cliente_ciudad']; ?>" >
	                                <label for="cliente_ciudad" class="form-label">Ciudad o pueblo <?php echo FIELD_OBLIGATORY; ?></label>
	                            </div>
	                        </div>
	                        <div class="col-12 col-md-4">
	                            <div class="form-outline mb-4">
	                                <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,70}" class="form-control" name="cliente_direccion_up" id="cliente_direccion" maxlength="70" value="<?php echo $campos['cliente_direccion']; ?>" >
	                                <label for="cliente_direccion" class="form-label">Calle o dirección de casa <?php echo FIELD_OBLIGATORY; ?></label>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </fieldset>

	            <fieldset class="mb-4">
	                <legend><i class="fas fa-user-lock"></i> &nbsp; Información de inicio de sesión</legend>
	                <p class="text-center">Si desea actualizar su contraseña debe de introducir una nueva contraseña y repetirla. Si NO desea actualizar su contraseña deje en blanco los campos contraseña y repetir contraseña</p>
	                <div class="container-fluid">
	                    <div class="row">
	                        <div class="col-12 col-md-4">
	                            <div class="form-outline mb-4">
	                                <input type="email" class="form-control" name="cliente_email_up" id="cliente_email" maxlength="47" value="<?php echo $campos['cliente_email']; ?>" >
	                                <label for="cliente_email" class="form-label">Email <?php echo FIELD_OBLIGATORY; ?></label>
	                            </div>
	                        </div>
	                        <div class="col-12 col-md-4">
	                            <div class="form-outline mb-4">
	                                <input type="password" class="form-control" name="cliente_clave_1_up" id="cliente_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
	                                <label for="cliente_clave_1" class="form-label">Contraseña</label>
	                            </div>
	                        </div>
	                        <div class="col-12 col-md-4">
	                            <div class="form-outline mb-4">
	                                <input type="password" class="form-control" name="cliente_clave_2_up" id="cliente_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
	                                <label for="cliente_clave_2" class="form-label">Repetir contraseña</label>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </fieldset>

	            <fieldset class="mb-4">
	                <legend><i class="fas fa-user-circle"></i> &nbsp; Avatar</legend>
	                <div class="container-fluid">
	                    <div class="row">
	                        <?php 
	                            $directorio_avatar=opendir("./vistas/assets/avatar/");
	                            $c=1;
	                            while($avatar=readdir($directorio_avatar)){
	                                if(is_file("./vistas/assets/avatar/".$avatar)){
	                                	if($campos['cliente_foto']==$avatar){
		                                    echo '
		                                        <div class="col-6 col-md-4 col-lg-3">
		                                            <div class="form-check radio-avatar-form">
		                                                <input type="radio" class="form-check-input" name="cliente_avatar_up" id="radio_avatar_'.$c.'" value="'.$avatar.'" checked >
		                                                <label class="form-check-label" for="radio_avatar_'.$c.'" ><img src="'.SERVERURL.'vistas/assets/avatar/'.$avatar.'" alt="'.$avatar.'" class="img-fluid radio-avatar-img"></label>
		                                            </div>
		                                        </div>
		                                    ';
	                                	}else{
	                                		echo '
		                                        <div class="col-6 col-md-4 col-lg-3">
		                                            <div class="form-check radio-avatar-form">
		                                                <input type="radio" class="form-check-input" name="cliente_avatar_up" id="radio_avatar_'.$c.'" value="'.$avatar.'" >
		                                                <label class="form-check-label" for="radio_avatar_'.$c.'" ><img src="'.SERVERURL.'vistas/assets/avatar/'.$avatar.'" alt="'.$avatar.'" class="img-fluid radio-avatar-img"></label>
		                                            </div>
		                                        </div>
		                                    ';
	                                	}
	                                    $c++;
	                                }
	                            } 
	                        ?>
	                    </div>
	                </div>
	            </fieldset>

	            <fieldset class="mb-4">
	            	<p class="text-center">Para poder actualizar los datos en el sistema debe de introducir su email y su contraseña actual</p>

	            	<div class="container-fluid">
	                    <div class="row">
	                        <div class="col-12 col-md-6">
	                            <div class="form-outline mb-4">
	                                <input type="email" class="form-control" name="usuario_usuario_up" id="usuario_usuario_up" maxlength="47" >
	                                <label for="usuario_usuario_up" class="form-label">Email <?php echo FIELD_OBLIGATORY; ?></label>
	                            </div>
	                        </div>
	                        <div class="col-12 col-md-6">
	                            <div class="form-outline mb-4">
	                                <input type="password" class="form-control" name="usuario_clave_up" id="usuario_clave_up" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
	                                <label for="usuario_clave_up" class="form-label">Contraseña <?php echo FIELD_OBLIGATORY; ?></label>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </fieldset>

	            <p class="text-center" style="margin-top: 40px;">
		            <button type="submit" class="btn btn-success"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR CUENTA</button>
		        </p>
	            <p class="text-center">
	                <small>Los campos marcados con <?php echo FIELD_OBLIGATORY; ?> son obligatorios</small>
	            </p>
	        </form>
	    </div>
    </div>
    <?php
        }else{ include "./vistas/inc/".LANG."/error_alert.php";}
    ?>
</div>