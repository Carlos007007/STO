<?php
    include "./vistas/inc/admin_security.php";
?>

<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-sync-alt fa-fw"></i> &nbsp; Actualizar caja
    </h3>
</div>

<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/cashRegister-new/" ><i class="fas fa-plus fa-fw"></i> &nbsp; Nueva caja</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/cashRegister-list/" ><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de cajas</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/cashRegister-search/" ><i class="fas fa-search fa-fw"></i> &nbsp; Buscar caja</a>
        </li>
    </ul>
</div>

<div class="container-fluid">
    <?php
        include "./vistas/inc/".LANG."/btn_go_back.php";
        
        $datos_caja=$ins_login->datos_tabla("Unico","caja","caja_id",$pagina[2]);
        if($datos_caja->rowCount()==1){
            $campos=$datos_caja->fetch();
    ?>
    <form class="dashboard-container FormularioAjax" method="POST" data-form="update" data-lang="<?php echo LANG; ?>" autocomplete="off" action="<?php echo SERVERURL;?>ajax/cajaAjax.php" >
        <input type="hidden" name="modulo_caja" value="actualizar">
        <input type="hidden" name="caja_id_up" value="<?php echo $pagina[2]; ?>">
        <fieldset class="mb-4">
            <legend><i class="far fa-address-card"></i> &nbsp; Información de caja</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[0-9]{1,5}" class="form-control" name="caja_numero_up" id="caja_numero" maxlength="5" value="<?php echo $campos['caja_numero']; ?>" >
                            <label for="caja_numero" class="form-label">Numero de caja <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ:# ]{3,70}" class="form-control" name="caja_nombre_up" id="caja_nombre" maxlength="35" value="<?php echo $campos['caja_nombre']; ?>" >
                            <label for="caja_nombre" class="form-label">Nombre o código de caja <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[0-9.]{1,25}" class="form-control" name="caja_efectivo_up" id="caja_efectivo" maxlength="25" value="<?php echo $campos['caja_efectivo']; ?>" >
                            <label for="caja_efectivo" class="form-label">Efectivo en caja</label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="mb-4">
                            <span><strong>Seleccione el estado de la caja</strong></span>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="caja_estado_up" value="Habilitada" id="caja_estado_activa" <?php if($campos['caja_estado']=="Habilitada"){ echo "checked"; } ?> />
                                <label class="form-check-label" for="caja_estado_activa">Habilitada</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="caja_estado_up" value="Deshabilitada" id="caja_estado_deshabilitada" <?php if($campos['caja_estado']=="Deshabilitada"){ echo "checked"; } ?> />
                                <label class="form-check-label" for="caja_estado_deshabilitada">Deshabilitada</label>
                            </div>
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