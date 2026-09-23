<?php
    include "./vistas/inc/client_security.php";
?>
<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-shopping-bag fa-fw"></i> &nbsp; DETALLES DE PEDIDO
    </h3>
</div>

<div class="container-fluid pb-5">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL; ?>home/" ><i class="fab fa-dashcube fa-fw"></i> &nbsp; Dashboard</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL; ?>orders/" ><i class="fas fa-shopping-basket fa-fw"></i> &nbsp; Pedidos</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL; ?>wish-list/" ><i class="fas fa-heart fa-fw"></i> &nbsp; Favoritos</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?php echo SERVERURL; ?>account/" ><i class="fas fa-user-circle fa-fw"></i> &nbsp; Mi cuenta</a>
        </li>
    </ul>
</div>

<div class="container">
    <?php 
        include "./vistas/inc/".LANG."/btn_go_back.php";
    ?>
</div>

<!-- Content -->
<div class="container-fluid">
    <?php     
        $datos_pedido=$ins_login->datos_tabla("Unico","venta","venta_id",$pagina[1]);
        if($datos_pedido->rowCount()==1){
            $campos=$datos_pedido->fetch();
    ?>
    <div class="alert alert-primary" role="alert">
        <h2 class="text-center"><i class="fas fa-shopping-basket fa-fw"></i> &nbsp;Detalles del pedido: <?php echo $campos['venta_codigo']; ?></h2>
    </div>
    <div class="container">
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
    <div class="container">
        <h4 class="text-center pt-5">Detalles de productos</h4>
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
    <?php
            include "./vistas/inc/".LANG."/print_invoice_script.php";
        }else{ 
            include "./vistas/inc/".LANG."/error_alert.php";
        }
    ?>
</div>