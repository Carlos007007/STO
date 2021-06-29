<div class="full-box bg-white">
    <div class="container container-web-page">
        <h3 class="font-weight-bold poppins-regular text-uppercase">Detalles del producto</h3>
        <hr>
        <div class="container-fluid">
            <div class="row">
                <?php
                    include "./vistas/inc/".LANG."/btn_go_back.php";
                    
                    $datos_producto=$ins_login->datos_tabla("Unico","producto","producto_id",$pagina[1]);
                    if($datos_producto->rowCount()==1){
                        $campos=$datos_producto->fetch();
                        $total_price=$campos['producto_precio_venta']-($campos['producto_precio_venta']*($campos['producto_descuento']/100));
                ?>
                <div class="col-12 col-lg-5">
                    <figure class="full-box">
                        <?php if(is_file("./vistas/assets/product/cover/".$campos['producto_portada'])){ ?>
                            <img class="img-fluid" src="<?php echo SERVERURL."vistas/assets/product/cover/".$campos['producto_portada']; ?>" alt="<?php echo $campos['producto_nombre']; ?>">
                        <?php }else{ ?>
                            <img class="img-fluid" src="<?php echo SERVERURL; ?>vistas/assets/product/cover/default.jpg" alt="<?php echo $campos['producto_nombre']; ?>">
                        <?php } ?>
                    </figure>
                </div>
                <div class="col-12 col-lg-7">
    
                    <h4 class="font-weight-bold poppins-regular tittle-details"><?php echo $campos['producto_nombre']; ?></h4>

                    <div class="container-fluid" style="padding-top: 50px;">
                        <div class="row">
                            <div class="col-12 col-md-6 mb-4">
                                <strong class="text-uppercase"><i class="fas fa-pallet fa-fw"></i> Tipo:</strong> &nbsp: <?php echo $campos['producto_tipo']; ?>
                            </div>
                            <div class="col-12 col-md-6 mb-4"">
                                <strong class="text-uppercase"><i class="fas fa-box fa-fw"></i> Stock:</strong> &nbsp: <?php if($campos['producto_tipo']=="Fisico"){ echo $campos['producto_stock']; }else{ echo "Disponible"; } ?>
                            </div>
                            <div class="col-12 col-md-6 mb-4"">
                                <strong class="text-uppercase"><i class="far fa-registered fa-fw"></i> Fabricante:</strong> &nbsp: <?php echo $campos['producto_marca']; ?>
                            </div>
                            <div class="col-12 col-md-6 mb-4"">
                                <strong class="text-uppercase"><i class="fas fa-crown fa-fw"></i> Modelo:</strong> &nbsp: <?php echo $campos['producto_modelo']; ?>
                            </div>
                        </div>
                    </div>
                            
                    <?php if($campos['producto_descripcion']!=""){ ?>
                    <p class="text-justify lead" style="padding: 40px 0;">
                        <span class="lead text-uppercase font-weight-bold">Descripción:</span><br>
                        <?php echo $campos['producto_descripcion']; ?>
                    </p>
                    <?php } ?>

                    <p class="font-weight-bold text-uppercase" style="font-size: 22px;"><i class="far fa-credit-card fa-fw"></i> Precio: <span class="text-primary"><?php echo COIN_SYMBOL.number_format($total_price,COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME; ?></span></p>
                    
                    <!-- Agregar al carrito -->
                    <form action="" style="padding-top: 70px;">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-outline mb-4">
                                        <input type="text" value="1" class="form-control text-center" id="product_cant" pattern="[0-9]{1,10}" maxlength="10" >
                                        <label for="product_cant" class="form-label">Cantidad</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 text-center">
                                    <button type="submit" class="btn btn-info"><i class="fas fa-shopping-bag fa-fw"></i> &nbsp; Agregar al carrito</button>
                                </div>
                            </div>
                        </div>
                    </form>
    
                    <!-- Actualizar el carrito -->
                    <form action="" style="padding-top: 70px;">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-outline mb-4">
                                        <input type="text" value="1" class="form-control text-center" id="product_cant" pattern="[0-9]{1,10}" maxlength="10" >
                                        <label for="product_cant" class="form-label">Cantidad</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 text-center">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-sync fa-fw"></i> &nbsp; Actualizar carrito</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

                <?php
                    $datos_galeria=$ins_login->datos_tabla("Normal","imagen WHERE producto_id='".$campos['producto_id']."'","*",0);

                    if($datos_galeria->rowCount()>0){
                ?>
                <div class="col-12">
                    <h5 class="poppins-regular text-uppercase" style="padding-top: 70px;">Galería de imágenes</h5>
                    <hr>
                    <div class="galery-details full-box">
                        
                        <?php while($campos_galeria=$datos_galeria->fetch()){ ?>
                        <figure class="full-box">
                            <?php if(is_file("./vistas/assets/product/gallery/".$campos_galeria['imagen_nombre'])){ ?>
                            <a data-fslightbox="gallery" href="<?php echo SERVERURL; ?>vistas/assets/product/gallery/<?php echo $campos_galeria['imagen_nombre']; ?>">
                                <img class="img-fluid" src="<?php echo SERVERURL; ?>vistas/assets/product/gallery/<?php echo $campos_galeria['imagen_nombre']; ?>" alt="<?php echo $campos['producto_nombre']; ?>">
                            </a>
                            <?php }else{ ?>
                            <a data-fslightbox="gallery" href="<?php echo SERVERURL; ?>vistas/assets/product/gallery/default.jpg">
                                <img class="img-fluid" src="<?php echo SERVERURL; ?>vistas/assets/product/gallery/default.jpg" alt="<?php echo $campos['producto_nombre']; ?>">
                            </a>
                            <?php } ?>
                        </figure>
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
    </div>
</div>