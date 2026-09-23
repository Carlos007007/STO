<?php
    /*---------- Incluyendo configuraciones ----------*/
	require_once "../config/APP.php";
    if(isset($_GET['barcode']) && $_GET['barcode']!="" && isset($_GET['cant']) && $_GET['cant']>0){ 
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title><?php echo COMPANY; ?></title>
	<?php include '../vistas/inc/Head.php'; ?>
    <script src="<?php echo SERVERURL; ?>vistas/js/JsBarcode.all.min.js" ></script>
    <style>
        body{
            padding: 15px;
            background-color: #fff;
        }
        .barcode{
            display: inline-block;
            border: 1px solid #E1E1E1;
        }
    </style>
</head>
<body class="text-center" onload="window.print();">
    <?php
        for($i=1;$i<=$_GET['cant'];$i++){
            echo ' 
                <p class="text-center barcode">
                    <svg class="codigo_barras"></svg>
                </p>
            ';
        }
        include '../vistas/inc/Script.php'; 
    ?>
    <script>
        JsBarcode(".codigo_barras", "<?php echo $_GET['barcode']; ?>",{
            format: "<?php echo BARCODE_FORMAT; ?>",
            textAlign: "<?php echo BARCODE_TEXT_ALIGN; ?>",
            textPosition: "<?php echo BARCODE_TEXT_POSITION; ?>"
        });
    </script>
</body>
</html>
<?php }else{ ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title><?php echo COMPANY; ?></title>
	<?php include '../vistas/inc/Head.php'; ?>
</head>
<body>
	<div class="full-box container-404">
		<div>
			<p class="text-center"><i class="fas fa-user-astronaut fa-10x"></i></p>
			<h1 class="text-center">¡Ocurrió un error!</h1>
			<p class="lead text-center">No ha ingresado un código de barras o un código SKU</p>
		</div>
	</div>
	<?php include '../vistas/inc/Script.php'; ?>
</body>
</html>
<?php } ?>