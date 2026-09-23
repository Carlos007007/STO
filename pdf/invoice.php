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


		require "./code128.php";

		$pdf = new PDF_Code128('P','mm','Letter');
		$pdf->SetMargins(17,17,17);
		$pdf->AddPage();
		$pdf->Image(SERVERURL.'./vistas/assets/img/logo.png',165,12,35,35,'PNG');

		$pdf->SetFont('Arial','B',16);
		$pdf->SetTextColor(32,100,210);
		$pdf->Cell(150,10,iconv("UTF-8", "ISO-8859-1",strtoupper($datos_empresa['empresa_nombre'])),0,0,'L');

		$pdf->Ln(9);

		$pdf->SetFont('Arial','',10);
		$pdf->SetTextColor(39,39,51);
		$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1",$datos_empresa['empresa_tipo_documento'].": ".$datos_empresa['empresa_numero_documento']),0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1",$datos_empresa['empresa_direccion']),0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1","Teléfono: ".$datos_empresa['empresa_telefono']),0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1","Email: ".$datos_empresa['empresa_email']),0,0,'L');

		$pdf->Ln(10);

		$pdf->SetFont('Arial','',10);
		$pdf->Cell(30,7,iconv("UTF-8", "ISO-8859-1",'Fecha de emisión:'),0,0);
		$pdf->SetTextColor(97,97,97);
		$pdf->Cell(116,7,iconv("UTF-8", "ISO-8859-1",date("d/m/Y", strtotime($datos_venta['venta_fecha']))." ".$datos_venta['venta_hora']),0,0,'L');
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(39,39,51);
		$pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1",strtoupper('Factura Nro.')),0,0,'C');

		$pdf->Ln(7);

		$pdf->SetFont('Arial','',10);
		$pdf->Cell(12,7,iconv("UTF-8", "ISO-8859-1",'Cajero:'),0,0,'L');
		$pdf->SetTextColor(97,97,97);
		$pdf->Cell(134,7,iconv("UTF-8", "ISO-8859-1",$datos_venta['usuario_nombre']." ".$datos_venta['usuario_apellido']),0,0,'L');
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(97,97,97);
		$pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1",strtoupper($datos_venta['venta_id'])),0,0,'C');

		$pdf->Ln(7);

		$pdf->SetTextColor(39,39,51);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(24,7,iconv("UTF-8", "ISO-8859-1",'Tipo de venta:'),0,0,'L');
		$pdf->SetTextColor(97,97,97);
		$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",'Contado'),0,0,'L');

		$pdf->Ln(10);

		if($datos_venta['cliente_id']==1){
			$pdf->SetFont('Arial','',10);
			$pdf->SetTextColor(39,39,51);
			$pdf->Cell(13,7,iconv("UTF-8", "ISO-8859-1",'Cliente:'),0,0);
			$pdf->SetTextColor(97,97,97);
			$pdf->Cell(60,7,iconv("UTF-8", "ISO-8859-1","N/A"),0,0,'L');
			$pdf->SetTextColor(39,39,51);
			$pdf->Cell(7,7,iconv("UTF-8", "ISO-8859-1",'Tel:'),0,0,'L');
			$pdf->SetTextColor(97,97,97);
			$pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1","N/A"),0,0);
			$pdf->SetTextColor(39,39,51);

			$pdf->Ln(7);

			$pdf->SetTextColor(39,39,51);
			$pdf->Cell(6,7,iconv("UTF-8", "ISO-8859-1",'Dir:'),0,0);
			$pdf->SetTextColor(97,97,97);
			$pdf->Cell(109,7,iconv("UTF-8", "ISO-8859-1","N/A"),0,0);
		}else{
			$pdf->SetFont('Arial','',10);
			$pdf->SetTextColor(39,39,51);
			$pdf->Cell(13,7,iconv("UTF-8", "ISO-8859-1",'Cliente:'),0,0);
			$pdf->SetTextColor(97,97,97);
			$pdf->Cell(60,7,iconv("UTF-8", "ISO-8859-1",$datos_venta['cliente_nombre']." ".$datos_venta['cliente_apellido']),0,0,'L');
			$pdf->SetTextColor(39,39,51);
			$pdf->Cell(7,7,iconv("UTF-8", "ISO-8859-1",'Tel:'),0,0,'L');
			$pdf->SetTextColor(97,97,97);
			$pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1",$datos_venta['cliente_telefono']),0,0);
			$pdf->SetTextColor(39,39,51);

			$pdf->Ln(7);

			$pdf->SetTextColor(39,39,51);
			$pdf->Cell(6,7,iconv("UTF-8", "ISO-8859-1",'Dir:'),0,0);
			$pdf->SetTextColor(97,97,97);
			$pdf->Cell(109,7,iconv("UTF-8", "ISO-8859-1",$datos_venta['cliente_provincia'].", ".$datos_venta['cliente_ciudad'].", ".$datos_venta['cliente_direccion']),0,0);
		}

		$pdf->Ln(9);

		$pdf->SetFont('Arial','',8);
		$pdf->SetFillColor(23,83,201);
		$pdf->SetDrawColor(23,83,201);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(90,8,iconv("UTF-8", "ISO-8859-1",'Descripción'),1,0,'C',true);
		$pdf->Cell(15,8,iconv("UTF-8", "ISO-8859-1",'Cant.'),1,0,'C',true);
		$pdf->Cell(25,8,iconv("UTF-8", "ISO-8859-1",'Precio'),1,0,'C',true);
		$pdf->Cell(19,8,iconv("UTF-8", "ISO-8859-1",'Desc.'),1,0,'C',true);
		$pdf->Cell(32,8,iconv("UTF-8", "ISO-8859-1",'Subtotal'),1,0,'C',true);

		$pdf->Ln(8);

		
		$pdf->SetTextColor(39,39,51);

		/*----------  Seleccionando detalles de la venta  ----------*/
		$venta_detalle=$ins_pedido->datos_tabla("Normal","venta_detalle WHERE venta_codigo='".$datos_venta['venta_codigo']."'","*",0);
		$venta_detalle=$venta_detalle->fetchAll();

		foreach($venta_detalle as $detalle){
			$pdf->Cell(90,7,iconv("UTF-8", "ISO-8859-1",$ins_pedido->limitar_cadena($detalle['venta_detalle_descripcion'],60,"...")),'L',0,'C');
			$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",$detalle['venta_detalle_cantidad']),'L',0,'C');
			$pdf->Cell(25,7,iconv("UTF-8", "ISO-8859-1",COIN_SYMBOL.number_format($detalle['venta_detalle_precio_venta'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND)),'L',0,'C');
			$pdf->Cell(19,7,iconv("UTF-8", "ISO-8859-1",COIN_SYMBOL.number_format((0.00),COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND)),'L',0,'C');
			$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1",COIN_SYMBOL.number_format($detalle['venta_detalle_total'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND)),'LR',0,'C');
			$pdf->Ln(7);
		}

		$pdf->SetFont('Arial','B',9);
		
		if($datos_empresa['empresa_factura_impuestos']=="Si"){
			$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'T',0,'C');
			$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'T',0,'C');
			$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1",'SUBTOTAL'),'T',0,'C');
			$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1","+ ".COIN_SYMBOL.number_format($datos_venta['venta_subtotal'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND)),'T',0,'C');

			$pdf->Ln(7);

			$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
			$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
			$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1",$datos_venta['venta_impuesto_nombre']." (".$datos_venta['venta_impuesto_porcentaje']."%)"),'',0,'C');
			$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1","+ ".COIN_SYMBOL.number_format($datos_venta['venta_impuestos'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND)),'',0,'C');

			$pdf->Ln(7);

			$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
			$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
		}else{
			$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'T',0,'C');
			$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'T',0,'C');
		}


		$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1",'TOTAL A PAGAR'),'T',0,'C');
		$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1",COIN_SYMBOL.number_format($datos_venta['venta_total'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME),'T',0,'C');

		$pdf->Ln(7);

		$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
		$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
		$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1",'TOTAL PAGADO'),'',0,'C');
		$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1",COIN_SYMBOL.number_format($datos_venta['venta_pagado'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME),'',0,'C');

		$pdf->Ln(7);

		$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
		$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
		$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1",'CAMBIO'),'',0,'C');
		$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1",COIN_SYMBOL.number_format($datos_venta['venta_cambio'],COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME),'',0,'C');

		$pdf->Ln(7);

		$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
		$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
		$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1",'USTED AHORRA'),'',0,'C');
		$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1",COIN_SYMBOL.number_format(0.00,COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME),'',0,'C');

		$pdf->Ln(12);

		$pdf->SetFont('Arial','',9);
		$pdf->SetTextColor(39,39,51);

		$pdf->MultiCell(0,9,iconv("UTF-8", "ISO-8859-1","*** Precios de productos incluyen impuestos. Para poder realizar un reclamo o devolución debe de presentar esta factura ***"),0,'C',false);

		$pdf->Ln(9);

		$pdf->SetFillColor(39,39,51);
		$pdf->SetDrawColor(23,83,201);
        $pdf->Code128(72,$pdf->GetY(),$datos_venta['venta_codigo'],70,20);
        $pdf->SetXY(12,$pdf->GetY()+21);
        $pdf->SetFont('Arial','',12);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",$datos_venta['venta_codigo']),0,'C',false);

		$pdf->Output("I","Factura_Nro".$datos_venta['venta_id'].".pdf",true);

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