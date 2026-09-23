<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-shopping-basket fa-fw"></i> &nbsp; Nuevo pedido
    </h3>
</div>

<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="<?php echo SERVERURL.DASHBOARD; ?>/order-new/" ><i class="fas fa-shopping-basket fa-fw"></i> &nbsp; Nuevo pedido</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/order-list/" ><i class="fas fa-file-invoice-dollar fa-fw"></i> &nbsp; Pedidos realizados</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/order-pending/" ><i class="fas fa-truck-loading fa-fw"></i> &nbsp; Pedidos pendientes</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/order-canceled/" ><i class="far fa-calendar-times fa-fw"></i> &nbsp; Pedidos cancelados</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/order-search/" ><i class="fas fa-search-dollar fa-fw"></i> &nbsp; Buscar pedido</a>
        </li>
    </ul>
</div>

<div class="container-fluid">
    <?php
        $check_empresa=$ins_login->datos_tabla("Normal","empresa LIMIT 1","*",0);

        if($check_empresa->rowCount()==1){
            $datos_empresa=$check_empresa->fetch();
    ?>
    <div class="dashboard-container pb-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-9">

                    <div class="alert alert-light text-center" role="alert" style="font-size: 12px;">
                        <p>
                            Para agregar productos debe de digitar el código de barras en el campo "Código de producto" y luego presionar &nbsp; <strong class="text-uppercase" ><i class="far fa-check-circle"></i> &nbsp; Agregar producto</strong> o presionar la tecla <strong class="text-uppercase">enter</strong>. También puede agregar el producto mediante la opción &nbsp; <strong class="text-uppercase"><i class="fas fa-search"></i> &nbsp; Buscar producto</strong>. Si está utilizando lector de <strong class="text-uppercase">códigos de barras</strong>, debe de conectar un lector de código de barras a su computadora, luego seleccionar el campo "Código de producto" y escanear el código con el lector.
                        </p>
                    </div>

                    <?php 
                        if(isset($_SESSION['alerta_producto_agregado']) && $_SESSION['alerta_producto_agregado']!=""){
                            echo '
                            <div class="alert alert-success alert-dismissible fade show" role="alert" data-mdb-alert-init="" data-mdb-alert-initialized="true" >
                                '.$_SESSION['alerta_producto_agregado'].'
                                <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close" >
                                </button>
                            </div>
                            ';
                            unset($_SESSION['alerta_producto_agregado']);
                        }

                        if(isset($_SESSION['venta_codigo_factura']) && $_SESSION['venta_codigo_factura']!=""){
                    ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading text-center">Pedido realizado</h4>
                        <p class="text-center">El pedido se realizó con éxito. ¿Que desea hacer a continuación? </p>
                        <br>
                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-md-6 text-center">
                                    <button type="button" class="btn btn-primary" onclick="print_ticket('<?php echo SERVERURL."pdf/ticket_".THERMAL_PRINT_SIZE."mm.php?code=".$_SESSION['venta_codigo_factura']; ?>')" >
                                        <i class="fas fa-receipt fa-4x"></i><br>
                                        Imprimir ticket de pedido
                                    </buttona>
                                </div>
                                <div class="col-12 col-md-6 text-center">
                                    <button type="button" class="btn btn-primary" onclick="print_invoice('<?php echo SERVERURL."pdf/invoice.php?code=".$_SESSION['venta_codigo_factura']; ?>')" >
                                        <i class="fas fa-file-invoice-dollar fa-4x"></i><br>
                                        Imprimir factura de pedido
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close" ></button>
                    </div>
                    <?php
                            unset($_SESSION['venta_codigo_factura']);
                        }
                    ?>
                    <div class="container-fluid pb-4">
                        <form class="row align-items-center" id="sale-barcode-form" autocomplete="off">
                            <div class="col-12 col-md-3">
                                <button type="button" class="btn btn-link" id="btn_modal_buscar_codigo" data-mdb-ripple-init data-mdb-ripple-color="primary" data-mdb-toggle="modal" data-mdb-target="#searchCodeModal" ><i class="fas fa-search"></i> &nbsp; Buscar producto</button>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-outline">
                                    <input type="text" pattern="[a-zA-Z0-9- ]{1,70}" class="form-control sale-input-barcode" id="sale-barcode-input" maxlength="70" autofocus="autofocus" >
                                    <label for="barcode-input" class="form-label">Código de producto</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="button" class="btn btn-link" onclick="agregar_producto()" data-mdb-ripple-init data-mdb-ripple-color="primary" ><i class="far fa-check-circle"></i> &nbsp; Agregar producto</button>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-dark">
                                <tr class="text-center font-weight-bold">
                                    <th>#</th>
                                    <th>Código de barra</th>
                                    <th>Producto</th>
                                    <th>Cant.</th>
                                    <th>Precio</th>
                                    <th>Subtotal</th>
                                    <th><i class="fas fa-sync fa-fw"></i> Cantidad</th>
                                    <th>Remover</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <?php

                                $_SESSION['venta_impuesto_nombre']=$datos_empresa['empresa_impuesto_nombre'];
                                $_SESSION['venta_impuesto_porcentaje']=$datos_empresa['empresa_impuesto_porcentaje'];

                                if(isset($_SESSION['carrito_sto']) && count($_SESSION['carrito_sto'])>=1){
                                    $_SESSION['venta_total']=0;
                                    $_SESSION['venta_impuestos']=0;
                                    $_SESSION['venta_subtotal']=0;
                                    $_SESSION['venta_costos']=0;
                                    $cc=1;
                                    foreach($_SESSION['carrito_sto'] as $productos){ 
                                ?>
                                <tr class="text-center">
                                    <th scope="row"><?php echo $cc; ?></th>

                                    <td><?php echo $productos['producto_codigo']; ?></td>

                                    <td><?php echo $productos['venta_detalle_descripcion']; ?></td>

                                    <td>
                                        <input type="text" class="form-control text-center" value="<?php echo $productos['venta_detalle_cantidad']; ?>" id="sale_input_<?php echo str_replace(" ", "_", $productos['producto_id']); ?>" pattern="[0-9]{1,10}" maxlength="10" >
                                    </td>

                                    <td><?php echo COIN_SYMBOL.number_format($productos['venta_detalle_precio_venta'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND)." ".COIN_NAME; ?></td>

                                    <td><?php echo COIN_SYMBOL.number_format($productos['venta_detalle_total'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND)." ".COIN_NAME; ?></td>

                                    <td>
                                        <button type="button" class="btn btn-success" data-mdb-toggle="tooltip" data-mdb-placement="bottom" title="Actualizar cantidad" onclick="actualizar_cantidad('#sale_input_<?php echo str_replace(" ", "_", $productos['producto_id']); ?>','<?php echo $productos['producto_codigo']; ?>','dashboard')">
                                            <i class="fas fa-redo-alt"></i>
                                        </button>
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-danger" data-mdb-toggle="tooltip" data-mdb-placement="bottom" title="Quitar del carrito" onclick="remover_producto('<?php echo $ins_login->encryption($productos['producto_id']); ?>')" >
                                            <span aria-hidden="true"><i class="far fa-trash-alt"></i></span>
                                        </button>
                                    </td>
                                </tr>
                                <?php
                                        $cc++;
                                        $_SESSION['venta_total']+=$productos['venta_detalle_total'];
                                        $_SESSION['venta_impuestos']+=$productos['venta_detalle_impuestos'];
                                        $_SESSION['venta_subtotal']+=$productos['venta_detalle_subtotal'];
                                        $_SESSION['venta_costos']+=$productos['venta_detalle_costo'];
                                    }
                                ?>
                                <tr class="text-center font-weight-bold">
                                    <td colspan="4"></td>
                                    <td>TOTAL</td>
                                    <td><?php echo COIN_SYMBOL.number_format($_SESSION['venta_total'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND)." ".COIN_NAME; ?></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php
                                }else{
                                    $_SESSION['venta_total']=0;
                                    $_SESSION['venta_impuestos']=0;
                                    $_SESSION['venta_subtotal']=0;
                                    $_SESSION['venta_costos']=0;  
                                ?>
                                <tr class="text-center">
                                    <th colspan="8">No hay productos agregados</th>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="col-12 col-lg-3">

                    <h3 class="text-center text-uppercase">Datos del pedido</h3>
                    <hr>

                    <?php if($_SESSION['venta_total']>0){ ?>
                    <form class="container-fluid FormularioAjax" method="POST" data-form="save" data-lang="<?php echo LANG; ?>" autocomplete="off" action="<?php echo SERVERURL;?>ajax/pedidoAjax.php" name="formsale" >
                        <input type="hidden" name="modulo_pedido" value="guardar_pedido_administrador">
                    <?php }else { ?> 
                    <form name="formsale">
                    <?php } ?>

                        <div class="form-outline mb-4">
                            <input type="date" class="form-control" id="sale-date" value="<?php echo date("Y-m-d"); ?>" readonly >
                            <label for="sale-date" class="form-label">Fecha</label>
                        </div>

                        <div class="form-outline mb-4">
                            <select class="form-control" id="sale-cash-register" name="venta_caja" >
                                <?php
                                    $datos_caja=$ins_login->datos_tabla("Normal","caja","*",0);
                                    while($campos_caja=$datos_caja->fetch()){
                                        if($campos_caja['caja_id']==1){
                                            echo '<option value="'.$campos_caja['caja_id'].'" selected="" >Caja No.'.$campos_caja['caja_numero'].' - '.$campos_caja['caja_nombre'].'</option>';
                                        }else{
                                            if($campos_caja['caja_estado']=="Habilitada"){
                                                echo '<option value="'.$campos_caja['caja_id'].'">Caja No.'.$campos_caja['caja_numero'].' - '.$campos_caja['caja_nombre'].'</option>';
                                            }
                                        }
                                    }
                                ?>
                            </select>
                            <label for="sale-cash-register" class="form-label">Caja</label>
                        </div>

                        <label class="text-black-50" for="sale-shipment">Tipo de envío <i class="fas fa-sort-down"></i></label>
                        <div class="form-outline mb-4">
                            <select class="form-control" id="sale-shipment" name="venta_tipo_envio" >
                                <option value="Contra Entrega" selected="" >Contra Entrega</option>
                            </select>
                            <label class="form-label"></label>
                        </div>

                        <div class="container-fluid mb-4">
                            <?php
                                if(isset($_SESSION['datos_cliente_venta']) && count($_SESSION['datos_cliente_venta'])>=1 && $_SESSION['datos_cliente_venta']['cliente_id']!=1){
                            ?>
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-outline">
                                        <input type="text" class="form-control btn_modal_cliente" value="<?php echo $_SESSION['datos_cliente_venta']['cliente_nombre']." ".$_SESSION['datos_cliente_venta']['cliente_apellido']; ?>" id="venta_cliente"  readonly />
                                        <label for="venta_cliente" class="form-label">Cliente</label>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-danger btn_modal_cliente" type="button" id="button-client" data-mdb-ripple-init data-mdb-ripple-color="primary" onclick="remover_cliente('<?php echo $_SESSION['datos_cliente_venta']['cliente_id']; ?>')" >
                                        <i class="fas fa-user-times"></i>
                                    </button>      
                                </div>
                            </div>
                            <?php
                                }else{
                                    $datos_cliente=$ins_login->datos_tabla("Normal","cliente WHERE cliente_id='1'","*",0);
                                    if($datos_cliente->rowCount()==1){
                                        $datos_cliente=$datos_cliente->fetch();

                                        $_SESSION['datos_cliente_venta']=[
                                            "cliente_id"=>$datos_cliente['cliente_id'],
                                            "cliente_nombre"=>$datos_cliente['cliente_nombre'],
                                            "cliente_apellido"=>$datos_cliente['cliente_apellido'],
                                            "cliente_telefono"=>$datos_cliente['cliente_telefono']
                                        ];

                                    }else{
                                        $_SESSION['datos_cliente_venta']=[
                                            "cliente_id"=>1,
                                            "cliente_nombre"=>"Publico",
                                            "cliente_apellido"=>"General",
                                            "cliente_telefono"=>"00000000"
                                        ];
                                    }                    
                            ?>
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-outline">
                                        <input type="text" class="form-control btn_modal_cliente" value="<?php echo $_SESSION['datos_cliente_venta']['cliente_nombre']." ".$_SESSION['datos_cliente_venta']['cliente_apellido']; ?>" id="venta_cliente"  readonly />
                                        <label for="venta_cliente" class="form-label">Cliente</label>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-primary btn_modal_cliente" type="button" id="button-client" data-mdb-ripple-init data-mdb-ripple-color="primary" data-mdb-toggle="modal" data-mdb-target="#searchClientModal" >
                                        <i class="fas fa-user-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" name="venta_abono" id="venta_abono" value="0.00" pattern="[0-9.]{1,25}" maxlength="25" >
                            <label for="venta_abono" class="form-label"><i class="fas fa-dollar-sign"></i> Total pagado por cliente <?php echo FIELD_OBLIGATORY; ?></label>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="text" class="form-control" name="venta_cambio" id="venta_cambio" value="0.00" pattern="[0-9.]{1,25}" maxlength="25" readonly >
                            <label for="venta_cambio" class="form-label"><i class="fas fa-dollar-sign"></i> Cambio devuelto a cliente</label>
                        </div>

                        <?php
                            $_SESSION['venta_subtotal']=number_format($_SESSION['venta_subtotal'],COIN_DECIMALS,'.','');

                            $_SESSION['venta_impuestos']=number_format($_SESSION['venta_impuestos'],COIN_DECIMALS,'.','');

                            $_SESSION['venta_total']=number_format($_SESSION['venta_total'],COIN_DECIMALS,'.','');
                        ?>

                        <ul class="list-group list-unstyled">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Subtotal
                                <span class="text-dark"> + <?php echo COIN_SYMBOL.number_format($_SESSION['venta_subtotal'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND)." ".COIN_NAME; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo $_SESSION['venta_impuesto_nombre']." (".$_SESSION['venta_impuesto_porcentaje']."%)"; ?>
                                <span class="text-dark"> + <?php echo COIN_SYMBOL.number_format($_SESSION['venta_impuestos'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND)." ".COIN_NAME; ?></span>
                            </li>
                            <li><hr></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                Total
                                <span class="text-dark" > <?php echo COIN_SYMBOL.number_format($_SESSION['venta_total'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND)." ".COIN_NAME; ?></span>
                            </li>
                        </ul>

                        <?php if($_SESSION['venta_total']>0){ ?>
                        <p class="text-center" style="margin-top: 40px;">
                            <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> &nbsp; GUARDAR PEDIDO</button>
                        </p>
                        <?php } ?>

                        <p class="text-center">
                            <small>Los campos marcados con <?php echo FIELD_OBLIGATORY; ?> son obligatorios</small>
                        </p>

                        <input type="hidden" value="<?php echo number_format($_SESSION['venta_total'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,""); ?>" id="venta_total_descuento">

                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
        }else{
            echo '
                <div class="alert alert-danger text-center" role="alert">
                    <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
                    <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
                    <p class="mb-0">No hemos podio seleccionar algunos datos sobre los impuestos, por favor <a href="'.SERVERURL.DASHBOARD.'/company/" >verifique aquí los datos de la empresa</a></p>
                </div>
            ';
        }
    ?>
</div>

<!-- Modal buscar producto -->
<div class="modal fade" id="searchCodeModal" tabindex="-1" aria-hidden="true" aria-labelledby="searchModalLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="false" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">Buscar producto</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="form-outline mb-4">
                    <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" name="input_codigo" id="input_codigo" maxlength="30">
                    <label for="txt_buscador" class="form-label">Nombre, marca, modelo</label>
                </div>

                <br>

                <div class="container-fluid" id="tabla_productos"></div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-mdb-dismiss="modal"><i class="fas fa-times fa-fw"></i> &nbsp; Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="buscar_codigo()" ><i class="fas fa-search fa-fw"></i> &nbsp; Buscar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal buscar cliente -->
<div class="modal fade" id="searchClientModal" tabindex="-1" aria-hidden="true" aria-labelledby="searchModalLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="false" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">Buscar cliente</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="form-outline mb-4">
                    <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" name="input_cliente" id="input_cliente" maxlength="30">
                    <label for="txt_buscador" class="form-label">Nombre, Apellido, Teléfono</label>
                </div>

                <br>

                <div class="container-fluid" id="tabla_clientes"></div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-mdb-dismiss="modal"><i class="fas fa-times fa-fw"></i> &nbsp; Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="buscar_cliente()" ><i class="fas fa-search fa-fw"></i> &nbsp; Buscar</button>
            </div>
        </div>
    </div>
</div>

<script>

    let sale_form_barcode = document.querySelector("#sale-barcode-form");
    sale_form_barcode.addEventListener('submit', function(event){
        event.preventDefault();
        setTimeout('agregar_producto()',100);
    });

    
    /* Configuracion automatica con lector de codigo de barras */
    let sale_input_barcode = document.querySelector("#sale-barcode-input");

    sale_input_barcode.addEventListener('paste',function(){
        setTimeout('agregar_producto()',100);
    });


    /* Agregar producto */
    function agregar_producto(){
        let codigo_producto=document.querySelector('#sale-barcode-input').value;

        codigo_producto=codigo_producto.trim();

        if(codigo_producto!=""){

            let datos = new FormData();
            datos.append("producto_codigo_add", codigo_producto);
            datos.append("modulo_pedido", "agregar_producto");

            fetch('<?php echo SERVERURL; ?>ajax/pedidoAjax.php',{
                method: 'POST',
                body: datos
            })
            .then(respuesta => respuesta.json())
            .then(respuesta =>{
                return alertas_ajax(respuesta);
            });

        }else{
            Swal.fire({
              title: 'Ocurrió un error inesperado',
              text: 'Debes de introducir el código del producto',
              icon: 'error',
              confirmButtonText: 'Aceptar'
            });
        }
        
    }


    /*----------  Buscar codigo  ----------*/
    function buscar_codigo(){
        let input_codigo=document.querySelector('#input_codigo').value;

        input_codigo=input_codigo.trim();

        if(input_codigo!=""){

            let datos = new FormData();
            datos.append("buscar_codigo", input_codigo);
            datos.append("modulo_pedido", "buscar_codigo");

            fetch('<?php echo SERVERURL; ?>ajax/pedidoAjax.php',{
                method: 'POST',
                body: datos
            })
            .then(respuesta => respuesta.text())
            .then(respuesta =>{
                let tabla_productos=document.querySelector('#tabla_productos');
                tabla_productos.innerHTML=respuesta;
            });

        }else{
            Swal.fire({
                title: 'Ocurrió un error inesperado',
                text: 'Debes de introducir el Nombre, Marca o Modelo del producto',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    }


    /*----------  Agregar codigo  ----------*/
    function agregar_codigo($codigo){
        document.querySelector('#sale-barcode-input').value=$codigo;
        setTimeout('agregar_producto()',100);
    }


    /*----------  Calcular cambio  ----------*/
    let venta_abono_input = document.querySelector("#venta_abono");

    venta_abono_input.addEventListener('keyup', function(event){
        event.preventDefault();

        let abono=document.querySelector('#venta_abono').value;
        abono=abono.trim();
        abono=parseFloat(abono);

        let total=document.querySelector('#venta_total_descuento').value;
        total=total.trim();
        total=parseFloat(total);

        if(abono>=total){
            cambio=abono-total;
            cambio=parseFloat(cambio).toFixed(<?php echo COIN_DECIMALS; ?>);
            document.querySelector('#venta_cambio').value=cambio;
        }else{
            document.querySelector('#venta_cambio').value="0.00";
        }
    });


    /*----------  Buscar cliente  ----------*/
    function buscar_cliente(){
        let input_cliente=document.querySelector('#input_cliente').value;

        input_cliente=input_cliente.trim();

        if(input_cliente!=""){

            let datos = new FormData();
            datos.append("buscar_cliente", input_cliente);
            datos.append("modulo_pedido", "buscar_cliente");

            fetch('<?php echo SERVERURL; ?>ajax/pedidoAjax.php',{
                method: 'POST',
                body: datos
            })
            .then(respuesta => respuesta.text())
            .then(respuesta =>{
                let tabla_clientes=document.querySelector('#tabla_clientes');
                tabla_clientes.innerHTML=respuesta;
            });

        }else{
            Swal.fire({
                title: 'Ocurrió un error inesperado',
                text: 'Debes de introducir el Nombre, Apellido o Teléfono del cliente',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    }


    /*----------  Agregar cliente  ----------*/
    function agregar_cliente(id){
        Swal.fire({
            title: '¿Quieres agregar este cliente?',
            text: "Se van a agregar los datos de este cliente para realizar un pedido",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, agregar',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if(result.value){

                let datos = new FormData();
                datos.append("cliente_id_add", id);
                datos.append("modulo_pedido", "agregar_cliente");

                fetch('<?php echo SERVERURL; ?>ajax/pedidoAjax.php',{
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


    /*----------  Remover cliente  ----------*/
    function remover_cliente(id){
        Swal.fire({
            title: '¿Quieres remover este cliente?',
            text: "Se van a remover los datos del cliente de este pedido",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, remover',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if(result.value){

                let datos = new FormData();
                datos.append("cliente_id_del", id);
                datos.append("modulo_pedido", "remover_cliente");

                fetch('<?php echo SERVERURL; ?>ajax/pedidoAjax.php',{
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

</script>

<?php 
    include "./vistas/inc/".LANG."/update_remove_product_script.php"; 
    include "./vistas/inc/".LANG."/print_invoice_script.php";
?>