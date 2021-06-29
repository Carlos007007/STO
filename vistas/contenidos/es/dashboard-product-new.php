<?php
    include "./vistas/inc/admin_security.php";
?>
<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-plus fa-fw"></i> &nbsp; Agregar producto
    </h3>
</div>

<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="<?php echo SERVERURL.DASHBOARD; ?>/product-new/" ><i class="fas fa-plus fa-fw"></i> &nbsp; Agregar producto</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/product-list/" ><i class="fas fa-boxes fa-fw"></i> &nbsp; Inventario de productos</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/product-minimum/" ><i class="fas fa-stopwatch-20 fa-fw"></i> &nbsp; Productos en stock mínimo</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/product-search/" ><i class="fas fa-search fa-fw"></i> &nbsp; Buscar producto</a>
        </li>
    </ul>
</div>

<div class="container-fluid">
    <form class="dashboard-container FormularioAjax" method="POST" data-form="save" data-lang="<?php echo LANG; ?>" autocomplete="off" action="<?php echo SERVERURL;?>ajax/productoAjax.php" enctype="multipart/form-data" >
        <input type="hidden" name="modulo_producto" value="registro">
        <fieldset class="mb-4">
            <legend><i class="fas fa-barcode"></i> &nbsp; Código de barras y SKU</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-Z0-9- ]{1,49}" class="form-control" name="producto_codigo_reg" id="producto_codigo" maxlength="49">
                            <label for="producto_codigo" class="form-label">Código de barras <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-Z0-9- ]{1,49}" class="form-control" name="producto_sku_reg" id="producto_sku" maxlength="49">
                            <label for="producto_sku" class="form-label">SKU</label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <legend><i class="fas fa-box"></i> &nbsp; Información del producto</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\- ]{1,97}" class="form-control" name="producto_nombre_reg" id="producto_nombre" maxlength="97">
                            <label for="producto_nombre" class="form-label">Nombre <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[0-9.]{1,25}" class="form-control" name="producto_precio_compra_reg" id="producto_precio_compra" maxlength="25">
                            <label for="producto_precio_compra" class="form-label">Precio de compra (Con impuesto incluido) <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[0-9.]{1,25}" class="form-control" name="producto_precio_venta_reg" id="producto_precio_venta" maxlength="25">
                            <label for="producto_precio_venta" class="form-label">Precio de venta (Con impuesto incluido) <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[0-9]{1,9}" class="form-control" name="producto_stock_reg" id="producto_stock" maxlength="9">
                            <label for="producto_stock" class="form-label">Stock o existencias <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[0-9]{1,9}" class="form-control" name="producto_stock_minimo_reg" id="producto_stock_minimo" maxlength="9">
                            <label for="producto_stock_minimo" class="form-label">Stock mínimo <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[0-9]{1,2}" class="form-control" name="producto_descuento_reg" value="0" id="producto_descuento" maxlength="2">
                            <label for="producto_descuento" class="form-label">Descuento <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,30}" class="form-control" name="producto_marca_reg" id="producto_marca" maxlength="30">
                            <label for="producto_marca" class="form-label">Fabricante</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,40}" class="form-control" name="producto_modelo_reg" id="producto_modelo" maxlength="40">
                            <label for="producto_modelo" class="form-label">Modelo</label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <legend><i class="fas fa-parachute-box"></i> &nbsp; Tipo, Presentación, Categoría & Estado</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="mb-4">
                            <label for="producto_tipo" class="form-label">Tipo de producto</label>
                            <select class="form-control" name="producto_tipo_reg" id="producto_tipo">
                                <option value="" selected="" >** Tipo de producto **</option>
                                <option value="Fisico" >Fisico</option>
                                <option value="Digital" >Digital</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-4">
                            <label for="producto_presentacion" class="form-label">Presentación de producto</label>
                            <select class="form-control" name="producto_presentacion_reg" id="producto_presentacion">
                                <option value="" selected="" >** Presentación de producto **</option>
                                <?php
                                    echo $ins_login->generar_select(PRODUTS_UNITS,"");
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-4">
                            <label for="producto_categoria" class="form-label">Categoría de producto</label>
                            <select class="form-control" name="producto_categoria_reg" id="producto_categoria">
                                <option value="" selected="" >** Categoría de producto **</option>
                                <?php
                                    $datos_categoria=$ins_login->datos_tabla("Normal","categoria WHERE categoria_estado='Habilitada'","categoria_id,categoria_nombre,categoria_estado",0);
                                    $cc=1;
                                    while($campos_categoria=$datos_categoria->fetch()){
                                        echo '<option value="'.$campos_categoria['categoria_id'].'">'.$cc.' - '.$campos_categoria['categoria_nombre'].'</option>';
                                        $cc++;
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-4">
                            <label for="producto_estado" class="form-label">Estado de producto</label>
                            <select class="form-control" name="producto_estado_reg" id="producto_estado">
                                <option value="" selected="" >** Estado de producto **</option>
                                <option value="Habilitado" >Habilitado</option>
                                <option value="Deshabilitado" >Deshabilitado</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <legend><i class="far fa-comment-dots"></i> &nbsp; Descripción</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="form-outline mb-4">
                            <textarea pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\s ]{4,520}" class="form-control" name="producto_descripcion_reg" id="producto_descripcion" maxlength="520" rows="7"></textarea>
                            <label for="producto_descripcion" class="form-label">Descripción</label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <legend><i class="far fa-file-image"></i> &nbsp; Foto o portada de producto</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-5">
                        <label for="producto_portada" class="form-label">Tipos de archivos permitidos: JPG, JPEG, PNG. Tamaño máximo <?php echo COVER_PRODUCT; ?>MB. Resolución recomendada 500px X 500px o superior manteniendo el aspecto cuadrado (1:1)</label>
                        <input class="form-control form-control-sm" id="producto_portada" name="producto_portada" type="file" />
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