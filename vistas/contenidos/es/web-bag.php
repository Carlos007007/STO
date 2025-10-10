<section class="container-cart bg-white">
    <div class="container container-web-page">
        <h3 class="font-weight-bold poppins-regular text-uppercase">Carrito de compras</h3>
        <hr>
    </div>
    <div class="container">
        <?php include "./vistas/inc/".LANG."/btn_go_back.php"; ?>
    </div>
    <?php if(!empty($_SESSION['carrito_sto'])){ ?>
    <div class="container pt-3">
        <div class="row">
            <?php
                if(isset($_SESSION['alerta_producto_agregado_carrito']) && $_SESSION['alerta_producto_agregado_carrito']!=""){
                    echo '
                    <div class="bg-info text-white text-center mb-4" style="padding: 20px 0;">
                      '.$_SESSION['alerta_producto_agregado_carrito'].'
                    </div>
                    ';
                    unset($_SESSION['alerta_producto_agregado_carrito']);
                }
            ?>

            <div class="col-12 col-md-7 col-lg-8">
                <div class="container-fluid">
                    <?php
                        $venta_detalle_total=0;
                        foreach ($_SESSION['carrito_sto'] as $campos){
                    ?>

                    <a href="<?php echo SERVERURL."details/".$ins_login->encryption($campos['producto_id'])."/"; ?>" class="poppins-regular font-weight-bold full-box text-center d-inline-block fs-5 pb-1 pt-2"><?php echo $campos['venta_detalle_descripcion']; ?></a>

                    <div class="bag-item full-box">
                        <figure class="full-box">
                            <?php if(is_file("vistas/assets/product/cover/".$campos['producto_portada'])){?>
                            <img src="<?php echo SERVERURL."vistas/assets/product/cover/".$campos['producto_portada']; ?>" class="img-fluid">
                            <?php }else{?>
                            <img src="<?php echo SERVERURL; ?>vistas/assets/product/cover/default.jpg" class="img-fluid" alt="producto_nombre">
                            <?php }?>
                        </figure>
                        <div class="full-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-lg-6 text-center mb-4">
                                        <div class="row justify-content-center">
                                            <div class="col-auto">
                                                <div class="form-outline mb-4">
                                                    <input type="text" value="<?php echo $campos['venta_detalle_cantidad']; ?>" class="form-control text-center" id="sale_input_<?php echo str_replace(" ", "_", $campos['producto_id']); ?>" pattern="[0-9]{1,10}" maxlength="10" style="max-width: 100px; ">
                                                    <label for="product_cant" class="form-label">Cantidad</label>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button type="button" class="btn btn-success" data-mdb-toggle="tooltip" data-mdb-placement="bottom" title="Actualizar cantidad" onclick="actualizar_cantidad('#sale_input_<?php echo str_replace(" ", "_", $campos['producto_id']); ?>','<?php echo $campos['producto_codigo']; ?>')" ><i class="fas fa-sync-alt fa-fw"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 text-center mb-4">
                                        <span class="poppins-regular font-weight-bold" >SUBTOTAL: <?php echo COIN_SYMBOL.$campos['venta_detalle_total']." ".COIN_NAME; ?></span>
                                    </div>
                                    <div class="col-12 col-lg-2 text-center text-lg-end mb-4">
                                        <button type="button" class="btn btn-danger" data-mdb-toggle="tooltip" data-mdb-placement="bottom" title="Quitar del carrito" onclick="remover_producto('<?php echo $ins_login->encryption($campos['producto_id']); ?>')" >
                                            <span aria-hidden="true"><i class="far fa-trash-alt"></i></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <?php
                            $venta_detalle_total+=$campos['venta_detalle_total'];
                        } 
                    ?>
                    <p class="text-justify">
                        <small>
                            En caso de que no se posea el producto en almacén, los datos del mismo fueran incorrectos o existieran cambios o restricciones por parte de la tienda (precio, inventario, u otras condiciones para la venta) <strong><?php echo COMPANY; ?></strong> se reserva el derecho de cancelar el pedido.
                        </small>
                    </p>
                </div> 
            </div>
            <div class="col-12 col-md-5 col-lg-4">
                <div class="full-box div-bordered">
                    <?php if(isset($_SESSION['cliente_id_sto']) && ($_SESSION['cliente_id_sto']>0)){ ?>
                    <form>
                        <h5 class="text-center text-uppercase bg-success" style="color: #FFF; padding: 10px 0;">Resumen de la orden</h5>
                        <ul class="list-group bag-details">
                            <a class="list-group-item d-flex justify-content-between align-items-center text-uppercase poppins-regular font-weight-bold">
                                Subtotal
                                <span>
                                    <?php 
                                    echo COIN_SYMBOL.number_format($venta_detalle_total,COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND)." ".COIN_NAME; 
                                    ?>      
                                </span>
                            </a>
                            <a class="list-group-item d-flex justify-content-between align-items-center text-uppercase poppins-regular font-weight-bold">
                                Envio
                                <span>
                                    <?php 
                                    echo COIN_SYMBOL.number_format(0,COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND)." ".COIN_NAME; 
                                    ?>      
                                </span>
                            </a>
                            <a class="list-group-item d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #E1E1E1;"></a>
                            <a class="list-group-item d-flex justify-content-between align-items-center text-uppercase poppins-regular font-weight-bold">
                                Total
                                <span>
                                    <?php 
                                    echo COIN_SYMBOL.number_format($venta_detalle_total,COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND)." ".COIN_NAME; 
                                    ?>      
                                </span>
                            </a>
                        </ul>
                        <p class="text-center pb-3 pt-2">
                            <button type="button" class="btn btn-primary"><i class="fas fa-shopping-bag fa-fw"></i> &nbsp; Confirmar pedido</button>
                        </p>
                    </form>
                    <?php }else{ ?>
                    <h5 class="text-center text-uppercase poppins-regular font-weight-bold pt-3">Regístrate o inicia sesión</h5>
                    <p class="text-justify container">
                        Crea tu cuenta para poder realizar pedidos de productos hasta la puerta de tu casa, es muy fácil y rápido. Si ya tienes una cuenta inicia sesión para procesar el pedido.
                    </p>
                    <p class="text-center pb-3 pt-2">
                        <a href="<?php echo SERVERURL; ?>registration/" class="btn btn-primary" ><i class="fas fa-user-edit fa-fw"></i> &nbsp; Regístrate</a>
                        &nbsp; 
                        <a href="<?php echo SERVERURL; ?>signin/" class="btn btn-primary" ><i class="fas fa-user-lock fa-fw"></i> &nbsp; Login</a>
                    </p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php }else{ ?>
    <div class="container pt-5">
        <p class="text-center" ><i class="fas fa-shopping-bag fa-5x"></i></p>
        <h4 class="text-center poppins-regular font-weight-bold" >Carrito de compras vacío</h4>
    </div>
    <?php } ?>
</section>

<script type="text/javascript">
    
    /* Remover producto - Remove product */
    function remover_producto(id){

        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Desea remover este producto del carrito',
            icon: 'question',
            showCancelButton: true,
            showDenyButton: false,
            showConfirmButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result)=>{
            if(result.value){
                let datos = new FormData();
                datos.append("producto_id", id);
                datos.append("modulo_carrito", "remover");

                fetch('<?php echo SERVERURL; ?>ajax/carritoAjax.php',{
                    method: 'POST',
                    body: datos
                })
                .then(respuesta => respuesta.json())
                .then(respuesta =>{
                    return alertas_ajax(respuesta);
                });
            }
        });
    }


    /* Actualizar producto - Update product */
    function actualizar_cantidad(id,codigo){
        let cantidad=document.querySelector(id).value;

        cantidad=cantidad.trim();
        codigo.trim();

        if(cantidad>0){

            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Desea actualizar la cantidad de productos',
                icon: 'question',
                showCancelButton: true,
                showDenyButton: false,
                showConfirmButton: true,
                cancelButtonText: 'No, cancelar',
                confirmButtonText: 'Si, actualizar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result)=>{
                if(result.value){

                    let datos = new FormData();
                    datos.append("producto_codigo", codigo);
                    datos.append("producto_id", id);
                    datos.append("producto_cantidad", cantidad);
                    datos.append("modulo_carrito", "actualizar");

                    fetch('<?php echo SERVERURL; ?>ajax/carritoAjax.php',{
                        method: 'POST',
                        body: datos
                    })
                    .then(respuesta => respuesta.json())
                    .then(respuesta =>{
                        return alertas_ajax(respuesta);
                    });
                }
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Ocurrió un error inesperado',
                text: 'Debes de introducir una cantidad mayor a 0',
                confirmButtonText: 'Aceptar'
            });
        }
    }

</script>