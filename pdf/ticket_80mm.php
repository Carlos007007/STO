<?php
	
	$peticion_ajax=true;
	$code=(isset($_GET['code'])) ? $_GET['code'] : 0;

	/*---------- Incluyendo configuraciones ----------*/
    require_once "../config/APP.php";

	/*---------- Instancia al controlador pedido ----------*/
    require_once "../controladores/pedidoControlador.php";
    $ins_pedido = new pedidoControlador();

    $code=$ins_pedido->limpiar_cadena($code);

	$datos_venta=$ins_pedido->datos_tabla("Normal","venta INNER JOIN cliente ON venta.cliente_id=cliente.cliente_id INNER JOIN usuario ON venta.usuario_id=usuario.usuario_id INNER JOIN caja ON venta.caja_id=caja.caja_id WHERE (venta_codigo='$code')","*",0);

	if($datos_venta->rowCount()==1){
        
		/*---------- Datos de la venta ----------*/
		$datos_venta=$datos_venta->fetch();

		/*---------- Seleccion de datos de la empresa ----------*/
		$datos_empresa=$ins_pedido->datos_tabla("Normal","empresa LIMIT 1","*",0);
		$datos_empresa=$datos_empresa->fetch();

        /*----------  Seleccionando detalles de la venta  ----------*/
        $venta_detalle=$ins_pedido->datos_tabla("Normal","venta_detalle WHERE venta_codigo='".$datos_venta['venta_codigo']."'","*",0);

        /*----------  Calculando alto del ticket  ----------*/
        $altura_papel=$venta_detalle->rowCount();
        $altura_papel=230+($altura_papel*17);


		require "./code128.php";

		$pdf = new PDF_Code128('P','mm',array(80,$altura_papel));
		$pdf->SetMargins(4,10,4);
        $pdf->AddPage();
        
        $pdf->SetFont('Arial','B',10);
        $pdf->SetTextColor(0,0,0);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",strtoupper($datos_empresa['empresa_nombre'])),0,'C',false);
        $pdf->SetFont('Arial','',9);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",$datos_empresa['empresa_tipo_documento'].": ".$datos_empresa['empresa_numero_documento']),0,'C',false);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",$datos_empresa['empresa_direccion']),0,'C',false);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: ".$datos_empresa['empresa_telefono']),0,'C',false);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Email: ".$datos_empresa['empresa_email']),0,'C',false);

        $pdf->Ln(1);
        $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------"),0,0,'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial','B',10);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",strtoupper("Ticket de venta")),0,'C',false);
        $pdf->SetFont('Arial','',9);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Fecha: ".date("d/m/Y", strtotime($datos_venta['venta_fecha']))." ".$datos_venta['venta_hora']),0,'C',false);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Caja Nro: ".$datos_venta['caja_numero']),0,'C',false);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Cajero: ".$datos_venta['usuario_nombre']." ".$datos_venta['usuario_apellido']),0,'C',false);
        $pdf->SetFont('Arial','B',10);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",strtoupper("Ticket Nro: ".$datos_venta['venta_id'])),0,'C',false);
        $pdf->SetFont('Arial','',9);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Tipo de venta: Contado"),0,'C',false);

        $pdf->Ln(1);
        $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------"),0,0,'C');
        $pdf->Ln(5);
    
        if($datos_venta['cliente_id']==1){
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Cliente: N/A"),0,'C',false);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: N/A"),0,'C',false);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Dirección: N/A"),0,'C',false);
        }else{
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Cliente: ".$datos_venta['cliente_nombre']." ".$datos_venta['cliente_apellido']),0,'C',false);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: ".$datos_venta['cliente_telefono']),0,'C',false);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Dirección: ".$datos_venta['cliente_provincia'].", ".$datos_venta['cliente_ciudad'].", ".$datos_venta['cliente_direccion']),0,'C',false);
        }

        $pdf->Ln(1);
        $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
        $pdf->Ln(3);

        $pdf->Cell(10,5,iconv("UTF-8", "ISO-8859-1","Cant."),0,0,'C');
        $pdf->Cell(19,5,iconv("UTF-8", "ISO-8859-1","Precio"),0,0,'C');
        $pdf->Cell(15,5,iconv("UTF-8", "ISO-8859-1","Desc."),0,0,'C');
        $pdf->Cell(28,5,iconv("UTF-8", "ISO-8859-1","Total"),0,0,'C');

        $pdf->Ln(3);
        $pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
        $pdf->Ln(3);

        /*----------  Detalles de la venta  ----------*/
        $venta_detalle=$venta_detalle->fetchAll();
        
        foreach($venta_detalle as $detalle){
            $pdf->MultiCell(0,4,iconv("UTF-8", "ISO-8859-1",$detalle['venta_detalle_descripcion']),0,'C',false);
            $pdf->Cell(10,4,iconv("UTF-8", "ISO-8859-1",$detalle['venta_detalle_cantidad']),0,0,'C');
            $pdf->Cell(19,4,iconv("UTF-8", "ISO-8859-1",COIN_SYMBOL.number_format($detalle['venta_detalle_precio_venta'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND)),0,0,'C');
            $pdf->Cell(19,4,iconv("UTF-8", "ISO-8859-1",COIN_SYMBOL.number_format(0.00,COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND)),0,0,'C');
            $pdf->Cell(28,4,iconv("UTF-8", "ISO-8859-1",COIN_SYMBOL.number_format($detalle['venta_detalle_total'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND)),0,0,'C');
            $pdf->Ln(7);
        }

        $pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');

        if($datos_empresa['empresa_factura_impuestos']=="Si"){
            $pdf->Ln(5);

            $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
            $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","SUBTOTAL"),0,0,'C');
            $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","+ ".COIN_SYMBOL.number_format($datos_venta['venta_subtotal'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND)),0,0,'C');

            $pdf->Ln(5);

            $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
            $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1",$datos_venta['venta_impuesto_nombre']." (".$datos_venta['venta_impuesto_porcentaje']."%)"),0,0,'C');
            $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","+ ".COIN_SYMBOL.number_format($datos_venta['venta_impuestos'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND)),0,0,'C');

            $pdf->Ln(5);

            $pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
        }

        $pdf->Ln(5);

        $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
        $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","TOTAL A PAGAR"),0,0,'C');
        $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1",COIN_SYMBOL.number_format($datos_venta['venta_total'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME),0,0,'C');

        $pdf->Ln(5);
        
        $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
        $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","TOTAL PAGADO"),0,0,'C');
        $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1",COIN_SYMBOL.number_format($datos_venta['venta_pagado'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME),0,0,'C');

        $pdf->Ln(5);

        $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
        $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","CAMBIO"),0,0,'C');
        $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1",COIN_SYMBOL.number_format($datos_venta['venta_cambio'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME),0,0,'C');

        $pdf->Ln(5);

        $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
        $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","USTED AHORRA"),0,0,'C');
        $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1",COIN_SYMBOL.number_format(0.00,COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME),0,0,'C');

        $pdf->Ln(10);

        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","*** Precios de productos incluyen impuestos. Para poder realizar un reclamo o devolución debe de presentar este ticket ***"),0,'C',false);

        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(0,7,iconv("UTF-8", "ISO-8859-1","Gracias por su compra"),'',0,'C');

        $pdf->Ln(9);

        $pdf->Code128(5,$pdf->GetY(),$datos_venta['venta_codigo'],70,20);
        $pdf->SetXY(0,$pdf->GetY()+21);
        $pdf->SetFont('Arial','',14);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",$datos_venta['venta_codigo']),0,'C',false);
        
		$pdf->Output("I","Ticket_Nro".$datos_venta['venta_id'].".pdf",true);

	}else{
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title><?php echo COMPANY; ?></title>
	<?php include '../vistas/inc/head.php'; ?>
</head>
<body>
	<div class="full-box container-404">
		<div>
			<p class="text-center"><i class="fas fa-rocket fa-10x"></i></p>
			<h1 class="text-center">¡Ocurrió un error!</h1>
			<p class="lead text-center">No hemos encontrado datos de la venta</p>
		</div>
	</div>
	<?php include '../vistas/inc/scripts.php'; ?>
</body>
</html>
<?php } ?>