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
                <div class="col-12 col-md-6 offset-md-3">
                    <form class="FormularioAjax" data-lang="<?php echo LANG; ?>" action="<?php echo SERVERURL; ?>ajax/productoAjax.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data" >
                        <input type="hidden" name="producto_id" value="<?php echo $pagina[2]; ?>">
                        <input type="hidden" name="modulo_producto" value="galeria_agregar">
                        <fieldset>
                            <legend><i class="fas fa-plus"></i> &nbsp; Agregar imagen a galería</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="producto_galeria" class="form-label">Tipos de archivos permitidos: JPG, JPEG, PNG. Tamaño máximo <?php echo GALLERY_PRODUCT; ?>MB. Resolución recomendada 500px X 500px o superior.</label>
                                        <input class="form-control form-control-sm" id="producto_galeria" name="producto_galeria" type="file" />
                                        <p class="text-center" style="margin-top: 40px;">
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR IMAGEN</button>
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
            $datos_galeria=$ins_login->datos_tabla("Normal","imagen WHERE producto_id='".$campos['producto_id']."'","*",0);

            if($datos_galeria->rowCount()>0){
        ?>
        <hr>

        <div class="container">
            <legend class="text-center"><i class="far fa-images"></i> &nbsp; Imágenes del producto</legend>
            <div class="row">
                <?php
                    while($campos_galeria=$datos_galeria->fetch()){
                ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="dashboard-container" style="margin: 3px;">
                        <form class="FormularioAjax" data-lang="<?php echo LANG; ?>" action="<?php echo SERVERURL; ?>ajax/productoAjax.php" method="POST" data-form="delete" autocomplete="off" >
                            <input type="hidden" name="modulo_producto" value="galeria_eliminar">
                            <input type="hidden" name="producto_id" value="<?php echo $pagina[2]; ?>">
                            <input type="hidden" name="imagen_id" value="<?php echo $ins_login->encryption($campos_galeria['imagen_id']); ?>">
                            <?php if(is_file("./vistas/assets/product/gallery/".$campos_galeria['imagen_nombre'])){ ?>
                                <figure>
                                    <a data-fslightbox="gallery" href="<?php echo SERVERURL; ?>vistas/assets/product/gallery/<?php echo $campos_galeria['imagen_nombre']; ?>">
                                        <img class="img-fluid img-product-info" src="<?php echo SERVERURL; ?>vistas/assets/product/gallery/<?php echo $campos_galeria['imagen_nombre']; ?>" alt="<?php echo $campos['producto_nombre']; ?>">
                                    </a>
                                </figure>
                            <?php }else{ ?>
                                <figure>
                                    <img class="img-fluid img-product-info" src="<?php echo SERVERURL; ?>vistas/assets/product/gallery/default.jpg" alt="<?php echo $campos['producto_nombre']; ?>">
                                </figure>
                            <?php } ?>
                            <p class="text-center" style="margin-top: 40px;">
                                <button type="submit" class="btn btn-danger btn-sm">
                                <i class="far fa-trash-alt"></i> &nbsp; ELIMINAR IMAGEN</button>
                            </p>
                        </form>
                    </div>
                </div>
                <?php } ?>

            </div>
        </div>
        <script src="<?php echo SERVERURL; ?>vistas/js/fslightbox.js"></script>
        <?php 
                }
            }else{ include "./vistas/inc/".LANG."/error_alert.php";}
        ?>
    </div>
</div>
