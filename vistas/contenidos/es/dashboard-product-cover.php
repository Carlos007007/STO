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
    <div class="full-box dashboard-container">
        <?php
            include "./vistas/inc/".LANG."/btn_go_back.php";
            
            $datos_producto=$ins_login->datos_tabla("Unico","producto","producto_id",$pagina[2]);
            if($datos_producto->rowCount()==1){
                $campos=$datos_producto->fetch();
        ?>
        <h3 class="text-center"><?php echo $campos['producto_nombre']; ?></h3>
        <hr>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6">
                    <?php if(is_file("./vistas/assets/product/cover/".$campos['producto_portada'])){ ?>
                        <form class="FormularioAjax" data-lang="<?php echo LANG; ?>" action="<?php echo SERVERURL; ?>ajax/productoAjax.php" method="POST" data-form="delete" autocomplete="off" >
                            <input type="hidden" name="modulo_producto" value="portada_eliminar">
                            <input type="hidden" name="producto_id" value="<?php echo $pagina[2]; ?>">
                            <figure>
                                <img class="img-fluid img-product-info" src="<?php echo SERVERURL; ?>vistas/assets/product/cover/<?php echo $campos['producto_portada']; ?>" alt="<?php echo $campos['producto_nombre']; ?>">
                            </figure>
                            <p class="text-center" style="margin-top: 40px;">
                                <button type="submit" class="btn btn-danger btn-sm">
                                <i class="far fa-trash-alt"></i> &nbsp; ELIMINAR IMAGEN</button>
                            </p>
                        </form>
                    <?php }else{ ?>
                        <figure>
                            <img class="img-fluid img-product-info" src="<?php echo SERVERURL; ?>vistas/assets/product/cover/default.jpg" alt="<?php echo $campos['producto_nombre']; ?>">
                        </figure>
                    <?php } ?>
                </div>
                <div class="col-12 col-md-6">
                    <form class="FormularioAjax dashboard-container" data-lang="<?php echo LANG; ?>" action="<?php echo SERVERURL; ?>ajax/productoAjax.php" method="POST" data-form="update" autocomplete="off" enctype="multipart/form-data" >
                        <input type="hidden" name="producto_id" value="<?php echo $pagina[2]; ?>">
                        <input type="hidden" name="modulo_producto" value="portada_actualizar">
                        <fieldset>
                            <legend><i class="far fa-file-image"></i> &nbsp; Foto o portada de producto</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="producto_portada" class="form-label">Tipos de archivos permitidos: JPG, JPEG, PNG. Tamaño máximo <?php echo COVER_PRODUCT; ?>MB. Resolución recomendada 500px X 500px o superior manteniendo el aspecto cuadrado (1:1)</label>
                                        <input class="form-control form-control-sm" id="producto_portada" name="producto_portada" type="file" />
                                        <p class="text-center" style="margin-top: 40px;">
                                            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-sync"></i> &nbsp; ACTUALIZAR IMAGEN</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <?php
            }else{ include "./vistas/inc/".LANG."/error_alert.php";}
        ?>
    </div>
</div>
