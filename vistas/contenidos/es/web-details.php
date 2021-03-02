<div class="full-box bg-white">
    <div class="container container-web-page">
        <h3 class="font-weight-bold poppins-regular text-uppercase">Detalles del producto</h3>
        <hr>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-5">
                    <!--cover-->
                    <figure class="full-box">
                        <img class="img-fluid" src="<?php echo SERVERURL; ?>vistas/assets/product/product.jpg" alt="product_">
                    </figure>
    
                    <!-- Galery -->
                    <h5 class="poppins-regular text-uppercase" style="padding-top: 70px;">Galería de imágenes</h5>
                    <hr>
                    <div class="galery-details full-box">
    
                        <!--cover-->
                        <figure class="full-box">
                            <a data-fslightbox="gallery" href="<?php echo SERVERURL; ?>vistas/assets/img/banner_3.jpg">
                                <img class="img-fluid" src="<?php echo SERVERURL; ?>vistas/assets/img/banner_3.jpg" alt="platillo_">
                            </a>
                        </figure>
    
                        <!--otras-->
                        <figure class="full-box">
                            <a data-fslightbox="gallery" href="<?php echo SERVERURL; ?>vistas/assets/img/banner_1.jpg">
                                <img class="img-fluid" src="<?php echo SERVERURL; ?>vistas/assets/img/banner_1.jpg" alt="platillo_">
                            </a>
                        </figure>
    
                        <figure class="full-box">
                            <a data-fslightbox="gallery" href="<?php echo SERVERURL; ?>vistas/assets/img/banner_2.jpg">
                                <img class="img-fluid" src="<?php echo SERVERURL; ?>vistas/assets/img/banner_2.jpg" alt="platillo_">
                            </a>
                        </figure>
    
                    </div>
                </div>
                <div class="col-12 col-lg-7">
    
                    <h4 class="font-weight-bold poppins-regular tittle-details">Nombre del producto</h4>
    
                    <p class="text-justify lead" style="padding: 40px 0;">
                        <span class="text-info lead font-weight-bold">Descripción:</span><br>
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perspiciatis obcaecati, corporis nam ab officiis modi nesciunt iure repudiandae vel! Illum minus sapiente sunt quibusdam vero voluptate sequi eaque consectetur perferendis!
                    </p>
    
                    <p class="lead font-weight-bold">Precio: $25.00 USD</p>
    
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
            </div>
        </div>
    </div>
</div>     

<script src="<?php echo SERVERURL; ?>vistas/js/fslightbox.js"></script>