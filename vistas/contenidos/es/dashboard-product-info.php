<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-info-circle fa-fw"></i> &nbsp; Información de producto
    </h3>
</div>

<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <?php if($_SESSION['cargo_sto']=="Administrador"){ ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/product-new/" ><i class="fas fa-plus fa-fw"></i> &nbsp; Agregar producto</a>
            </li>
        <?php } ?>
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
    <div class="dashboard-container" >
        <?php
            include "./vistas/inc/".LANG."/btn_go_back.php";
            
            $datos_producto=$ins_login->datos_tabla("Unico","producto","producto_id",$pagina[2]);
            if($datos_producto->rowCount()==1){
                $campos=$datos_producto->fetch();
                $total_price=$campos['producto_precio_venta']-($campos['producto_precio_venta']*($campos['producto_descuento']/100));
        ?>
        <h4 class="font-weight-bold text-center poppins-regular tittle-details"><?php echo $campos['producto_nombre']; ?></h4>
        <br>
        <fieldset class="mb-4">
            <legend><i class="fas fa-barcode"></i> &nbsp; Código de barras y SKU</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $campos['producto_codigo']; ?>" id="producto_codigo" readonly >
                            <label for="producto_codigo" class="form-label">Código de barras</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $campos['producto_sku']; ?>" id="producto_sku" readonly >
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
                            <input type="text" class="form-control" value="<?php echo $campos['producto_nombre']; ?>"  id="producto_nombre" readonly >
                            <label for="producto_nombre" class="form-label">Nombre</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $campos['producto_precio_compra']; ?>" id="producto_precio_compra" readonly >
                            <label for="producto_precio_compra" class="form-label">Precio de compra (Con impuesto incluido)</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $campos['producto_precio_venta']; ?>" id="producto_precio_venta" readonly >
                            <label for="producto_precio_venta" class="form-label">Precio de venta (Con impuesto incluido)</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $total_price; ?>" id="producto_precio_venta_final" readonly >
                            <label for="producto_precio_venta_final" class="form-label">Precio de venta final (Con descuento incluido)</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $campos['producto_stock']; ?>" id="producto_stock" readonly >
                            <label for="producto_stock" class="form-label">Stock o existencias</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $campos['producto_stock_minimo']; ?>" id="producto_stock_minimo" readonly >
                            <label for="producto_stock_minimo" class="form-label">Stock mínimo</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $campos['producto_descuento']; ?>" id="producto_descuento" readonly >
                            <label for="producto_descuento" class="form-label">Descuento</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $campos['producto_marca']; ?>" id="producto_marca" readonly >
                            <label for="producto_marca" class="form-label">Fabricante</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $campos['producto_modelo']; ?>" id="producto_modelo" readonly >
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
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $campos['producto_tipo']; ?>" id="producto_tipo" readonly >
                            <label for="producto_tipo" class="form-label">Tipo de producto</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $campos['producto_presentacion']; ?>" id="producto_presentacion" readonly >
                            <label for="producto_presentacion" class="form-label">Presentación de producto</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <?php
                                $nombre_categoria=$ins_login->datos_tabla("Unico","categoria","categoria_id",$ins_login->encryption($campos['categoria_id']));
                                $nombre_categoria=$nombre_categoria->fetch();
                            ?>
                            <input type="text" class="form-control" value="<?php echo $nombre_categoria['categoria_nombre']; ?>" id="producto_categoria" readonly >
                            <label for="producto_categoria" class="form-label">Categoría de producto</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" value="<?php echo $campos['producto_estado']; ?>" id="producto_estado" readonly >
                            <label for="producto_estado" class="form-label">Estado de producto</label>
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
                            <textarea class="form-control" id="producto_descripcion" rows="7" readonly ><?php echo $campos['producto_descripcion']; ?></textarea>
                            <label for="producto_descripcion" class="form-label">Descripción</label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <?php
            }else{ include "./vistas/inc/".LANG."/error_alert.php";}
        ?>
    </div>
</div>