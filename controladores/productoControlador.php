<?php

    if($peticion_ajax){
        require_once "../modelos/mainModel.php";
    }else{
        require_once "./modelos/mainModel.php";
    }

	class productoControlador extends mainModel{

        /*--------- Controlador registrar producto - Controller register product ---------*/
        public function registrar_producto_controlador(){

            /*-- Comprobando privilegios - Checking privileges --*/
			if($_SESSION['cargo_sto']!="Administrador"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Acceso no permitido",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
			}

            /*-- Recibiendo datos del formulario - Receiving form data --*/
            $codigo=mainModel::limpiar_cadena($_POST['producto_codigo_reg']);
            $sku=mainModel::limpiar_cadena($_POST['producto_sku_reg']);

            $nombre=mainModel::limpiar_cadena($_POST['producto_nombre_reg']);
            $precio_compra=mainModel::limpiar_cadena($_POST['producto_precio_compra_reg']);
            $precio_venta=mainModel::limpiar_cadena($_POST['producto_precio_venta_reg']);
            $stock_total=mainModel::limpiar_cadena($_POST['producto_stock_reg']);
            $stock_minimo=mainModel::limpiar_cadena($_POST['producto_stock_minimo_reg']);
            $descuento=mainModel::limpiar_cadena($_POST['producto_descuento_reg']);
            $marca=mainModel::limpiar_cadena($_POST['producto_marca_reg']);
            $modelo=mainModel::limpiar_cadena($_POST['producto_modelo_reg']);

            $tipo=mainModel::limpiar_cadena($_POST['producto_tipo_reg']);
            $presentacion=mainModel::limpiar_cadena($_POST['producto_presentacion_reg']);
            $categoria=mainModel::limpiar_cadena($_POST['producto_categoria_reg']);
            $estado=mainModel::limpiar_cadena($_POST['producto_estado_reg']);

            $descripcion=mainModel::limpiar_cadena($_POST['producto_descripcion_reg']);

            /*-- Comprobando campos vacios - Checking empty fields --*/
            if($codigo=="" || $nombre=="" || $precio_compra=="" || $precio_venta=="" || $stock_total=="" || $stock_minimo=="" || $descuento==""){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No has llenado todos los campos que son obligatorios",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Verificando integridad de los datos - Checking data integrity --*/
            if(mainModel::verificar_datos("[a-zA-Z0-9- ]{1,49}",$codigo)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El CÓDIGO DE BARRAS no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if($sku!=""){
                if(mainModel::verificar_datos("[a-zA-Z0-9- ]{1,49}",$sku)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Formato no valido",
                        "Texto"=>"El CÓDIGO SKU no coincide con el formato solicitado",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\- ]{1,97}",$nombre)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El NOMBRE no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9.]{1,25}",$precio_compra)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El PRECIO DE COMPRA no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9.]{1,25}",$precio_venta)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El PRECIO DE VENTA no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9]{1,9}",$stock_total)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El STOCK no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9]{1,9}",$stock_minimo)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El STOCK MÍNIMO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9]{1,2}",$descuento)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El DESCUENTO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if($marca!=""){
                if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,30}",$marca)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Formato no valido",
                        "Texto"=>"La MARCA no coincide con el formato solicitado",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if($modelo!=""){
                if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,40}",$modelo)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Formato no valido",
                        "Texto"=>"El MODELO no coincide con el formato solicitado",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if($descripcion!=""){
                if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\s ]{4,520}",$descripcion)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Formato no valido",
                        "Texto"=>"La DESCRIPCIÓN no coincide con el formato solicitado",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            /*-- Comprobando tipo - Checking type --*/
			if($tipo!="Fisico" && $tipo!="Digital"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Opción no valida",
					"Texto"=>"Ha seleccionado un TIPO de producto no valido",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Comprobando presentacion - Checking presentation ==*/
			if(!in_array($presentacion, PRODUTS_UNITS)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Opción no valida",
					"Texto"=>"Ha seleccionado una PRESENTACIÓN de producto no valida",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Comprobando estado - Checking status --*/
			if($estado!="Habilitado" && $estado!="Deshabilitado"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Opción no valida",
					"Texto"=>"Ha seleccionado un ESTADO de producto no valido",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Verificando stock total y minimo - Checking total and minimum stock --*/
            if($stock_total<=0){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"No puedes registrar un producto con stock o existencias en 0, debes de agregar al menos una unidad.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if($stock_total<$stock_minimo){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El STOCK MÍNIMO no puede ser mayor al STOCK O EXISTENCIAS totales.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Comprobando y formateando precios de producto - Checking and formatting product prices --*/
            $precio_compra=number_format($precio_compra,COIN_DECIMALS,'.','');
            $precio_venta=number_format($precio_venta,COIN_DECIMALS,'.','');

            if($precio_compra<=0){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El PRECIO DE COMPRA no puede ser menor o igual a 0.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if($precio_venta<=0){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El PRECIO DE VENTA no puede ser menor o igual a 0.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if($precio_compra>$precio_venta){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El PRECIO DE COMPRA del producto no puede ser mayor al PRECIO DE VENTA.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Comprobando categoria - Checking category --*/
            $check_categoria=mainModel::ejecutar_consulta_simple("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria' AND categoria_estado='Habilitada'");
            if($check_categoria->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"La CATEGORÍA que ha seleccionado no existe o se encuentra deshabilitada.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }
            $check_categoria->closeCursor();
            $check_categoria=mainModel::desconectar($check_categoria);

            /*-- Comprobando codigo de barras - Checking barcode --*/
            $check_codigo=mainModel::ejecutar_consulta_simple("SELECT producto_codigo FROM producto WHERE producto_codigo='$codigo'");
            if($check_codigo->rowCount()>0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El CÓDIGO DE BARRAS de producto que ha ingresado ya se encuentra registrado en el sistema.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }
            $check_codigo->closeCursor();
            $check_codigo=mainModel::desconectar($check_codigo);

            /*-- Comprobando codigo SKU - Checking SKU --*/
            if($sku!=""){
                $check_sku=mainModel::ejecutar_consulta_simple("SELECT producto_sku FROM producto WHERE producto_sku='$sku'");
                if($check_sku->rowCount()>0){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El CÓDIGO SKU de producto que ha ingresado ya se encuentra registrado en el sistema.",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                $check_sku->closeCursor();
                $check_sku=mainModel::desconectar($check_sku);
            }

            /*-- Comprobando nombre - Checking name --*/
            $check_nombre=mainModel::ejecutar_consulta_simple("SELECT producto_nombre FROM producto WHERE producto_codigo='$codigo' AND producto_nombre='$nombre'");
            if($check_nombre->rowCount()>0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"Ya existe un producto registrado con el mismo NOMBRE y CÓDIGO DE BARRAS.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }
            $check_nombre->closeCursor();
            $check_nombre=mainModel::desconectar($check_nombre);

            /*-- Directorios de imagenes - Image Directories --*/
			$img_dir='../vistas/assets/product/cover/';

            /*-- Comprobando si se ha seleccionado una imagen - Checking if an image has been selected --*/
            if($_FILES['producto_portada']['name']!="" && $_FILES['producto_portada']['size']>0){

                /*-- Comprobando formato de las imagenes - Checking image format --*/
                if(mime_content_type($_FILES['producto_portada']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['producto_portada']['tmp_name'])!="image/png"){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Formato no valido",
                        "Texto"=>"El FORMATO DE LA IMAGEN que acaba de seleccionar no está permitido.",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }

                /*-- Comprobando que la imagen no supere el peso permitido - Checking that the image does not exceed the allowed weight --*/
                $img_max_size=COVER_PRODUCT*1024;
                if(($_FILES['producto_portada']['size']/1024)>$img_max_size){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Tamaño excedido",
                        "Texto"=>"El tamaño de la imagen supera el límite de peso máximo que son ".COVER_PRODUCT."MB.",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }

                /*-- Extencion de las imagenes - extension of the images --*/
                switch(mime_content_type($_FILES['producto_portada']['tmp_name'])) {
					case 'image/jpeg':
						$img_ext=".jpg";
					break;
					case 'image/png':
						$img_ext=".png";
					break;
				}

                /*-- Cambiando permisos al directorio - Changing permissions to the directory --*/
                chmod($img_dir, 0777);

                /*-- Generando un codigo para la imagen - Generating a code for the image --*/
                $correlativo=mainModel::ejecutar_consulta_simple("SELECT producto_id FROM producto");
                $correlativo=($correlativo->rowCount())+1;
                $codigo_img=mainModel::generar_codigo_aleatorio(10,$correlativo);

                /*-- Nombre final de la imagen - Final image name --*/
                $img_portada=$codigo_img.$img_ext;

                /* Moviendo imagen al directorio - Moving image to directory */
                if(!move_uploaded_file($_FILES['producto_portada']['tmp_name'], $img_dir.$img_portada)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Error al cargar archivos",
                        "Texto"=>"No podemos subir la imagen al sistema en este momento, por favor intente nuevamente.",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }

            }else{
                $img_portada="";
            }

            /*-- Preparando datos para enviarlos al modelo - Preparing data to send to the model --*/
            $datos_producto_reg=[
                "producto_codigo"=>[
					"campo_marcador"=>":Codigo",
					"campo_valor"=>$codigo
				],
                "producto_sku"=>[
					"campo_marcador"=>":Sku",
					"campo_valor"=>$sku
				],
                "producto_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
                "producto_descripcion"=>[
					"campo_marcador"=>":Descripcion",
					"campo_valor"=>$descripcion
				],
                "producto_stock"=>[
					"campo_marcador"=>":StockT",
					"campo_valor"=>$stock_total
				],
                "producto_stock_minimo"=>[
					"campo_marcador"=>":StockM",
					"campo_valor"=>$stock_minimo
				],
                "producto_precio_compra"=>[
					"campo_marcador"=>":PrecioC",
					"campo_valor"=>$precio_compra
				],
                "producto_precio_venta"=>[
					"campo_marcador"=>":PrecioV",
					"campo_valor"=>$precio_venta
				],
                "producto_descuento"=>[
					"campo_marcador"=>":Descuento",
					"campo_valor"=>$descuento
				],
                "producto_tipo"=>[
					"campo_marcador"=>":Tipo",
					"campo_valor"=>$tipo
				],
                "producto_presentacion"=>[
					"campo_marcador"=>":Presentacion",
					"campo_valor"=>$presentacion
				],
                "producto_marca"=>[
					"campo_marcador"=>":Marca",
					"campo_valor"=>$marca
				],
                "producto_modelo"=>[
					"campo_marcador"=>":Modelo",
					"campo_valor"=>$modelo
				],
                "producto_estado"=>[
					"campo_marcador"=>":Estado",
					"campo_valor"=>$estado
				],
                "producto_portada"=>[
					"campo_marcador"=>":Portada",
					"campo_valor"=>$img_portada
				],
                "categoria_id"=>[
					"campo_marcador"=>":Categoria",
					"campo_valor"=>$categoria
				]
            ];

            /*-- Guardando datos del producto - Saving product data --*/
			$agregar_producto=mainModel::guardar_datos("producto",$datos_producto_reg);

			if($agregar_producto->rowCount()==1){
                $alerta=[
                    "Alerta"=>"limpiar",
                    "Titulo"=>"¡Producto registrado!",
                    "Texto"=>"Los datos del producto se registraron con éxito",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];
			}else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido registrar los datos, por favor intente nuevamente",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
			}

			$agregar_producto->closeCursor();
			$agregar_producto=mainModel::desconectar($agregar_producto);

			echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador paginador productos (administrador) - Product Pager Controller (admin) ---------*/
        public function administrador_paginador_producto_controlador($pagina,$registros,$url,$busqueda){
            $pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);

			$url=mainModel::limpiar_cadena($url);

            $tipo_lista=["product-search","product-list","product-category","product-minimum"];

			if(!in_array($url, $tipo_lista)){
				return '
                    <div class="alert alert-danger text-center" role="alert" data-mdb-color="danger">
                        <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
                        <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
                        <p class="mb-0">Lo sentimos, no podemos realizar la búsqueda ya que al parecer a ingresado un dato incorrecto.</p>
                    </div>
				';
				exit();
			}else{
				$tipo=$url;
			}

            $busqueda=mainModel::limpiar_cadena($busqueda);
			$tabla="";

            if($tipo=="product-category"){
                $url=SERVERURL.DASHBOARD."/".$url."/".$busqueda."/";
			}else{
                $url=SERVERURL.DASHBOARD."/".$url."/";
			}

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
            $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

            $campos="*";
            
            if(isset($busqueda) && $busqueda!="" && $tipo=="product-search"){
				$consulta="SELECT SQL_CALC_FOUND_ROWS $campos FROM producto WHERE producto_codigo LIKE '%$busqueda%' OR producto_sku LIKE '%$busqueda%' OR producto_nombre LIKE '%$busqueda%' ORDER BY producto_nombre ASC LIMIT $inicio,$registros";
			}elseif($tipo=="product-list"){
				$consulta="SELECT SQL_CALC_FOUND_ROWS $campos FROM producto ORDER BY producto_nombre ASC LIMIT $inicio,$registros";
			}elseif($tipo=="product-category"){
				$consulta="SELECT SQL_CALC_FOUND_ROWS $campos FROM producto WHERE categoria_id='$busqueda' ORDER BY producto_nombre ASC LIMIT $inicio,$registros";
			}elseif($tipo=="product-minimum"){
				$consulta="SELECT SQL_CALC_FOUND_ROWS $campos FROM producto WHERE producto_stock<=producto_stock_minimo ORDER BY producto_nombre ASC LIMIT $inicio,$registros";
			}

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);

			$datos = $datos->fetchAll();

			$total = $conexion->query("SELECT FOUND_ROWS()");
			$total = (int) $total->fetchColumn();

            $Npaginas =ceil($total/$registros);

            if($total>=1 && $pagina<=$Npaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($datos as $rows){

                    $total_price=$rows['producto_precio_venta']-($rows['producto_precio_venta']*($rows['producto_descuento']/100));

					$tabla.='
                        <div class="product-list mb-4">
                            <div class="product-list-img">
                                <figure>';
                                if(is_file("./vistas/assets/product/cover/".$rows['producto_portada'])){
                                    $tabla.='<img src="'.SERVERURL.'vistas/assets/product/cover/'.$rows['producto_portada'].'" class="img-fluid" alt="'.$rows['producto_nombre'].'" />';
                                }else{
                                    $tabla.='<img src="'.SERVERURL.'vistas/assets/product/cover/default.jpg" class="img-fluid" alt="'.$rows['producto_nombre'].'" />';
                                }
                                $tabla.='</figure>
                            </div>
                            <div class="product-list-body">
                                <h5 class="mb-1 roboto-condensed-regular text-center">'.$contador.' - '.$rows['producto_nombre'].'</h5>
                                <div class="container-fluid" style="padding-top: 5px;">
                                    <div class="row">
                                        <div class="col-6 col-lg-4 mb-2">
                                            <strong class="text-uppercase"><i class="fas fa-barcode fa-fw"></i> Código:</strong> '.$rows['producto_codigo'].'
                                        </div>
                                        <div class="col-6 col-lg-4 mb-2">
                                            <strong class="text-uppercase"><i class="fas fa-barcode fa-fw"></i> SKU:</strong> '.$rows['producto_sku'].'
                                        </div>
                                        <div class="col-6 col-lg-4 mb-2">
                                            <strong class="text-uppercase"><i class="fas fa-dollar-sign fa-fw"></i> Precio:</strong> '.COIN_SYMBOL.number_format($total_price,COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME.'
                                        </div>
                                        <div class="col-6 col-lg-4 mb-2">
                                            <strong class="text-uppercase"><i class="fas fa-box fa-fw"></i> Stock:</strong> '.$rows['producto_stock'].' '.$rows['producto_presentacion'].'
                                        </div>
                                        <div class="col-6 col-lg-4 mb-2">
                                            <strong class="text-uppercase"><i class="fas fa-pallet fa-fw"></i> Tipo:</strong> '.$rows['producto_tipo'].'
                                        </div>
                                        <div class="col-6 col-lg-4 mb-2">
                                            <strong class="text-uppercase"><i class="far fa-registered fa-fw"></i> Fabricante:</strong> '.$rows['producto_marca'].'
                                        </div>
                                    </div>
                                </div>
                                <div class="full-box text-end">
                                    <div class="btn-group shadow-0">
                                        <button type="button" class="btn btn-link dropdown-toggle" data-mdb-toggle="dropdown" aria-expanded="false" ><i class="fas fa-tools"></i> &nbsp; Opciones</button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="'.SERVERURL.DASHBOARD.'/product-info/'.mainModel::encryption($rows['producto_id']).'/" >
                                                    <i class="fas fa-info-circle"></i> &nbsp; Información de producto
                                                </a>
                                            </li>';

                                            if($_SESSION['cargo_sto']=="Administrador"){
                                                $tabla.='<li>
                                                    <a class="dropdown-item" href="'.SERVERURL.DASHBOARD.'/product-cover/'.mainModel::encryption($rows['producto_id']).'/" >
                                                        <i class="far fa-image"></i> &nbsp; Foto o portada
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="'.SERVERURL.DASHBOARD.'/product-gallery/'.mainModel::encryption($rows['producto_id']).'/" >
                                                        <i class="far fa-images"></i> &nbsp; Galería de imágenes
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="'.SERVERURL.DASHBOARD.'/product-update/'.mainModel::encryption($rows['producto_id']).'/" >
                                                        <i class="fas fa-sync-alt"></i> &nbsp; Actualizar datos
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider" /></li>
                                                <li>
                                                    <form class="FormularioAjax" action="'.SERVERURL.'ajax/productoAjax.php" method="POST" data-form="delete" data-lang="'.LANG.'" >
                                                        <input type="hidden" name="modulo_producto" value="eliminar">
                                                        <input type="hidden" name="producto_id_del" value="'.mainModel::encryption($rows['producto_id']).'">
                                                        <button type="submit" class="dropdown-item text-danger" >
                                                            <i class="far fa-trash-alt"></i> &nbsp; Eliminar
                                                        </button>
                                                    </form>
                                                </li>';
                                            }

                                        $tabla.='</ul>
                                    </div>
                                </div>
                            </div>
                        </div>
					';
					$contador++;
				}
				$pag_final=$contador-1;
			}else{
				if($total>=1){
                    $tabla.='
                        <div class="list-group">
                            <a href="'.$url.'" class="list-group-item text-center list-group-item-action  active">
                                <h5 class="mb-4 text-center">Haga clic acá para recargar el listado</h5>
                                <p><i class="fas fa-boxes fa-fw fa-5x"></i></p>
                                <p class="mb-1">
                                    Haga clic para listar nuevamente los productos que estan registrados en el sistema
                                </p>
                            </a>
                        </div>
					';
				}else{
					$tabla.='
                        <div class="list-group">
                            <div class="list-group-item text-center list-group-item-action">
                                <h5 class="mb-4 text-center">No hay productos en inventario</h5>
                                <p><i class="fas fa-broadcast-tower fa-fw fa-5x"></i></p>
                                <p class="mb-1">
                                    No hemos encontrado productos registrados en el sistema
                                </p>
                            </div>
                        </div>
					';
				}
			}

			if($total>0 && $pagina<=$Npaginas){
				$tabla.='<hr><p class="text-end">Mostrando productos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
			}

			/*--Paginacion - Pagination --*/
			if($total>=1 && $pagina<=$Npaginas){
				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7,LANG);
			}

			return $tabla;
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador paginador productos (cliente) - Product Pager Controller (client) ---------*/
        public function cliente_paginador_producto_controlador($pagina,$registros,$url,$orden,$categoria,$busqueda){
            $pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);

			$url=mainModel::limpiar_cadena($url);
            $orden=mainModel::limpiar_cadena($orden);
            $categoria=mainModel::limpiar_cadena($categoria);
            $busqueda=mainModel::limpiar_cadena($busqueda);
            $url=SERVERURL.$url."/".$categoria."/".$orden."/";
			$tabla="";


            /*-- Lista blanca para orden de busqueda - Whitelist for search order --*/
            $orden_lista=["ASC","DESC","MAX","MIN"];

			if(!in_array($orden, $orden_lista)){
				return '
                    <div class="alert alert-danger text-center" role="alert" data-mdb-color="danger">
                        <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
                        <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
                        <p class="mb-0">Lo sentimos, no podemos realizar la búsqueda de productos ya que al parecer a ingresado un dato incorrecto.</p>
                    </div>
				';
				exit();
			}

            /*-- Estableciendo orden de busqueda - Establishing search order --*/
            if($orden=="ASC" || $orden=="DESC"){
                $campo_orden="producto_nombre $orden";
            }elseif($orden=="MAX" || $orden=="MIN"){
                if($orden=="MAX"){
                    $campo_orden="producto_precio_venta DESC";
                }else{
                    $campo_orden="producto_precio_venta ASC";
                }
            }else{
                $campo_orden="producto_nombre ASC";
            }
            
            /*-- Comprobando categoria - Checking category --*/
            if($categoria!="all"){
                $check_categoria=mainModel::ejecutar_consulta_simple("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria' AND categoria_estado='Habilitada'");
                if($check_categoria->rowCount()<=0){
                    return '
                        <div class="alert alert-danger text-center" role="alert" data-mdb-color="danger">
                            <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
                            <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
                            <p class="mb-0">Lo sentimos, no podemos realizar la búsqueda de productos ya que al parecer a ingresado una categoría incorrecta.</p>
                        </div>
                    ';
                    exit();
                }
                $check_categoria->closeCursor();
                $check_categoria=mainModel::desconectar($check_categoria);
            }
            

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
            $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;


            $campos="*";
            
            if(isset($busqueda) && $busqueda!=""){
                if($categoria!="all"){
                    $condicion_busqueda="categoria_id='$categoria' AND";
                }else{
                    $condicion_busqueda="";
                }
				$consulta="SELECT SQL_CALC_FOUND_ROWS $campos FROM producto WHERE $condicion_busqueda producto_estado='Habilitado' AND producto_stock>0 AND producto_nombre LIKE '%$busqueda%' ORDER BY $campo_orden LIMIT $inicio,$registros";
			}elseif($categoria!="all"){
				$consulta="SELECT SQL_CALC_FOUND_ROWS $campos FROM producto WHERE producto_estado='Habilitado' AND categoria_id='$categoria' AND producto_stock>0 ORDER BY $campo_orden LIMIT $inicio,$registros";
			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS $campos FROM producto WHERE producto_estado='Habilitado' AND producto_stock>0 ORDER BY $campo_orden LIMIT $inicio,$registros";
			}

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);

			$datos = $datos->fetchAll();

			$total = $conexion->query("SELECT FOUND_ROWS()");
			$total = (int) $total->fetchColumn();

            $Npaginas =ceil($total/$registros);

            $tabla.='<div class="container-cards full-box">';

            if($total>=1 && $pagina<=$Npaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($datos as $rows){

                    $total_price=$rows['producto_precio_venta']-($rows['producto_precio_venta']*($rows['producto_descuento']/100));

					$tabla.='
                        <div class="card-product div-bordered bg-white shadow-2">
                            <figure class="card-product-img">';
                                if(is_file("./vistas/assets/product/cover/".$rows['producto_portada'])){
                                    $tabla.='<img src="'.SERVERURL.'vistas/assets/product/cover/'.$rows['producto_portada'].'" class="img-fluid" alt="'.$rows['producto_nombre'].'" />';
                                }else{
                                    $tabla.='<img src="'.SERVERURL.'vistas/assets/product/cover/default.jpg" class="img-fluid" alt="'.$rows['producto_nombre'].'" />';
                                }
                            $tabla.='</figure>
                            <div class="card-product-body">
                                <div class="card-product-content scroll">
                                    <h5 class="text-center fw-bolder">'.mainModel::limitar_cadena($rows['producto_nombre'],70,"...").'</h5>
                                    <p class="card-product-price text-center fw-bolder">'.COIN_SYMBOL.number_format($total_price,COIN_DECIMALS,COIN_SEPARATOR_DECIMAL,COIN_SEPARATOR_THOUSAND).' '.COIN_NAME.'</p>';
                                    if($rows['producto_tipo']=="Fisico"){
                                        $tabla.='<span class="full-box text-center text-muted" style="display: block;">En stock: '.$rows['producto_stock'].'</span>';
                                    }
                                $tabla.='</div>
                                <div class="text-center card-product-options" style="padding: 10px 0;">
                                    <button type="button" class="btn btn-link btn-sm btn-rounded text-success" ><i class="fas fa-shopping-bag fa-fw"></i> &nbsp; Agregar</button>
                                    &nbsp; &nbsp;
                                    <a href="'.SERVERURL.'details/'.mainModel::encryption($rows['producto_id']).'/" class="btn btn-link btn-sm btn-rounded" ><i class="fas fa-box-open fa-fw"></i> &nbsp; Detalles</a>
                                    &nbsp; &nbsp;
                                    <button type="button" class="btn btn-link btn-sm btn-rounded" ><i class="fas fa-heart fa-fw"></i></button>
                                </div>
                            </div>
                        </div>
					';
					$contador++;
				}
				$pag_final=$contador-1;
			}else{
				if($total>=1){
                    $tabla.='
                        <div class="alert alert-default text-center" role="alert" data-mdb-color="danger">
                            <p><i class="fas fa-boxes fa-fw fa-5x"></i></p>
                            <h4 class="alert-heading">Haga clic en el botón para listar nuevamente los productos que están registrados en la tienda.</h4>
                            <a href="'.$url.'" class="btn btn-primary btn-rounded btn-lg" data-mdb-ripple-color="dark">Haga clic acá para recargar el listado</a>
                        </div>
					';
				}else{
					$tabla.='
                        <div class="alert alert-default text-center" role="alert" data-mdb-color="danger">
                            <p><i class="fas fa-broadcast-tower fa-fw fa-5x"></i></p>
                            <h4 class="alert-heading">¡No hay productos en inventario!</h4>
                            <p class="mb-0">No hemos encontrado productos registrados en la tienda.</p>
                        </div>
					';
				}
			}

            $tabla.='</div>';

			if($total>0 && $pagina<=$Npaginas){
				$tabla.='<p class="text-end">Mostrando productos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
			}

			/*--Paginacion - Pagination --*/
			if($total>=1 && $pagina<=$Npaginas){
				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7,LANG);
			}

			return $tabla;
        } /*-- Fin controlador - End controller --*/


        /*---------- Controlador actualizar portada de producto - Controller update product cover ----------*/
		public function actualizar_portada_producto_controlador(){

            /*-- Comprobando privilegios - Checking privileges --*/
			if($_SESSION['cargo_sto']!="Administrador"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Acceso no permitido",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
			}

			/*-- Recuperando id del producto - Retrieving product id --*/
			$id=mainModel::decryption($_POST['producto_id']);
			$id=mainModel::limpiar_cadena($id);

			/*-- Comprobando producto en la DB - Checking product in DB --*/
            $check_producto=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE producto_id='$id'");
            if($check_producto->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos encontrado el producto registrado en el sistema.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
            }else{
            	$campos=$check_producto->fetch();
			}
			$check_producto->closeCursor();
			$check_producto=mainModel::desconectar($check_producto);


			/*-- Comprobando si se ha seleccionado una imagen - Checking if an image has been selected --*/
            if($_FILES['producto_portada']['name']=="" && $_FILES['producto_portada']['size']<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"Parece que no ha seleccionado una imagen.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
			}

			/*-- Comprobando formato de las imagenes - Checking image format --*/
            if(mime_content_type($_FILES['producto_portada']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['producto_portada']['tmp_name'])!="image/png"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Formato no valido",
                    "Texto"=>"El FORMATO DE LA IMAGEN que acaba de seleccionar no está permitido.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

			/*-- Comprobando que la imagen no supere el peso permitido - Checking that the image does not exceed the allowed weight --*/
            $img_max_size=COVER_PRODUCT*1024;
            if(($_FILES['producto_portada']['size']/1024)>$img_max_size){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Tamaño excedido",
                    "Texto"=>"El tamaño de la imagen supera el límite de peso máximo que son ".COVER_PRODUCT."MB.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Extencion de las imagenes - extension of the images --*/
            switch(mime_content_type($_FILES['producto_portada']['tmp_name'])) {
                case 'image/jpeg':
                    $img_ext=".jpg";
                break;
                case 'image/png':
                    $img_ext=".png";
                break;
            }

            /*-- Nombre final de la imagen - Final image name --*/
            $codigo_img=mainModel::generar_codigo_aleatorio(10,$id);
            $img_portada=$codigo_img.$img_ext;

            /*-- Directorios de imagenes - Image Directories --*/
			$img_dir='../vistas/assets/product/cover/';

            /*-- Cambiando permisos al directorio - Changing permissions to the directory --*/
            chmod($img_dir, 0777);

			/* Moviendo imagen al directorio - Moving image to directory */
            if(!move_uploaded_file($_FILES['producto_portada']['tmp_name'], $img_dir.$img_portada)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Error al cargar archivos",
                    "Texto"=>"No podemos subir la imagen al sistema en este momento, por favor intente nuevamente.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

			/* Eliminando la imagen anterior - Deleting the previous image */
			if(is_file($img_dir.$campos['producto_portada'])){
				chmod($img_dir, 0777);
				unlink($img_dir.$campos['producto_portada']);
			}

			/*-- Preparando datos para enviarlos al modelo - Preparing data to send to the model --*/
			$datos_producto_up=[
				"producto_portada"=>[
					"campo_marcador"=>":Portada",
					"campo_valor"=>$img_portada
				]
			];

			$condicion=[
				"condicion_campo"=>"producto_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if(mainModel::actualizar_datos("producto",$datos_producto_up,$condicion)){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"¡Imagen actualizada!",
                    "Texto"=>"La imagen del producto se actualizo con éxito",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];
			}else{

				if(is_file($img_dir.$img_portada)){
					chmod($img_dir, 0777);
					unlink($img_dir.$img_portada);
				}

                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido actualizar la imagen, por favor intente nuevamente",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
			}
			echo json_encode($alerta);
		} /*-- Fin controlador - End controller --*/


        /*---------- Controlador eliminar portada de producto - Controller remove product cover ----------*/
		public function eliminar_portada_producto_controlador(){

            /*-- Comprobando privilegios - Checking privileges --*/
			if($_SESSION['cargo_sto']!="Administrador"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Acceso no permitido",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
			}

			/*-- Recuperando id del producto - Retrieving product id --*/
			$id=mainModel::decryption($_POST['producto_id']);
			$id=mainModel::limpiar_cadena($id);

			/*-- Comprobando producto en la DB - Checking product in DB --*/
            $check_producto=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE producto_id='$id'");
            if($check_producto->rowCount()<=0){
            	$alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos encontrado el producto registrado en el sistema.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
            }else{
            	$campos=$check_producto->fetch();
			}
			$check_producto->closeCursor();
			$check_producto=mainModel::desconectar($check_producto);

			/*-- Directorios de imagenes - Image Directories --*/
			$img_dir='../vistas/assets/product/cover/';

			/* Eliminando la imagen anterior - Deleting the previous image */
			if(is_file($img_dir.$campos['producto_portada'])){
				chmod($img_dir, 0777);
				if(!unlink($img_dir.$campos['producto_portada'])){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"No hemos podido eliminar la imagen del producto, por favor intente nuevamente.",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
					echo json_encode($alerta);
					exit();
				}
			}

			/*-- Preparando datos para enviarlos al modelo - Preparing data to send to the model --*/
			$datos_producto_up=[
				"producto_portada"=>[
					"campo_marcador"=>":Portada",
					"campo_valor"=>""
				]
			];

			$condicion=[
				"condicion_campo"=>"producto_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if(mainModel::actualizar_datos("producto",$datos_producto_up,$condicion)){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"¡Imagen eliminada!",
                    "Texto"=>"La imagen del producto se elimino con éxito.",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];
			}else{
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"¡Imagen eliminada!",
                    "Texto"=>"Hemos tratado de eliminar la imagen del producto, sin embargo, tuvimos algunos inconvenientes en caso de que la imagen no este eliminada por favor intente nuevamente.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
			}
			echo json_encode($alerta);
		} /*-- Fin controlador - End controller --*/


        /*---------- Controlador agregar galeria de producto - Controller add product gallery ----------*/
		public function agregar_galeria_producto_controlador(){

            /*-- Comprobando privilegios - Checking privileges --*/
			if($_SESSION['cargo_sto']!="Administrador"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Acceso no permitido",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
			}

            /*-- Recuperando id del producto - Retrieving product id --*/
			$id=mainModel::decryption($_POST['producto_id']);
			$id=mainModel::limpiar_cadena($id);

			/*-- Comprobando producto en la DB - Checking product in DB --*/
            $check_producto=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE producto_id='$id'");
            if($check_producto->rowCount()<=0){
            	$alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos encontrado el producto registrado en el sistema.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
            }else{
            	$campos=$check_producto->fetch();
			}
			$check_producto->closeCursor();
			$check_producto=mainModel::desconectar($check_producto);

            /*-- Comprobando imagenes de galeria - Checking gallery images --*/
            $check_imagenes=mainModel::ejecutar_consulta_simple("SELECT imagen_id FROM imagen WHERE producto_id='$id'");
            if($check_imagenes->rowCount()>=7){
            	$alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"¡Limite excedido!",
                    "Texto"=>"No puedes agregar más imágenes a esta galería, solo se permiten 7 imágenes por cada producto.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
            }else{
                $correlativo=($check_imagenes->rowCount())+1;
            	$correlativo=$id."-".$correlativo;
			}
			$check_imagenes->closeCursor();
			$check_imagenes=mainModel::desconectar($check_imagenes);

            /*-- Comprobando si se ha seleccionado una imagen - Checking if an image has been selected --*/
            if($_FILES['producto_galeria']['name']=="" && $_FILES['producto_galeria']['size']<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"Parece que no ha seleccionado una imagen.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
			}

            /*-- Comprobando formato de las imagenes - Checking image format --*/
            if(mime_content_type($_FILES['producto_galeria']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['producto_galeria']['tmp_name'])!="image/png"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Formato no valido",
                    "Texto"=>"El FORMATO DE LA IMAGEN que acaba de seleccionar no está permitido.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

			/*-- Comprobando que la imagen no supere el peso permitido - Checking that the image does not exceed the allowed weight --*/
            $img_max_size=GALLERY_PRODUCT*1024;
            if(($_FILES['producto_galeria']['size']/1024)>$img_max_size){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Tamaño excedido",
                    "Texto"=>"El tamaño de la imagen supera el límite de peso máximo que son ".GALLERY_PRODUCT."MB.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Extencion de las imagenes - extension of the images --*/
            switch(mime_content_type($_FILES['producto_galeria']['tmp_name'])) {
                case 'image/jpeg':
                    $img_ext=".jpg";
                break;
                case 'image/png':
                    $img_ext=".png";
                break;
            }

            /*-- Nombre final de la imagen - Final image name --*/
            $codigo_img=mainModel::generar_codigo_aleatorio(10,$correlativo);
            $img_galeria=$codigo_img.$img_ext;

			/*-- Directorios de imagenes - Image Directories --*/
			$img_dir='../vistas/assets/product/gallery/';

            /*-- Cambiando permisos al directorio - Changing permissions to the directory --*/
            chmod($img_dir, 0777);

			/* Moviendo imagen al directorio - Moving image to directory */
            if(!move_uploaded_file($_FILES['producto_galeria']['tmp_name'], $img_dir.$img_galeria)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Error al cargar archivos",
                    "Texto"=>"No podemos subir la imagen al sistema en este momento, por favor intente nuevamente.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Preparando datos para enviarlos al modelo - Preparing data to send to the model --*/
			$datos_galeria_reg=[
				"imagen_nombre"=>[
					"campo_marcador"=>":Imagen",
					"campo_valor"=>$img_galeria
                ],
                "producto_id"=>[
					"campo_marcador"=>":Producto",
					"campo_valor"=>$id
				]
			];

            /*-- Guardando datos de la imagen - Saving image data --*/
			$agregar_galeria=mainModel::guardar_datos("imagen",$datos_galeria_reg);

			if($agregar_galeria->rowCount()==1){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"¡Imagen agregada!",
                    "Texto"=>"La imagen del producto se agregó con éxito a la galería.",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];
			}else{

				if(is_file($img_dir.$img_galeria)){
					chmod($img_dir, 0777);
					unlink($img_dir.$img_galeria);
				}

                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido agregar la imagen, por favor intente nuevamente",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
			}
			echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/


        /*---------- Controlador eliminar galeria de producto - Controller delete product gallery ----------*/
		public function eliminar_galeria_producto_controlador(){

            /*-- Comprobando privilegios - Checking privileges --*/
			if($_SESSION['cargo_sto']!="Administrador"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Acceso no permitido",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
			}

            /*-- Recuperando id del producto - Retrieving product id --*/
			$id=mainModel::decryption($_POST['producto_id']);
			$id=mainModel::limpiar_cadena($id);

			/*-- Comprobando producto en la DB - Checking product in DB --*/
            $check_producto=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE producto_id='$id'");
            if($check_producto->rowCount()<=0){
            	$alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos encontrado el producto registrado en el sistema.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
            }
			$check_producto->closeCursor();
			$check_producto=mainModel::desconectar($check_producto);

            /*-- Recuperando id de imagen - Retrieving picture id --*/
			$id_img=mainModel::decryption($_POST['imagen_id']);
			$id_img=mainModel::limpiar_cadena($id_img);

            /*-- Comprobando imagen en la DB - Checking picture in DB --*/
            $check_imagen=mainModel::ejecutar_consulta_simple("SELECT * FROM imagen WHERE producto_id='$id' AND imagen_id='$id_img'");
            if($check_imagen->rowCount()<=0){
            	$alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos encontrado la imagen del producto en el sistema.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
            }else{
            	$campos=$check_imagen->fetch();
			}
			$check_imagen->closeCursor();
			$check_imagen=mainModel::desconectar($check_imagen);

            /*-- Directorios de imagenes - Image Directories --*/
			$img_dir='../vistas/assets/product/gallery/';

            /* Eliminando la imagen - Deleting the image */
			if(is_file($img_dir.$campos['imagen_nombre'])){
				chmod($img_dir, 0777);
				if(!unlink($img_dir.$campos['imagen_nombre'])){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"No hemos podido eliminar la imagen del producto, por favor intente nuevamente.",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
					echo json_encode($alerta);
					exit();
				}
			}

            /*-- Eliminando imagen en DB - Deleting image in DB --*/
			$eliminar_imagen=mainModel::eliminar_registro("imagen","imagen_id",$id_img);

			if($eliminar_imagen->rowCount()==1){
				$alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"¡Imagen eliminada!",
                    "Texto"=>"La imagen ha sido eliminada del sistema exitosamente",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];
			}else{
				$alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido eliminar la imagen del sistema, por favor intente nuevamente",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
			}

			$eliminar_imagen->closeCursor();
			$eliminar_imagen=mainModel::desconectar($eliminar_imagen);

			echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador eliminar producto - Controller delete product ---------*/
        public function eliminar_producto_controlador(){

            /*-- Comprobando privilegios - Checking privileges --*/
			if($_SESSION['cargo_sto']!="Administrador"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Acceso no permitido",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
			}

            /*-- Recuperando id del producto - Retrieving product id - --*/
			$id=mainModel::decryption($_POST['producto_id_del']);
			$id=mainModel::limpiar_cadena($id);

            /*-- Comprobando producto en la BD - Checking producto in DB --*/
			$check_producto=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE producto_id='$id'");
			if($check_producto->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Producto no encontrado",
					"Texto"=>"El producto que intenta eliminar no existe en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}else{
            	$campos=$check_producto->fetch();
			}
			$check_producto->closeCursor();
			$check_producto=mainModel::desconectar($check_producto);

            /*-- Comprobando ventas - Checking sales --*/
			$check_ventas=mainModel::ejecutar_consulta_simple("SELECT producto_id FROM venta_detalle WHERE producto_id='$id' LIMIT 1");
			if($check_ventas->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos eliminar el producto debido a que tiene ventas asociadas, recomendamos deshabilitar este producto si ya no será usado en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_ventas->closeCursor();
			$check_ventas=mainModel::desconectar($check_ventas);

			/* Eliminando la portada - Deleting cover */
			if(is_file('../vistas/assets/product/cover/'.$campos['producto_portada'])){
				chmod('../vistas/assets/product/cover/', 0777);
				if(!unlink('../vistas/assets/product/cover/'.$campos['producto_portada'])){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"No hemos podido eliminar la portada del producto, por favor intente nuevamente.",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
					echo json_encode($alerta);
					exit();
				}
			}

            /*-- Comprobando galeria en la DB - Checking gallery in DB --*/
            $check_imagen=mainModel::ejecutar_consulta_simple("SELECT * FROM imagen WHERE producto_id='$id'");
            if($check_imagen->rowCount()>0){
                while($rows=$check_imagen->fetch()){

                    /*-- Eliminando imagen en DB - Deleting image in DB --*/
                    $eliminar_imagen=mainModel::eliminar_registro("imagen","imagen_id",$rows['imagen_id']);

                    if($eliminar_imagen->rowCount()==1){

                        /* Eliminando la imagen - Deleting the image */
                        if(is_file('../vistas/assets/product/gallery/'.$rows['imagen_nombre'])){
                            chmod('../vistas/assets/product/gallery/', 0777);
                            if(!unlink('../vistas/assets/product/gallery/'.$rows['imagen_nombre'])){
                                $alerta=[
                                    "Alerta"=>"simple",
                                    "Titulo"=>"Ocurrió un error inesperado",
                                    "Texto"=>"No hemos podido eliminar una de las imágenes del producto, por favor intente nuevamente.",
                                    "Icon"=>"error",
                                    "TxtBtn"=>"Aceptar"
                                ];
                                echo json_encode($alerta);
                                exit();
                            }
                        }
                    }else{
                        $alerta=[
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrió un error inesperado",
                            "Texto"=>"No hemos podido eliminar las imágenes de la galería, por favor intente nuevamente",
                            "Icon"=>"error",
                            "TxtBtn"=>"Aceptar"
                        ];
                    }
                    $eliminar_imagen->closeCursor();
                    $eliminar_imagen=mainModel::desconectar($eliminar_imagen);
                }
            }
			$check_imagen->closeCursor();
			$check_imagen=mainModel::desconectar($check_imagen);

            /*-- Eliminando producto - Deleting product --*/
			$eliminar_producto=mainModel::eliminar_registro("producto","producto_id",$id);

			if($eliminar_producto->rowCount()==1){
				$alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"¡Producto eliminado!",
                    "Texto"=>"El producto ha sido eliminado del sistema exitosamente",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];
			}else{
				$alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido eliminar el producto del sistema, por favor intente nuevamente",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
			}

			$eliminar_producto->closeCursor();
			$eliminar_producto=mainModel::desconectar($eliminar_producto);

			echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador actualizar producto - Controller update product ---------*/
        public function actualizar_producto_controlador(){

            /*-- Comprobando privilegios - Checking privileges --*/
			if($_SESSION['cargo_sto']!="Administrador"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Acceso no permitido",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
			}

            /*-- Recuperando id del producto - Retrieving product id - --*/
			$id=mainModel::decryption($_POST['producto_id_up']);
			$id=mainModel::limpiar_cadena($id);

            /*-- Comprobando producto en la BD - Checking producto in DB --*/
			$check_producto=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE producto_id='$id'");
			if($check_producto->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Producto no encontrado",
					"Texto"=>"El producto que intenta actualizar no existe en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}else{
            	$campos=$check_producto->fetch();
			}
			$check_producto->closeCursor();
			$check_producto=mainModel::desconectar($check_producto);

            /*-- Recibiendo datos del formulario - Receiving form data --*/
            $codigo=mainModel::limpiar_cadena($_POST['producto_codigo_up']);
            $sku=mainModel::limpiar_cadena($_POST['producto_sku_up']);

            $nombre=mainModel::limpiar_cadena($_POST['producto_nombre_up']);
            $precio_compra=mainModel::limpiar_cadena($_POST['producto_precio_compra_up']);
            $precio_venta=mainModel::limpiar_cadena($_POST['producto_precio_venta_up']);
            $stock_total=mainModel::limpiar_cadena($_POST['producto_stock_up']);
            $stock_minimo=mainModel::limpiar_cadena($_POST['producto_stock_minimo_up']);
            $descuento=mainModel::limpiar_cadena($_POST['producto_descuento_up']);
            $marca=mainModel::limpiar_cadena($_POST['producto_marca_up']);
            $modelo=mainModel::limpiar_cadena($_POST['producto_modelo_up']);

            $tipo=mainModel::limpiar_cadena($_POST['producto_tipo_up']);
            $presentacion=mainModel::limpiar_cadena($_POST['producto_presentacion_up']);
            $categoria=mainModel::limpiar_cadena($_POST['producto_categoria_up']);
            $estado=mainModel::limpiar_cadena($_POST['producto_estado_up']);

            $descripcion=mainModel::limpiar_cadena($_POST['producto_descripcion_up']);

            /*-- Comprobando campos vacios - Checking empty fields --*/
            if($codigo=="" || $nombre=="" || $precio_compra=="" || $precio_venta=="" || $stock_total=="" || $stock_minimo=="" || $descuento==""){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No has llenado todos los campos que son obligatorios",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Verificando integridad de los datos - Checking data integrity --*/
            if(mainModel::verificar_datos("[a-zA-Z0-9- ]{1,49}",$codigo)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El CÓDIGO DE BARRAS no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if($sku!=""){
                if(mainModel::verificar_datos("[a-zA-Z0-9- ]{1,49}",$sku)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Formato no valido",
                        "Texto"=>"El CÓDIGO SKU no coincide con el formato solicitado",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\- ]{1,97}",$nombre)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El NOMBRE no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9.]{1,25}",$precio_compra)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El PRECIO DE COMPRA no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9.]{1,25}",$precio_venta)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El PRECIO DE VENTA no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9]{1,9}",$stock_total)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El STOCK no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9]{1,9}",$stock_minimo)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El STOCK MÍNIMO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9]{1,2}",$descuento)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El DESCUENTO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if($marca!=""){
                if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,30}",$marca)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Formato no valido",
                        "Texto"=>"La MARCA no coincide con el formato solicitado",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if($modelo!=""){
                if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,40}",$modelo)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Formato no valido",
                        "Texto"=>"El MODELO no coincide con el formato solicitado",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if($descripcion!=""){
                if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\s ]{4,520}",$descripcion)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Formato no valido",
                        "Texto"=>"La DESCRIPCIÓN no coincide con el formato solicitado",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            /*-- Comprobando tipo - Checking type --*/
			if($tipo!="Fisico" && $tipo!="Digital"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Opción no valida",
					"Texto"=>"Ha seleccionado un TIPO de producto no valido",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Comprobando presentacion - Checking presentation ==*/
			if(!in_array($presentacion, PRODUTS_UNITS)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Opción no valida",
					"Texto"=>"Ha seleccionado una PRESENTACIÓN de producto no valida",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Comprobando estado - Checking status --*/
			if($estado!="Habilitado" && $estado!="Deshabilitado"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Opción no valida",
					"Texto"=>"Ha seleccionado un ESTADO de producto no valido",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Verificando stock total y minimo - Checking total and minimum stock --*/
            if($stock_total<$stock_minimo){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El STOCK MÍNIMO no puede ser mayor al STOCK O EXISTENCIAS totales.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Comprobando y formateando precios de producto - Checking and formatting product prices --*/
            $precio_compra=number_format($precio_compra,COIN_DECIMALS,'.','');
            $precio_venta=number_format($precio_venta,COIN_DECIMALS,'.','');

            if($precio_compra<=0){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El PRECIO DE COMPRA no puede ser menor o igual a 0.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if($precio_venta<=0){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El PRECIO DE VENTA no puede ser menor o igual a 0.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if($precio_compra>$precio_venta){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El PRECIO DE COMPRA del producto no puede ser mayor al PRECIO DE VENTA.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Comprobando categoria - Checking category --*/
            $check_categoria=mainModel::ejecutar_consulta_simple("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria' AND categoria_estado='Habilitada'");
            if($check_categoria->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"La CATEGORÍA que ha seleccionado no existe o se encuentra deshabilitada.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }
            $check_categoria->closeCursor();
            $check_categoria=mainModel::desconectar($check_categoria);

            /*-- Comprobando codigo de barras - Checking barcode --*/
            if($campos['producto_codigo']!=$codigo){
                $check_codigo=mainModel::ejecutar_consulta_simple("SELECT producto_codigo FROM producto WHERE producto_codigo='$codigo'");
                if($check_codigo->rowCount()>0){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El CÓDIGO DE BARRAS de producto que ha ingresado ya se encuentra registrado en el sistema.",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                $check_codigo->closeCursor();
                $check_codigo=mainModel::desconectar($check_codigo);
            }

            /*-- Comprobando codigo SKU - Checking SKU --*/
            if($sku!="" && $campos['producto_sku']!=$sku){
                $check_sku=mainModel::ejecutar_consulta_simple("SELECT producto_sku FROM producto WHERE producto_sku='$sku'");
                if($check_sku->rowCount()>0){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El CÓDIGO SKU de producto que ha ingresado ya se encuentra registrado en el sistema.",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                $check_sku->closeCursor();
                $check_sku=mainModel::desconectar($check_sku);
            }

            /*-- Comprobando nombre - Checking name --*/
            if($campos['producto_nombre']!=$nombre){
                $check_nombre=mainModel::ejecutar_consulta_simple("SELECT producto_nombre FROM producto WHERE producto_codigo='$codigo' AND producto_nombre='$nombre'");
                if($check_nombre->rowCount()>0){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"Ya existe un producto registrado con el mismo NOMBRE y CÓDIGO DE BARRAS.",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                $check_nombre->closeCursor();
                $check_nombre=mainModel::desconectar($check_nombre);
            }

            /*-- Preparando datos para enviarlos al modelo - Preparing data to send to the model --*/
            $datos_producto_up=[
                "producto_codigo"=>[
					"campo_marcador"=>":Codigo",
					"campo_valor"=>$codigo
				],
                "producto_sku"=>[
					"campo_marcador"=>":Sku",
					"campo_valor"=>$sku
				],
                "producto_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
                "producto_descripcion"=>[
					"campo_marcador"=>":Descripcion",
					"campo_valor"=>$descripcion
				],
                "producto_stock"=>[
					"campo_marcador"=>":StockT",
					"campo_valor"=>$stock_total
				],
                "producto_stock_minimo"=>[
					"campo_marcador"=>":StockM",
					"campo_valor"=>$stock_minimo
				],
                "producto_precio_compra"=>[
					"campo_marcador"=>":PrecioC",
					"campo_valor"=>$precio_compra
				],
                "producto_precio_venta"=>[
					"campo_marcador"=>":PrecioV",
					"campo_valor"=>$precio_venta
				],
                "producto_descuento"=>[
					"campo_marcador"=>":Descuento",
					"campo_valor"=>$descuento
				],
                "producto_tipo"=>[
					"campo_marcador"=>":Tipo",
					"campo_valor"=>$tipo
				],
                "producto_presentacion"=>[
					"campo_marcador"=>":Presentacion",
					"campo_valor"=>$presentacion
				],
                "producto_marca"=>[
					"campo_marcador"=>":Marca",
					"campo_valor"=>$marca
				],
                "producto_modelo"=>[
					"campo_marcador"=>":Modelo",
					"campo_valor"=>$modelo
				],
                "producto_estado"=>[
					"campo_marcador"=>":Estado",
					"campo_valor"=>$estado
				],
                "categoria_id"=>[
					"campo_marcador"=>":Categoria",
					"campo_valor"=>$categoria
				]
            ];

            $condicion=[
				"condicion_campo"=>"producto_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

            if(mainModel::actualizar_datos("producto",$datos_producto_up,$condicion)){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Producto actualizado!",
					"Texto"=>"Los datos del producto se actualizaron con éxito en el sistema",
					"Icon"=>"success",
					"TxtBtn"=>"Aceptar"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido actualizar los datos del producto, por favor intente nuevamente",
					"Icon"=>"error",
					"TxtBtn"=>"Aceptar"
				];
			}
			echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/
    }