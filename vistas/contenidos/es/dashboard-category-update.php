<?php
    include "./vistas/inc/admin_security.php";
?>
<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-sync-alt fa-fw"></i> &nbsp; Actualizar categoría
    </h3>
</div>


<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/category-new/" ><i class="fas fa-plus fa-fw"></i> &nbsp; Nueva categoría</a>
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
    <?php
        include "./vistas/inc/".LANG."/btn_go_back.php";
        
        $datos_categoria=$ins_login->datos_tabla("Unico","categoria","categoria_id",$pagina[2]);
        if($datos_categoria->rowCount()==1){
            $campos=$datos_categoria->fetch();
    ?>
    <form class="dashboard-container FormularioAjax" method="POST" data-form="update" data-lang="<?php echo LANG; ?>" autocomplete="off" action="<?php echo SERVERURL;?>ajax/categoriaAjax.php" >
        <input type="hidden" name="modulo_categoria" value="actualizar">
        <input type="hidden" name="categoria_id_up" value="<?php echo $pagina[2]; ?>">
        <fieldset class="mb-4">
            <legend><i class="fas fa-tag fa-fw"></i> &nbsp; Información de categoría</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,49}" class="form-control" name="categoria_nombre_up" value="<?php echo $campos['categoria_nombre']; ?>" id="categoria_nombre" maxlength="49">
                            <label for="categoria_nombre" class="form-label">Nombre <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="">
                            <select class="form-control" name="categoria_estado_up" id="categoria_estado">
                                <?php
                                    $array_estado=["Habilitada","Deshabilitada"];
                                    echo $ins_login->generar_select($array_estado,$campos['categoria_estado']);
                                ?>
                            </select>
                            <label for="categoria_estado" class="form-label"></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-outline mb-4">
                            <textarea pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\s ]{4,700}" class="form-control" name="categoria_descripcion_up" id="categoria_descripcion" maxlength="700" rows="7"><?php echo $campos['categoria_descripcion']; ?></textarea>
                            <label for="categoria_descripcion" class="form-label">Descripción</label>
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