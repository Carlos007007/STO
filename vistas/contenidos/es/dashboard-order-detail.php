<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-cart-plus fa-fw"></i> &nbsp; Detalles de pedido
    </h3>
</div>

<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL.DASHBOARD; ?>/order-new/" ><i class="fas fa-shopping-basket fa-fw"></i> &nbsp; Nuevo pedido</a>
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
    <?php include "./vistas/inc/".LANG."/btn_go_back.php"; ?>
    <div class="dashboard-container">
        <?php     
            $datos_pedido=$ins_login->datos_tabla("Unico","venta","venta_id",$pagina[2]);
            if($datos_pedido->rowCount()==1){
                $campos=$datos_pedido->fetch();
        ?>
        <div class="alert alert-primary" role="alert">
            <h2 class="text-center"><i class="fas fa-shopping-basket fa-fw"></i> &nbsp;Detalles del pedido: <?php echo $campos['venta_codigo']; ?></h2>
        </div>
        <div class="container pt-4 pb-4">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <p class="text-center text-uppercase font-weight-bold bg-dark" style="color: #FFF;">Datos del pedido</p>
                    <ul class="list-group list-group-light">
                        <li class="list-group-item border-0">Fecha & hora: <span class="fw-bold"><?php echo date("d-m-Y", strtotime($campos['venta_fecha']))." ".$campos['venta_hora']; ?></span></li>
                        <li class="list-group-item border-0">Tipo de envío: <span class="fw-bold"><?php echo $campos['venta_tipo_envio']; ?></span></li>
                        <li class="list-group-item border-0">Código: <span class="fw-bold"><?php echo $campos['venta_codigo']; ?></span></li>
                    </ul>
                </div>
                <div class="col-12 col-lg-4">
                    <p class="text-center text-uppercase font-weight-bold bg-dark" style="color: #FFF;">Estado & envío</p>
                    <ul class="list-group list-group-light">
                        <li class="list-group-item border-0">Estado de pedido: 
                            <?php 

                                if($campos['venta_estado_estado']=="Pedido confirmado"){
                                    echo '<span class="chip btn-outline-primary"><i class="far fa-check-circle fa-fw"></i> &nbsp;'.$campos['venta_estado_estado'].'</span>';
                                }elseif($campos['venta_estado_estado']=="Pedido sin confirmar"){
                                    echo '<span class="chip btn-outline-warning"><i class="far fa-clock fa-fw"></i> &nbsp;'.$campos['venta_estado_estado'].'</span>';
                                }elseif($campos['venta_estado_estado']=="Pedido cancelado"){
                                    echo '<span class="chip btn-outline-danger"><i class="far fa-times-circle fa-fw"></i> &nbsp;'.$campos['venta_estado_estado'].'</span>';
                                }
                            ?>
                        </li>
                        <li class="list-group-item border-0">Estado de pago:
                            <?php 
                                if($campos['venta_estado_pagado']=="Pagada"){
                                    echo '<span class="chip btn-outline-primary"><i class="fas fa-dollar-sign fa-fw"></i> &nbsp;'.$campos['venta_estado_pagado'].'</span>';
                                }elseif($campos['venta_estado_pagado']=="Pendiente de pago"){
                                    echo '<span class="chip btn-outline-danger"><i class="far fa-times-circle fa-fw"></i> &nbsp;'.$campos['venta_estado_pagado'].'</span>';
                                } 
                            ?>   
                        </li>
                        <li class="list-group-item border-0">Estado de envío: 
                            <?php 
                                if($campos['venta_estado_envio']=="Pedido enviado"){
                                    echo '<span class="chip btn-outline-primary"><i class="fas fa-shipping-fast fa-fw"></i> &nbsp;'.$campos['venta_estado_envio'].'</span>';
                                }elseif($campos['venta_estado_envio']=="Pendiente de envío"){
                                    echo '<span class="chip btn-outline-warning"><i class="fas fa-truck-loading fa-fw"></i> &nbsp;'.$campos['venta_estado_envio'].'</span>';
                                }elseif($campos['venta_estado_envio']=="Envío cancelado"){
                                    echo '<span class="chip btn-outline-danger"><i class="far fa-times-circle fa-fw"></i> &nbsp;'.$campos['venta_estado_envio'].'</span>';
                                }
                            ?>   
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-lg-4">
                    <p class="text-center text-uppercase font-weight-bold bg-dark" style="color: #FFF;">Totales</p>
                    <ul class="list-group list-group-light">
                        <li class="list-group-item border-0">Total: <span class="fw-bold"><?php echo COIN_SYMBOL.number_format($campos['venta_total'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME; ?></span></li>
                        <li class="list-group-item border-0">Pagado: <span class="fw-bold"><?php echo COIN_SYMBOL.number_format($campos['venta_pagado'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME; ?></span></li>
                        <li class="list-group-item border-0">Cambio: <span class="fw-bold"><?php echo COIN_SYMBOL.number_format($campos['venta_cambio'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME; ?></span></li>
                    </ul>
                </div>
            </div>
        </div>

        <hr class="mt-4 mb-4">

        <div class="container pt-4 pb-4">
            <h4 class="text-center pt-5"><i class="fas fa-cart-plus fa-fw"></i> &nbsp; Detalles de productos</h4>
            <div class="table-responsive pt-2">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr class="text-center font-weight-bold">
                            <th>Descripción</th>
                            <th>Cant.</th>
                            <th>Precio</th>
                            <th class="font-weight-bold">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <?php
                            $detalle_venta=$ins_login->datos_tabla("Normal","venta_detalle WHERE venta_codigo='".$campos['venta_codigo']."'","*",0);
                            if($detalle_venta->rowCount()>=1){
                                $detalle_venta=$detalle_venta->fetchAll();
                                foreach($detalle_venta as $detalle){
                                    echo '
                                    <tr class="text-center text-uppercase">
                                        <td>'.$detalle['venta_detalle_descripcion'].'</td>
                                        <td>'.$detalle['venta_detalle_cantidad'].'</td>
                                        <td>'.COIN_SYMBOL.number_format($detalle['venta_detalle_precio_venta'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME.'</td>
                                        <td class="font-weight-bold">'.COIN_SYMBOL.number_format($detalle['venta_detalle_total'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME.'</td>
                                    </tr>
                                    ';
                                }
                                echo '
                                <tr class="text-center text-uppercase font-weight-bold">
                                    <td colspan="2"></td>
                                    <td>Total</td>
                                    <td>'.COIN_SYMBOL.number_format($campos['venta_total'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME.'</td>
                                </tr>
                                ';
                            }else{
                                echo '<tr class="text-center text-uppercase"><td colspan="4">No hay datos para mostrar</td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <p class="text-center pt-5">
                <button href="#" <?php echo 'onclick="print_invoice(\''.SERVERURL.'pdf/invoice.php?code='.$campos['venta_codigo'].'\')"'; ?> class="btn btn-outline-primary btn-rounded btn-lg"><i class="fas fa-file-invoice-dollar fa-fw"></i> &nbsp; Imprimir factura</button>

                &nbsp; &nbsp;

                <button href="#" <?php echo 'onclick="print_ticket(\''.SERVERURL.'pdf/ticket_'.THERMAL_PRINT_SIZE.'mm.php?code='.$campos['venta_codigo'].'\')"'; ?> class="btn btn-outline-primary btn-rounded btn-lg"><i class="fas fa-receipt fa-fw"></i> &nbsp; Imprimir ticket</button>
            </p>
        </div>
        <?php if($campos['venta_estado_estado']!="Pedido cancelado" && $campos['venta_pagado']<$campos['venta_total']){ ?>
        <hr class="mt-4 mb-4">
        <div class="container pt-4 pb-4">
            <h4 class="text-center pt-5"><i class="fas fa-money-check-alt"></i> &nbsp; Agregar pago a pedido</h4>
            <form class="dashboard-container FormularioAjax" method="POST" data-form="update" data-lang="<?php echo LANG; ?>" autocomplete="off" action="<?php echo SERVERURL;?>ajax/pedidoAjax.php" >
                <input type="hidden" name="modulo_pedido" value="agregar_pago">
                <input type="hidden" name="pedido_id_up" value="<?php echo $pagina[2]; ?>">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-outline mb-4">
                                <input type="text" class="form-control" name="pago_pendiente" id="pago_pendiente" value="<?php echo number_format(($campos['venta_total']-$campos['venta_pagado']),COIN_DECIMALS,".",""); ?>" readonly>
                                <label for="pago_pendiente" class="form-label">Pendiente de pago</label>
                            </div> 
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-outline mb-4">
                                <input type="text" class="form-control" id="pago_monto" name="pago_monto" pattern="[0-9.]{1,25}" maxlength="25" >
                                <label for="pago_monto" class="form-label">Monto <?php echo FIELD_OBLIGATORY; ?></label>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-outline mb-4">
                                <input type="text" class="form-control" value="0.00" id="pago_cambio" readonly="" >
                                <label for="pago_cambio" class="form-label">Cambio</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-outline mb-4">
                                <select class="form-control" id="sale-cash-register" name="pago_caja" >
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
                        </div>

                    </div>
                </div>

                <p class="text-center" style="margin-top: 40px;">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-money-check-alt"></i> &nbsp; AGREGAR PAGO</button>
                </p>
                <p class="text-center">
                    <small>Los campos marcados con <?php echo FIELD_OBLIGATORY; ?> son obligatorios</small>
                </p>
            </form>
        </div>
        <?php 
        } 
        if($campos['venta_estado_estado']!="Pedido cancelado"){ 
        ?>
        <hr class="mt-4 mb-4">
        <div class="container pt-4 pb-4">
            <h4 class="text-center pt-5"><i class="fas fa-sync-alt"></i> &nbsp; Actualizar información del pedido</h4>
            <form class="dashboard-container FormularioAjax" method="POST" data-form="update" data-lang="<?php echo LANG; ?>" autocomplete="off" action="<?php echo SERVERURL;?>ajax/pedidoAjax.php" >
                <input type="hidden" name="modulo_pedido" value="actualizar_pedido">
                <input type="hidden" name="pedido_id_up" value="<?php echo $pagina[2]; ?>">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label class="text-black-50" for="sale-status">Estado de pedido <i class="fas fa-sort-down"></i></label>
                            <div class="form-outline mb-4">
                                <select class="form-control" id="sale-status" name="venta_estado_estado" >
                                    <option value="Pedido confirmado" <?php if($campos['venta_estado_estado']=="Pedido confirmado"){ echo 'selected=""'; } ?> >Pedido confirmado <?php if($campos['venta_estado_estado']=="Pedido confirmado"){ echo '(Actual)'; } ?></option>
                                    <option value="Pedido sin confirmar" <?php if($campos['venta_estado_estado']=="Pedido sin confirmar"){ echo 'selected=""'; } ?> >Pedido sin confirmar <?php if($campos['venta_estado_estado']=="Pedido sin confirmar"){ echo '(Actual)'; } ?></option>
                                </select>
                                <label class="form-label"></label>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="text-black-50" for="sale-shipment">Estado de envío <i class="fas fa-sort-down"></i></label>
                            <div class="form-outline mb-4">
                                <select class="form-control" id="sale-shipment" name="venta_estado_envio" >
                                    <option value="Pedido enviado" <?php if($campos['venta_estado_envio']=="Pedido enviado"){ echo 'selected=""'; } ?> >Pedido enviado <?php if($campos['venta_estado_envio']=="Pedido enviado"){ echo '(Actual)'; } ?></option>
                                    <option value="Pendiente de envío" <?php if($campos['venta_estado_envio']=="Pendiente de envío"){ echo 'selected=""'; } ?> >Pendiente de envío <?php if($campos['venta_estado_envio']=="Pendiente de envío"){ echo '(Actual)'; } ?></option>
                                </select>
                                <label class="form-label"></label>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="text-center" style="margin-top: 40px;">
                    <button type="submit" class="btn btn-success"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
                </p>
                <p class="text-center">
                    <small>Los campos marcados con <?php echo FIELD_OBLIGATORY; ?> son obligatorios</small>
                </p>
            </form>
        </div>
        <?php } ?>
        <hr class="mt-4 mb-4">
        <div class="container pt-4 pb-4">
            <?php if($campos['venta_estado_estado']=="Pedido cancelado"){ ?>
            <div class="bg-warning text-white text-center mb-4 pt-4 pb-4">
                <p><i class="fas fa-cart-arrow-down fa-5x"></i></p>
                <h4>¡Pedido anulado o cancelado!</h4>
                <p class="mb-0">Este pedido se encuentra anulado.</p>        
            </div>
            <?php }else{ ?>
            <form class="bg-danger text-white text-center mb-4 pt-4 pb-4 FormularioAjax" method="POST" data-form="update" data-lang="<?php echo LANG; ?>" autocomplete="off" action="<?php echo SERVERURL;?>ajax/pedidoAjax.php" >

                <input type="hidden" name="modulo_pedido" value="cancelar_pedido">
                <input type="hidden" name="pedido_id" value="<?php echo $pagina[2]; ?>">

                <p><i class="fas fa-cart-arrow-down fa-5x"></i></p>
                <h4>¡Anular o cancelar pedido!</h4>
                <p class="mb-0">Al anular o cancelar el pedido los productos de este regresaran a stock nuevamente y se descontara el total pagado de la caja de ventas. Para continuar haga clic en el botón "<i class="fas fa-cart-arrow-down fa-fw"></i> &nbsp; Anular pedido"</p>

                <p class="text-center" style="margin-top: 40px;">
                    <button type="submit" class="btn btn-danger" style="border: 1px solid rgba(255, 255, 255, 0.3);" ><i class="fas fa-cart-arrow-down fa-fw"></i> &nbsp; Anular pedido</button>
                </p>

            </form>
            <?php } ?>
        </div>
        <?php
            include "./vistas/inc/".LANG."/print_invoice_script.php";
        }else{ 
            include "./vistas/inc/".LANG."/error_alert.php";
        }
    ?>
    </div>
</div>

<script>
    /*----------  Calcular cambio  ----------*/
    let pago_monto_input = document.querySelector("#pago_monto");

    pago_monto_input.addEventListener('keyup', function(event){
        event.preventDefault();

        let abono=document.querySelector('#pago_monto').value;
        abono=abono.trim();
        abono=parseFloat(abono);

        let total=document.querySelector('#pago_pendiente').value;
        total=total.trim();
        total=parseFloat(total);

        if(abono>=total){
            cambio=abono-total;
            cambio=parseFloat(cambio).toFixed(<?php echo COIN_DECIMALS; ?>);
            document.querySelector('#pago_cambio').value=cambio;
        }else{
            document.querySelector('#pago_cambio').value="0.00";
        }
    });
</script>