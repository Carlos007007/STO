<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-sync-alt fa-fw"></i> &nbsp; Actualizar cliente
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
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/client-search/" ><i class="fas fa-search fa-fw"></i> &nbsp; Buscar cliente</a>
        </li>
    </ul>
</div>

<div class="container-fluid">
    <?php
        include "./vistas/inc/".LANG."/btn_go_back.php";
        
        $datos_cliente=$ins_login->datos_tabla("Unico","cliente","cliente_id",$pagina[2]);
        if($datos_cliente->rowCount()==1){
            $campos=$datos_cliente->fetch();
    ?>
    <form class="dashboard-container FormularioAjax" method="POST" data-form="update" data-lang="<?php echo LANG; ?>" autocomplete="off" action="<?php echo SERVERURL;?>ajax/clienteAjax.php" >
        <input type="hidden" name="modulo_cliente" value="actualizar">
        <input type="hidden" name="cliente_id_up" value="<?php echo $pagina[2]; ?>">
        <fieldset class="mb-4">
            <legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="cliente_nombre_up" value="<?php echo $campos['cliente_nombre']; ?>" id="cliente_nombre" maxlength="35">
                            <label for="cliente_nombre" class="form-label">Nombres <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="cliente_apellido_up" value="<?php echo $campos['cliente_apellido']; ?>" id="cliente_apellido" maxlength="35">
                            <label for="cliente_apellido" class="form-label">Apellidos <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="cliente_telefono_up" value="<?php echo $campos['cliente_telefono']; ?>" id="cliente_telefono" maxlength="20">
                            <label for="cliente_telefono" class="form-label">Teléfono</label>
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
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,29}" class="form-control" name="cliente_provincia_up" value="<?php echo $campos['cliente_provincia']; ?>" id="cliente_provincia" maxlength="29">
                            <label for="cliente_provincia" class="form-label">Estado, provincia o departamento <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,29}" class="form-control" name="cliente_ciudad_up" value="<?php echo $campos['cliente_ciudad']; ?>" id="cliente_ciudad" maxlength="29">
                            <label for="cliente_ciudad" class="form-label">Ciudad o pueblo <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,70}" class="form-control" name="cliente_direccion_up" value="<?php echo $campos['cliente_direccion']; ?>" id="cliente_direccion" maxlength="70">
                            <label for="cliente_direccion" class="form-label">Calle o dirección de casa <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <legend><i class="fas fa-user-lock"></i> &nbsp; Datos de la cuenta</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="form-outline mb-4">
                            <input type="email" class="form-control" name="cliente_email_up" value="<?php echo $campos['cliente_email']; ?>" id="cliente_email" maxlength="47">
                            <label for="cliente_email" class="form-label">Email <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="text-start">Si desea <strong>actualizar la contraseña</strong> de este cliente debe de introducir una nueva contraseña y repetirla. Por el contrario, <strong>si no desea actualizarla</strong> deje vacíos los campos.</p>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="password" class="form-control" name="cliente_clave_1_up" id="cliente_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                            <label for="cliente_clave_1" class="form-label">Contraseña <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="password" class="form-control" name="cliente_clave_2_up" id="cliente_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                            <label for="cliente_clave_2" class="form-label">Repita contraseña <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-4">
                            <span><strong>Seleccione el estado de la cuenta</strong></span>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="cliente_estado_up" value="Activa" id="cliente_estado_activa" <?php if($campos['cliente_cuenta_estado']=="Activa"){ echo "checked"; } ?> />
                                <label class="form-check-label" for="cliente_estado_activa">Activa</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="cliente_estado_up" value="Deshabilitada" id="cliente_estado_deshabilitada" <?php if($campos['cliente_cuenta_estado']=="Deshabilitada"){ echo "checked"; } ?> />
                                <label class="form-check-label" for="cliente_estado_deshabilitada">Deshabilitada</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-4">
                            <span><strong>Seleccione la verificación de la cuenta</strong></span>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="cliente_verificacion_up" value="Verificada" id="cliente_verificacion_verificada" <?php if($campos['cliente_cuenta_verificada']=="Verificada"){ echo "checked"; } ?> />
                                <label class="form-check-label" for="cliente_verificacion_verificada">Verificada</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="cliente_verificacion_up" value="No verificada" id="cliente_verificacion_no_verificada" <?php if($campos['cliente_cuenta_verificada']=="No verificada"){ echo "checked"; } ?> />
                                <label class="form-check-label" for="cliente_verificacion_no_verificada">No verificada</label>
                            </div>
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
                        $check="";
                        $c=1;
                        while($avatar=readdir($directorio_avatar)){
                            if(is_file("./vistas/assets/avatar/".$avatar)){

                                if($campos['cliente_foto']==$avatar){
                                    $check="checked";
                                }

                                echo '
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="form-check radio-avatar-form">
                                            <input type="radio" class="form-check-input" name="cliente_avatar_up" id="radio_avatar_'.$c.'" value="'.$avatar.'" '.$check.' >
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
                            <input type="text" pattern="[a-zA-Z0-9]{4,30}" class="form-control" name="usuario_usuario_up" id="usuario_usuario" maxlength="30">
                            <label for="usuario_usuario" class="form-label">Usuario <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="password" class="form-control" name="usuario_clave_up" id="usuario_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                            <label for="usuario_clave" class="form-label">Contraseña <?php echo FIELD_OBLIGATORY; ?></label>
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