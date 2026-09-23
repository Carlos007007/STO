<?php
    include "./vistas/inc/admin_security.php";
?>

<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-plus fa-fw"></i> &nbsp; Nueva caja
    </h3>
</div>


<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="<?php echo SERVERURL.DASHBOARD; ?>/cashRegister-new/" ><i class="fas fa-plus fa-fw"></i> &nbsp; Nueva caja</a>
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
    <form class="dashboard-container FormularioAjax" method="POST" data-form="save" data-lang="<?php echo LANG; ?>" autocomplete="off" action="<?php echo SERVERURL;?>ajax/cajaAjax.php" >
        <input type="hidden" name="modulo_caja" value="registro">
        <fieldset class="mb-4">
            <legend><i class="far fa-address-card"></i> &nbsp; Información de caja</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[0-9]{1,5}" class="form-control" name="caja_numero_reg" id="caja_numero" maxlength="5">
                            <label for="caja_numero" class="form-label">Numero de caja <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ:# ]{3,70}" class="form-control" name="caja_nombre_reg" id="caja_nombre" maxlength="35">
                            <label for="caja_nombre" class="form-label">Nombre o código de caja <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[0-9.]{1,25}" class="form-control" name="caja_efectivo_reg" id="caja_efectivo" maxlength="25" value="0.00" >
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
                                <input class="form-check-input" type="radio" name="caja_estado_reg" value="Habilitada" id="caja_estado_activa" checked />
                                <label class="form-check-label" for="caja_estado_activa">Habilitada</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="caja_estado_reg" value="Deshabilitada" id="caja_estado_deshabilitada" />
                                <label class="form-check-label" for="caja_estado_deshabilitada">Deshabilitada</label>
                            </div>
                        </div>
                    </div>
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