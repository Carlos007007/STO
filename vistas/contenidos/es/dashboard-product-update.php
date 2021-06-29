<?php
    include "./vistas/inc/admin_security.php";
?>
<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-sync-alt fa-fw"></i> &nbsp; Actualizar producto
    </h3>
</div>

<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/product-new/" ><i class="fas fa-plus fa-fw"></i> &nbsp; Agregar producto</a>
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
    <div class="dashboard-container">
        <?php
            include "./vistas/inc/".LANG."/btn_go_back.php";
            
            $datos_producto=$ins_login->datos_tabla("Unico","producto","producto_id",$pagina[2]);
            if($datos_producto->rowCount()==1){
                $campos=$datos_producto->fetch();
        ?>
        <h4 class="font-weight-bold text-center poppins-regular tittle-details"><?php echo $campos['producto_nombre']; ?></h4>
        <br>
        <form class="FormularioAjax" method="POST" data-form="update" data-lang="<?php echo LANG; ?>" autocomplete="off" action="<?php echo SERVERURL;?>ajax/productoAjax.php" >
            <input type="hidden" name="modulo_producto" value="actualizar">
            <input type="hidden" name="producto_id_up" value="<?php echo $pagina[2]; ?>">
            <fieldset class="mb-4">
                <legend><i class="fas fa-barcode"></i> &nbsp; Código de barras y SKU</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[a-zA-Z0-9- ]{1,49}" class="form-control" name="producto_codigo_up" value="<?php echo $campos['producto_codigo']; ?>" id="producto_codigo" maxlength="49">
                                <label for="producto_codigo" class="form-label">Código de barras <?php echo FIELD_OBLIGATORY; ?></label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[a-zA-Z0-9- ]{1,49}" class="form-control" name="producto_sku_up" value="<?php echo $campos['producto_sku']; ?>" id="producto_sku" maxlength="49">
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
                                <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\- ]{1,97}" class="form-control" name="producto_nombre_up" value="<?php echo $campos['producto_nombre']; ?>" id="producto_nombre" maxlength="97">
                                <label for="producto_nombre" class="form-label">Nombre <?php echo FIELD_OBLIGATORY; ?></label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[0-9.]{1,25}" class="form-control" name="producto_precio_compra_up" value="<?php echo $campos['producto_precio_compra']; ?>" id="producto_precio_compra" maxlength="25">
                                <label for="producto_precio_compra" class="form-label">Precio de compra (Con impuesto incluido) <?php echo FIELD_OBLIGATORY; ?></label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[0-9.]{1,25}" class="form-control" name="producto_precio_venta_up" value="<?php echo $campos['producto_precio_venta']; ?>" id="producto_precio_venta" maxlength="25">
                                <label for="producto_precio_venta" class="form-label">Precio de venta (Con impuesto incluido) <?php echo FIELD_OBLIGATORY; ?></label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[0-9]{1,9}" class="form-control" name="producto_stock_up" value="<?php echo $campos['producto_stock']; ?>" id="producto_stock" maxlength="9">
                                <label for="producto_stock" class="form-label">Stock o existencias <?php echo FIELD_OBLIGATORY; ?></label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[0-9]{1,9}" class="form-control" name="producto_stock_minimo_up" value="<?php echo $campos['producto_stock_minimo']; ?>" id="producto_stock_minimo" maxlength="9">
                                <label for="producto_stock_minimo" class="form-label">Stock mínimo <?php echo FIELD_OBLIGATORY; ?></label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[0-9]{1,2}" class="form-control" name="producto_descuento_up" value="<?php echo $campos['producto_descuento']; ?>" id="producto_descuento" maxlength="2">
                                <label for="producto_descuento" class="form-label">Descuento <?php echo FIELD_OBLIGATORY; ?></label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,30}" class="form-control" name="producto_marca_up" value="<?php echo $campos['producto_marca']; ?>" id="producto_marca" maxlength="30">
                                <label for="producto_marca" class="form-label">Fabricante</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,40}" class="form-control" name="producto_modelo_up" value="<?php echo $campos['producto_modelo']; ?>" id="producto_modelo" maxlength="40">
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
                                <select class="form-control" name="producto_tipo_up" id="producto_tipo">
                                    <?php
                                        $array_tipo=["Fisico","Digital"];
                                        echo $ins_login->generar_select($array_tipo,$campos['producto_tipo']);
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-4">
                                <label for="producto_presentacion" class="form-label">Presentación de producto</label>
                                <select class="form-control" name="producto_presentacion_up" id="producto_presentacion">
                                    <?php
                                        echo $ins_login->generar_select(PRODUTS_UNITS,$campos['producto_presentacion']);
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-4">
                                <label for="producto_categoria" class="form-label">Categoría de producto</label>
                                <select class="form-control" name="producto_categoria_up" id="producto_categoria">
                                    <?php
                                        $datos_categoria=$ins_login->datos_tabla("Normal","categoria WHERE categoria_estado='Habilitada'","categoria_id,categoria_nombre,categoria_estado",0);
                                        $cc=1;
                                        $txt_selected='';
                                        $txt_current='';
                                        while($campos_categoria=$datos_categoria->fetch()){

                                            if($campos['categoria_id']==$campos_categoria['categoria_id']){
                                                $txt_selected='selected=""';
                                                $txt_current=' (Actual)'; 
                                            }

                                            echo '<option value="'.$campos_categoria['categoria_id'].'" '.$txt_selected.' >'.$cc.' - '.$campos_categoria['categoria_nombre'].$txt_current.'</option>';

                                            $txt_selected='';
                                            $txt_current='';
                                            $cc++;
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-4">
                                <label for="producto_estado" class="form-label">Estado de producto</label>
                                <select class="form-control" name="producto_estado_up" id="producto_estado">
                                    <?php
                                        $array_estado=["Habilitado","Deshabilitado"];
                                        echo $ins_login->generar_select($array_estado,$campos['producto_estado']);
                                    ?>
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
                                <textarea pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\s ]{4,520}" class="form-control" name="producto_descripcion_up" id="producto_descripcion" maxlength="520" rows="7"><?php echo $campos['producto_descripcion']; ?></textarea>
                                <label for="producto_descripcion" class="form-label">Descripción</label>
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
</div>