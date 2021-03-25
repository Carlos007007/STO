<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-plus fa-fw"></i> &nbsp; Nuevo cliente
    </h3>
</div>


<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="<?php echo SERVERURL.DASHBOARD; ?>/client-new/" ><i class="fas fa-plus fa-fw"></i> &nbsp; Nuevo cliente</a>
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
    <form class="dashboard-container FormularioAjax" method="POST" data-form="save" data-lang="<?php echo LANG; ?>" autocomplete="off" action="<?php echo SERVERURL;?>ajax/clienteAjax.php" >
        <input type="hidden" name="modulo_cliente" value="registro">
        <fieldset class="mb-4">
            <legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="cliente_nombre_reg" id="cliente_nombre" maxlength="35">
                            <label for="cliente_nombre" class="form-label">Nombres <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="cliente_apellido_reg" id="cliente_apellido" maxlength="35">
                            <label for="cliente_apellido" class="form-label">Apellidos <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="cliente_telefono_reg" id="cliente_telefono" maxlength="20">
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
                                <input class="form-check-input" type="radio" name="cliente_genero_reg" value="Masculino" id="cliente_genero_male" checked />
                                <label class="form-check-label" for="cliente_genero_male">Masculino</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="cliente_genero_reg" value="Femenino" id="cliente_genero_female" />
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
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,29}" class="form-control" name="cliente_provincia_reg" id="cliente_provincia" maxlength="29">
                            <label for="cliente_provincia" class="form-label">Estado, provincia o departamento <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,29}" class="form-control" name="cliente_ciudad_reg" id="cliente_ciudad" maxlength="29">
                            <label for="cliente_ciudad" class="form-label">Ciudad o pueblo <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,70}" class="form-control" name="cliente_direccion_reg" id="cliente_direccion" maxlength="70">
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
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="email" class="form-control" name="cliente_email_reg" id="cliente_email" maxlength="47">
                            <label for="cliente_email" class="form-label">Email <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="password" class="form-control" name="cliente_clave_1_reg" id="cliente_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                            <label for="cliente_clave_1" class="form-label">Contraseña <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="password" class="form-control" name="cliente_clave_2_reg" id="cliente_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                            <label for="cliente_clave_2" class="form-label">Repita contraseña <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-4">
                            <span><strong>Seleccione el estado de la cuenta</strong></span>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="cliente_estado_reg" value="Activa" id="cliente_estado_activa" checked />
                                <label class="form-check-label" for="cliente_estado_activa">Activa</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="cliente_estado_reg" value="Deshabilitada" id="cliente_estado_deshabilitada" />
                                <label class="form-check-label" for="cliente_estado_deshabilitada">Deshabilitada</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-4">
                            <span><strong>Seleccione la verificación de la cuenta</strong></span>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="cliente_verificacion_reg" value="Verificada" id="cliente_verificacion_verificada" checked />
                                <label class="form-check-label" for="cliente_verificacion_verificada">Verificada</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="cliente_verificacion_reg" value="No verificada" id="cliente_verificacion_no_verificada" />
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
                        $check="checked";
                        $c=1;
                        while($avatar=readdir($directorio_avatar)){
                            if(is_file("./vistas/assets/avatar/".$avatar)){
                                echo '
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="form-check radio-avatar-form">
                                            <input type="radio" class="form-check-input" name="cliente_avatar_reg" id="radio_avatar_'.$c.'" value="'.$avatar.'" '.$check.' >
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
        <p class="text-center" style="margin-top: 40px;">
            <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
        </p>
        <p class="text-center">
            <small>Los campos marcados con <?php echo FIELD_OBLIGATORY; ?> son obligatorios</small>
        </p>
    </form>
</div>