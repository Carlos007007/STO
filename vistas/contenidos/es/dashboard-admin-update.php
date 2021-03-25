<?php
    if($ins_login->encryption($_SESSION['id_sto'])!=$pagina[2]){
        include "./vistas/inc/admin_security.php"; 
    }
?>

<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-sync-alt fa-fw"></i> &nbsp; Actualizar administrador
    </h3>
</div>


<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/admin-new/" ><i class="fas fa-plus fa-fw"></i> &nbsp; Nuevo administrador</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/admin-list/" ><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de administradores</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/admin-search/" ><i class="fas fa-search fa-fw"></i> &nbsp; Buscar administrador</a>
        </li>
    </ul>
</div>


<div class="container-fluid">
    <?php
        include "./vistas/inc/".LANG."/btn_go_back.php";
        
        $datos_usuario=$ins_login->datos_tabla("Unico","usuario","usuario_id",$pagina[2]);
        if($datos_usuario->rowCount()==1){
            $campos=$datos_usuario->fetch();
    ?>
    <form class="dashboard-container FormularioAjax" method="POST" data-form="update" data-lang="<?php echo LANG; ?>" autocomplete="off" action="<?php echo SERVERURL;?>ajax/administradorAjax.php">
        <input type="hidden" name="modulo_administrador" value="actualizar">
        <input type="hidden" name="usuario_id_up" value="<?php echo $pagina[2]; ?>">
        <fieldset class="mb-4">
            <legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="usuario_nombre_up" value="<?php echo $campos['usuario_nombre']; ?>" id="usuario_nombre" maxlength="35">
                            <label for="usuario_nombre" class="form-label">Nombres <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="usuario_apellido_up" value="<?php echo $campos['usuario_apellido']; ?>" id="usuario_apellido" maxlength="35">
                            <label for="usuario_apellido" class="form-label">Apellidos <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="usuario_telefono_up" value="<?php echo $campos['usuario_telefono']; ?>" id="usuario_telefono" maxlength="20">
                            <label for="usuario_telefono" class="form-label">Teléfono</label>
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
                                <input class="form-check-input" type="radio" name="usuario_genero_up" value="Masculino" id="usuario_genero_male" <?php if($campos['usuario_genero']=="Masculino"){ echo "checked"; } ?> />
                                <label class="form-check-label" for="usuario_genero_male">Masculino</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="usuario_genero_up" value="Femenino" id="usuario_genero_female" <?php if($campos['usuario_genero']=="Femenino"){ echo "checked"; } ?> />
                                <label class="form-check-label" for="usuario_genero_female">Femenino</label>
                            </div>
                        </div>
                    </div>
                    <?php if($_SESSION['cargo_sto']=="Administrador" && $campos['usuario_id']!=1 && $ins_login->encryption($_SESSION['id_sto'])!=$pagina[2]){ ?>
                    <div class="col-12 col-md-6">
                        <legend><i class="fas fa-user-secret"></i> &nbsp; Cargo</legend>
                        <div class="mb-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="usuario_cargo_up" value="Administrador" id="usuario_cargo_admin" <?php if($campos['usuario_cargo']=="Administrador"){ echo "checked"; } ?> />
                                <label class="form-check-label" for="usuario_cargo_admin">Administrador</label>
                            </div>
        
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="usuario_cargo_up" value="Cajero" id="usuario_cargo_cajero" <?php if($campos['usuario_cargo']=="Cajero"){ echo "checked"; } ?> />
                                <label class="form-check-label" for="usuario_cargo_cajero">Cajero</label>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <legend><i class="fas fa-user-lock"></i> &nbsp; Datos de la cuenta</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-Z0-9]{4,30}" class="form-control" name="usuario_usuario_up" value="<?php echo $campos['usuario_usuario']; ?>" id="usuario_usuario" maxlength="30">
                            <label for="usuario_usuario" class="form-label">Usuario <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="email" class="form-control" name="usuario_email_up" value="<?php echo $campos['usuario_email']; ?>" id="usuario_email" maxlength="47">
                            <label for="usuario_email" class="form-label">Email <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="text-start">Si desea <strong>actualizar la contraseña</strong> de esta cuenta debe de introducir una nueva contraseña y repetirla. Por el contrario, <strong>si no desea actualizarla</strong> deje vacíos los campos.</p>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="password" class="form-control" name="usuario_nueva_clave_1_up" id="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                            <label for="usuario_clave_1" class="form-label">Nueva contraseña <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="password" class="form-control" name="usuario_nueva_clave_2_up" id="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                            <label for="usuario_clave_2" class="form-label">Repita nueva contraseña <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <?php if($_SESSION['cargo_sto']=="Administrador" && $campos['usuario_id']!=1 && $ins_login->encryption($_SESSION['id_sto'])!=$pagina[2]){ ?>
                    <div class="col-12">
                        <div class="mb-4">
                            <span><strong>Seleccione el estado de la cuenta</strong></span>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="usuario_estado_up" value="Activa" id="usuario_estado_activa" <?php if($campos['usuario_cuenta_estado']=="Activa"){ echo "checked"; } ?> />
                                <label class="form-check-label" for="usuario_estado_activa">Activa</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="usuario_estado_up" value="Deshabilitada" id="usuario_estado_deshabilitada" <?php if($campos['usuario_cuenta_estado']=="Deshabilitada"){ echo "checked"; } ?> />
                                <label class="form-check-label" for="usuario_estado_deshabilitada">Deshabilitada</label>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <legend><i class="fas fa-user-circle"></i> &nbsp; Avatar</legend>
            <div class="container-fluid">
                <div class="row">
                    <?php 
                        $directorio_avatar=opendir("./vistas/assets/avatar/");
                        $check="";
                        $c=1;
                        while($avatar=readdir($directorio_avatar)){
                            if(is_file("./vistas/assets/avatar/".$avatar)){

                                if($campos['usuario_foto']==$avatar){
                                    $check="checked";
                                }

                                echo '
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="form-check radio-avatar-form">
                                            <input type="radio" class="form-check-input" name="usuario_avatar_up" id="radio_avatar_'.$c.'" value="'.$avatar.'" '.$check.' >
                                            <label class="form-check-label" for="radio_avatar_'.$c.'" ><img src="'.SERVERURL.'vistas/assets/avatar/'.$avatar.'" alt="'.$avatar.'" class="img-fluid radio-avatar-img"></label>
                                        </div>
                                    </div>
                                ';
                                $check="";
                                $c++;
                            }
                        } 
                    ?>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <p class="text-start">Para poder actualizar los datos en el sistema debe de introducir su <strong>nombre de usuario</strong> y su <strong>contraseña</strong> actual</p>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-Z0-9]{4,30}" class="form-control" name="administrador_usuario_up" id="administrador_usuario" maxlength="30">
                            <label for="administrador_usuario" class="form-label">Usuario <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="password" class="form-control" name="administrador_clave_up" id="administrador_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                            <label for="administrador_clave" class="form-label">Contraseña <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <p class="text-center" style="margin-top: 40px;">
            <button type="submit" class="btn btn-success"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
        </p>
        <p class="text-center">
            <small>Los campos marcados con <?php echo FIELD_OBLIGATORY; ?> son obligatorios</small>
        </p>
    </form>
    <?php
        }else{ include "./vistas/inc/".LANG."/error_alert.php";}
    ?>
</div>