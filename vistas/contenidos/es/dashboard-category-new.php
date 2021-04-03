<?php
    include "./vistas/inc/admin_security.php";
?>
<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-plus fa-fw"></i> &nbsp; Nueva categoría
    </h3>
</div>


<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="<?php echo SERVERURL.DASHBOARD; ?>/category-new/" ><i class="fas fa-plus fa-fw"></i> &nbsp; Nueva categoría</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/category-list/" ><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de categorías</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/category-search/" ><i class="fas fa-search fa-fw"></i> &nbsp; Buscar categoría</a>
        </li>
    </ul>
</div>


<div class="container-fluid">
    <form class="dashboard-container FormularioAjax" method="POST" data-form="save" data-lang="<?php echo LANG; ?>" autocomplete="off" action="<?php echo SERVERURL;?>ajax/categoriaAjax.php">
        <input type="hidden" name="modulo_categoria" value="registro">
        <fieldset class="mb-4">
            <legend><i class="fas fa-tag fa-fw"></i> &nbsp; Información de categoría</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,49}" class="form-control" name="categoria_nombre_reg" id="categoria_nombre" maxlength="49">
                            <label for="categoria_nombre" class="form-label">Nombre <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="">
                            <select class="form-control" name="categoria_estado_reg" id="categoria_estado">
                                <option value="" selected="" >Estado de categoría</option>
                                <option value="Habilitada" >Habilitada</option>
                                <option value="Deshabilitada" >Deshabilitada</option>
                            </select>
                            <label for="categoria_estado" class="form-label"></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-outline mb-4">
                            <textarea pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\s ]{4,700}" class="form-control" name="categoria_descripcion_reg" id="categoria_descripcion" maxlength="700" rows="7"></textarea>
                            <label for="categoria_descripcion" class="form-label">Descripción</label>
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