<?php

    if($peticion_ajax){
        require_once "../modelos/mainModel.php";
    }else{
        require_once "./modelos/mainModel.php";
    }

	class empresaControlador extends mainModel{

        /*--------- Controlador registrar empresa - Controller register company ---------*/
        public function registrar_empresa_controlador(){

            /*-- Recibiendo datos del formulario - Receiving form data --*/
            $tipo_documento=mainModel::limpiar_cadena($_POST['empresa_tipo_documento_reg']);
            $numero_documento=mainModel::limpiar_cadena($_POST['empresa_numero_documento_reg']);
            $nombre=mainModel::limpiar_cadena($_POST['empresa_nombre_reg']);
            $telefono=mainModel::limpiar_cadena($_POST['empresa_telefono_reg']);
            $email=mainModel::limpiar_cadena($_POST['empresa_email_reg']);
            $direccion=mainModel::limpiar_cadena($_POST['empresa_direccion_reg']);

            $nombre_impuesto=mainModel::limpiar_cadena($_POST['empresa_impuesto_nombre_reg']);
            $porcentaje_impuesto=mainModel::limpiar_cadena($_POST['empresa_impuesto_porcentaje_reg']);
            $impuestos_facturas=mainModel::limpiar_cadena($_POST['empresa_impuesto_factura_reg']);

            /*-- Comprobando campos vacios - Checking empty fields --*/
            if($tipo_documento=="" || $numero_documento=="" || $nombre=="" || $nombre_impuesto=="" || $porcentaje_impuesto=="" || $impuestos_facturas==""){
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
            if(mainModel::verificar_datos("[a-zA-Z0-9-]{4,30}",$numero_documento)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El NÚMERO DE DOCUMENTO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ., ]{3,80}",$nombre)){
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

            if($telefono!=""){
                if(mainModel::verificar_datos("[0-9()+]{8,20}",$telefono)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Formato no valido",
                        "Texto"=>"El TELÉFONO no coincide con el formato solicitado",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if($direccion!=""){
                if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,97}",$direccion)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Formato no valido",
                        "Texto"=>"La DIRECCIÓN no coincide con el formato solicitado",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if(mainModel::verificar_datos("[a-zA-Z]{2,7}",$nombre_impuesto)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El NOMBRE DE IMPUESTO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9]{1,2}",$porcentaje_impuesto)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El PORCENTAJE DE IMPUESTO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Comprobando tipo de documento - Checking document type --*/
            if(!in_array($tipo_documento, DOCUMENTS_COMPANY)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El TIPO DE DOCUMENTO no es correcto",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}

            /*-- Comprobando email - Checking email --*/
            if($email!=""){
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Formato no valido",
                        "Texto"=>"Ha ingresado un EMAIL no valido",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            /*-- Comprobando impuestos de facturas - Checking invoice taxes --*/
			if($impuestos_facturas!="Si" && $impuestos_facturas!="No"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Opción no valida",
					"Texto"=>"Ha seleccionado valor no valido en MOSTRAR IMPUESTOS de facturas",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Comprobando empresas en la DB - Checking company in DB --*/
            $check_empresa=mainModel::ejecutar_consulta_simple("SELECT empresa_id FROM empresa");
            if($check_empresa->rowCount()>=1){
            	$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Ya existe una empresa registrada, por favor actualice la pagina.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_empresa->closeCursor();
			$check_empresa=mainModel::desconectar($check_empresa);

            /*-- Preparando datos para enviarlos al modelo - Preparing data to send to the model --*/
			$datos_empresa_reg=[
                "empresa_tipo_documento"=>[
					"campo_marcador"=>":Tipo",
					"campo_valor"=>$tipo_documento
				],
                "empresa_numero_documento"=>[
					"campo_marcador"=>":Numero",
					"campo_valor"=>$numero_documento
				],
                "empresa_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
                "empresa_telefono"=>[
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
				],
                "empresa_email"=>[
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
                "empresa_direccion"=>[
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$direccion
				],
                "empresa_impuesto_nombre"=>[
					"campo_marcador"=>":Impuesto",
					"campo_valor"=>$nombre_impuesto
				],
                "empresa_impuesto_porcentaje"=>[
					"campo_marcador"=>":Porcentaje",
					"campo_valor"=>$porcentaje_impuesto
				],
                "empresa_factura_impuestos"=>[
					"campo_marcador"=>":Factura",
					"campo_valor"=>$impuestos_facturas
				]
            ];

            /*-- Guardando datos de la empresa - Saving company data --*/
			$agregar_empresa=mainModel::guardar_datos("empresa",$datos_empresa_reg);

			if($agregar_empresa->rowCount()==1){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"¡Empresa registrada!",
                    "Texto"=>"Los datos de la empresa se registraron con éxito",
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

			$agregar_empresa->closeCursor();
			$agregar_empresa=mainModel::desconectar($agregar_empresa);

			echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador actualizar empresa - Controller update company ---------*/
		public function actualizar_empresa_controlador(){

            /*-- Recuperando id de la empresa - Retrieving company id --*/
            $id=mainModel::decryption($_POST['empresa_id_up']);
			$id=mainModel::limpiar_cadena($id);

            /*-- Comprobando empresa en la DB - Checking company in DB --*/
            $check_empresa=mainModel::ejecutar_consulta_simple("SELECT * FROM empresa WHERE empresa_id='$id'");
            if($check_empresa->rowCount()<=0){
            	$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos encontrado la empresa en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_empresa->closeCursor();
			$check_empresa=mainModel::desconectar($check_empresa);

            /*-- Recibiendo datos del formulario - Receiving form data --*/
            $tipo_documento=mainModel::limpiar_cadena($_POST['empresa_tipo_documento_up']);
            $numero_documento=mainModel::limpiar_cadena($_POST['empresa_numero_documento_up']);
            $nombre=mainModel::limpiar_cadena($_POST['empresa_nombre_up']);
            $telefono=mainModel::limpiar_cadena($_POST['empresa_telefono_up']);
            $email=mainModel::limpiar_cadena($_POST['empresa_email_up']);
            $direccion=mainModel::limpiar_cadena($_POST['empresa_direccion_up']);

            $nombre_impuesto=mainModel::limpiar_cadena($_POST['empresa_impuesto_nombre_up']);
            $porcentaje_impuesto=mainModel::limpiar_cadena($_POST['empresa_impuesto_porcentaje_up']);
            $impuestos_facturas=mainModel::limpiar_cadena($_POST['empresa_impuesto_factura_up']);

            /*-- Comprobando campos vacios - Checking empty fields --*/
            if($tipo_documento=="" || $numero_documento=="" || $nombre=="" || $nombre_impuesto=="" || $porcentaje_impuesto=="" || $impuestos_facturas==""){
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
            if(mainModel::verificar_datos("[a-zA-Z0-9-]{4,30}",$numero_documento)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El NÚMERO DE DOCUMENTO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ., ]{3,80}",$nombre)){
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

            if($telefono!=""){
                if(mainModel::verificar_datos("[0-9()+]{8,20}",$telefono)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Formato no valido",
                        "Texto"=>"El TELÉFONO no coincide con el formato solicitado",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if($direccion!=""){
                if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,97}",$direccion)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Formato no valido",
                        "Texto"=>"La DIRECCIÓN no coincide con el formato solicitado",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if(mainModel::verificar_datos("[a-zA-Z]{2,7}",$nombre_impuesto)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El NOMBRE DE IMPUESTO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9]{1,2}",$porcentaje_impuesto)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El PORCENTAJE DE IMPUESTO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Comprobando tipo de documento - Checking document type --*/
            if(!in_array($tipo_documento, DOCUMENTS_COMPANY)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El TIPO DE DOCUMENTO no es correcto",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}

            /*-- Comprobando email - Checking email --*/
            if($email!=""){
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Formato no valido",
                        "Texto"=>"Ha ingresado un EMAIL no valido",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            /*-- Comprobando impuestos de facturas - Checking invoice taxes --*/
			if($impuestos_facturas!="Si" && $impuestos_facturas!="No"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Opción no valida",
					"Texto"=>"Ha seleccionado valor no valido en MOSTRAR IMPUESTOS de facturas",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Preparando datos para enviarlos al modelo - Preparing data to send to the model --*/
			$datos_empresa_up=[
                "empresa_tipo_documento"=>[
					"campo_marcador"=>":Tipo",
					"campo_valor"=>$tipo_documento
				],
                "empresa_numero_documento"=>[
					"campo_marcador"=>":Numero",
					"campo_valor"=>$numero_documento
				],
                "empresa_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
                "empresa_telefono"=>[
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
				],
                "empresa_email"=>[
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
                "empresa_direccion"=>[
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$direccion
				],
                "empresa_impuesto_nombre"=>[
					"campo_marcador"=>":Impuesto",
					"campo_valor"=>$nombre_impuesto
				],
                "empresa_impuesto_porcentaje"=>[
					"campo_marcador"=>":Porcentaje",
					"campo_valor"=>$porcentaje_impuesto
				],
                "empresa_factura_impuestos"=>[
					"campo_marcador"=>":Factura",
					"campo_valor"=>$impuestos_facturas
				]
            ];

            $condicion=[
				"condicion_campo"=>"empresa_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

            if(mainModel::actualizar_datos("empresa",$datos_empresa_up,$condicion)){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Empresa actualizada!",
					"Texto"=>"Los datos de la empresa se actualizaron con éxito en el sistema",
					"Icon"=>"success",
					"TxtBtn"=>"Aceptar"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido actualizar los datos, por favor intente nuevamente",
					"Icon"=>"error",
					"TxtBtn"=>"Aceptar"
				];
			}
			echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/
    }