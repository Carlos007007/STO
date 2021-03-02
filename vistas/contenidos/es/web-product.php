<div class="bg-white full-box">
    <div class="container container-web-page">
        <h3 class="font-weight-bold poppins-regular text-uppercase">Productos en tienda</h3>
        <p class="text-justify">Bienvenido al menú de productos, acá encontrara todos los productos disponibles en nuestra tienda. Puede ordenar los productos por categoría en el botón "<i class="fas fa-tags fa-fw"></i> CATEGORÍAS" y también ordenarlos por orden alfabético o por precio en el botón "<i class="fas fa-sort-alpha-down fa-fw"></i> ORDENAR POR". Además, puede buscar productos por nombre haciendo clic en el botón "<i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR"</p>
    
        <div class="container-fluid" style="border-top: 1px solid #E1E1E1; padding: 20px; 0">
            <div class="row align-items-center">
                <div class="col-12 col-sm-4 text-center text-sm-start">
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" id="categorySubMenu" data-mdb-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-tags fa-fw"></i> &nbsp; CATEGORÍAS
                        </button>
                        <div class="dropdown-menu" aria-labelledby="categorySubMenu">
                            <a class="dropdown-item" href="#">Menú 1</a>
                            <a class="dropdown-item" href="#">Menú 2</a>
                            <a class="dropdown-item" href="#">Menú 3</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4 text-center">
                    <button type="button" class="btn btn-link" data-mdb-toggle="modal" data-mdb-target="#saucerModal">
                        <i class="fas fa-search fa-fw"></i> &nbsp; Buscar
                    </button>
                </div>
                <div class="col-12 col-sm-4 text-center text-sm-end">
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" id="OrderSubMenu" data-mdb-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-sort-alpha-down fa-fw"></i> &nbsp; Ordenar por
                        </button>
                        <div class="dropdown-menu" aria-labelledby="OrderSubMenu">
                            <a class="dropdown-item" href="#">Ascendente (A-Z)</a>
                            <a class="dropdown-item" href="#">Descendente (Z-A)</a>
                            <a class="dropdown-item" href="#">Precio (Menor a Mayor)</a>
                            <a class="dropdown-item" href="#">Precio (Mayor a Menor)</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    
        <div class="container-fluid" style="padding: 20px 0;">
            <div class="row">
                <div class="col-12 col-md-8">
                    <p class="text-left lead"><i class="fas fa-search fa-fw"></i> &nbsp; Resultados de la búsqueda: <span class="font-weight-bold poppins-regular text-uppercase">Producto</span></p>
                </div>
                <div class="col-12 col-md-4">
                    <button type="button" class="btn btn-danger">
                        <i class="fas fa-times fa-fw"></i> &nbsp; Eliminar busqueda
                    </button>
                </div>
            </div>
        </div>
    

        <div class="container-cards full-box">

            <div class="card-product div-bordered bg-white shadow-2">
                <figure class="card-product-img">
                    <img class="img-fluid" src="<?php echo SERVERURL; ?>vistas/assets/product/product.jpg" alt="nombre_producto">
                </figure>
                <div class="card-product-body">
                    <div class="card-product-content scroll">
                        <h5 class="text-center fw-bolder">Nombre completo del producto con limite de caracteres</h5>
                        <p class="card-product-price text-center fw-bolder">$10.00 USD</p>
                        <span class="full-box text-center text-muted" style="display: block;">En stock</span>
                    </div>
                    <div class="text-center card-product-options" style="padding: 10px 0;">
                        <button type="button" class="btn btn-link btn-sm btn-rounded text-success" ><i class="fas fa-shopping-bag fa-fw"></i> &nbsp; Agregar</button>
                        &nbsp; &nbsp;
                        <a href="<?php echo SERVERURL; ?>details/" class="btn btn-link btn-sm btn-rounded" ><i class="fas fa-box-open fa-fw"></i> &nbsp; Detalles</a>
                        &nbsp; &nbsp;
                        <button type="button" class="btn btn-link btn-sm btn-rounded" ><i class="fas fa-heart fa-fw"></i></button>
                    </div>
                </div>
            </div>

            <div class="card-product div-bordered bg-white shadow-2">
                <figure class="card-product-img">
                    <img class="img-fluid" src="<?php echo SERVERURL; ?>vistas/assets/img/img_not_found.jpg" alt="nombre_producto">
                </figure>
                <div class="card-product-body">
                    <div class="card-product-content scroll">
                        <h5 class="text-center fw-bolder">Nombre completo del producto con limite de caracteres</h5>
                        <p class="card-product-price text-center fw-bolder">$10.00 USD</p>
                        <span class="full-box text-center text-muted" style="display: block;">En stock</span>
                    </div>
                    <div class="text-center card-product-options" style="padding: 10px 0;">
                        <button type="button" class="btn btn-link btn-sm btn-rounded text-success" ><i class="fas fa-shopping-bag fa-fw"></i> &nbsp; Agregar</button>
                        &nbsp; &nbsp;
                        <a href="<?php echo SERVERURL; ?>details/" class="btn btn-link btn-sm btn-rounded" ><i class="fas fa-box-open fa-fw"></i> &nbsp; Detalles</a>
                        &nbsp; &nbsp;
                        <button type="button" class="btn btn-link btn-sm btn-rounded text-muted" ><i class="fas fa-heart fa-fw"></i></button>
                    </div>
                </div>
            </div>

            <div class="card-product div-bordered bg-white shadow-2">
                <figure class="card-product-img">
                    <img class="img-fluid" src="<?php echo SERVERURL; ?>vistas/assets/product/product.jpg" alt="nombre_producto">
                </figure>
                <div class="card-product-body">
                    <div class="card-product-content scroll">
                        <h5 class="text-center fw-bolder">Nombre completo del producto con limite de caracteres</h5>
                        <p class="card-product-price text-center fw-bolder">$10.00 USD</p>
                        <span class="full-box text-center text-muted" style="display: block;">En stock</span>
                    </div>
                    <div class="text-center card-product-options" style="padding: 10px 0;">
                        <button type="button" class="btn btn-link btn-sm btn-rounded text-success" ><i class="fas fa-shopping-bag fa-fw"></i> &nbsp; Agregar</button>
                        &nbsp; &nbsp;
                        <a href="<?php echo SERVERURL; ?>details/" class="btn btn-link btn-sm btn-rounded" ><i class="fas fa-box-open fa-fw"></i> &nbsp; Detalles</a>
                        &nbsp; &nbsp;
                        <button type="button" class="btn btn-link btn-sm btn-rounded" ><i class="fas fa-heart fa-fw"></i></button>
                    </div>
                </div>
            </div>

            <div class="card-product div-bordered bg-white shadow-2">
                <figure class="card-product-img">
                    <img class="img-fluid" src="<?php echo SERVERURL; ?>vistas/assets/img/img_not_found.jpg" alt="nombre_producto">
                </figure>
                <div class="card-product-body">
                    <div class="card-product-content scroll">
                        <h5 class="text-center fw-bolder">Nombre completo del producto con limite de caracteres</h5>
                        <p class="card-product-price text-center fw-bolder">$10.00 USD</p>
                        <span class="full-box text-center text-muted" style="display: block;">En stock</span>
                    </div>
                    <div class="text-center card-product-options" style="padding: 10px 0;">
                        <button type="button" class="btn btn-link btn-sm btn-rounded text-success" ><i class="fas fa-shopping-bag fa-fw"></i> &nbsp; Agregar</button>
                        &nbsp; &nbsp;
                        <a href="<?php echo SERVERURL; ?>details/" class="btn btn-link btn-sm btn-rounded" ><i class="fas fa-box-open fa-fw"></i> &nbsp; Detalles</a>
                        &nbsp; &nbsp;
                        <button type="button" class="btn btn-link btn-sm btn-rounded text-muted" ><i class="fas fa-heart fa-fw"></i></button>
                    </div>
                </div>
            </div>

            <div class="card-product div-bordered bg-white shadow-2">
                <figure class="card-product-img">
                    <img class="img-fluid" src="<?php echo SERVERURL; ?>vistas/assets/product/product.jpg" alt="nombre_producto">
                </figure>
                <div class="card-product-body">
                    <div class="card-product-content scroll">
                        <h5 class="text-center fw-bolder">Nombre completo del producto con limite de caracteres</h5>
                        <p class="card-product-price text-center fw-bolder">$10.00 USD</p>
                        <span class="full-box text-center text-muted" style="display: block;">En stock</span>
                    </div>
                    <div class="text-center card-product-options" style="padding: 10px 0;">
                        <button type="button" class="btn btn-link btn-sm btn-rounded text-success" ><i class="fas fa-shopping-bag fa-fw"></i> &nbsp; Agregar</button>
                        &nbsp; &nbsp;
                        <a href="<?php echo SERVERURL; ?>details/" class="btn btn-link btn-sm btn-rounded" ><i class="fas fa-box-open fa-fw"></i> &nbsp; Detalles</a>
                        &nbsp; &nbsp;
                        <button type="button" class="btn btn-link btn-sm btn-rounded" ><i class="fas fa-heart fa-fw"></i></button>
                    </div>
                </div>
            </div>

            <div class="card-product div-bordered bg-white shadow-2">
                <figure class="card-product-img">
                    <img class="img-fluid" src="<?php echo SERVERURL; ?>vistas/assets/img/img_not_found.jpg" alt="nombre_producto">
                </figure>
                <div class="card-product-body">
                    <div class="card-product-content scroll">
                        <h5 class="text-center fw-bolder">Nombre completo del producto con limite de caracteres</h5>
                        <p class="card-product-price text-center fw-bolder">$10.00 USD</p>
                        <span class="full-box text-center text-muted" style="display: block;">En stock</span>
                    </div>
                    <div class="text-center card-product-options" style="padding: 10px 0;">
                        <button type="button" class="btn btn-link btn-sm btn-rounded text-success" ><i class="fas fa-shopping-bag fa-fw"></i> &nbsp; Agregar</button>
                        &nbsp; &nbsp;
                        <a href="<?php echo SERVERURL; ?>details/" class="btn btn-link btn-sm btn-rounded" ><i class="fas fa-box-open fa-fw"></i> &nbsp; Detalles</a>
                        &nbsp; &nbsp;
                        <button type="button" class="btn btn-link btn-sm btn-rounded text-muted" ><i class="fas fa-heart fa-fw"></i></button>
                    </div>
                </div>
            </div>

        </div>
    
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <a class="page-link" href="#">Anterior</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">3</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">Siguiente</a>
                </li>
            </ul>
        </nav>
    
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="saucerModal" tabindex="-1" aria-hidden="true" aria-labelledby="saucerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saucerModalLabel">Buscar producto</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-outline mb-4">
                    <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,25}" class="form-control" name="buscar_producto" id="buscar_producto" maxlength="25">
                    <label for="buscar_producto" class="form-label">¿Qué estás buscando?</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-mdb-dismiss="modal"><i class="fas fa-times fa-fw"></i> &nbsp; Cerrar</button>
                <button type="button" class="btn btn-info"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar</button>
            </div>
        </div>
    </div>
</div>