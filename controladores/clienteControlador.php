<?php

    if($peticion_ajax){
        require_once "../modelos/mainModel.php";
    }else{
        require_once "./modelos/mainModel.php";
    }

	class clienteControlador extends mainModel{

        /*--------- Controlador registrar cliente - Controller register client ---------*/
        public function registrar_cliente_controlador(){

            /*-- Comprobando privilegios - Checking privileges --*/
            if(isset($_SESSION['cargo_sto']) && ($_SESSION['cargo_sto']=="Administrador" || $_SESSION['cargo_sto']=="Cajero")){
                $estado=mainModel::limpiar_cadena($_POST['cliente_estado_reg']);
                $verificacion=mainModel::limpiar_cadena($_POST['cliente_verificacion_reg']);
            }else{
                $estado="Activa";
                $verificacion="No verificada";
            }

            /*-- Recibiendo datos del formulario - Receiving form data --*/
            $nombre=mainModel::limpiar_cadena($_POST['cliente_nombre_reg']);
            $apellido=mainModel::limpiar_cadena($_POST['cliente_apellido_reg']);
            $telefono=mainModel::limpiar_cadena($_POST['cliente_telefono_reg']);
            $genero=mainModel::limpiar_cadena($_POST['cliente_genero_reg']);

            $provincia=mainModel::limpiar_cadena($_POST['cliente_provincia_reg']);
            $ciudad=mainModel::limpiar_cadena($_POST['cliente_ciudad_reg']);
            $direccion=mainModel::limpiar_cadena($_POST['cliente_direccion_reg']);

            $email=mainModel::limpiar_cadena($_POST['cliente_email_reg']);
            $clave_1=mainModel::limpiar_cadena($_POST['cliente_clave_1_reg']);
            $clave_2=mainModel::limpiar_cadena($_POST['cliente_clave_2_reg']);

            $avatar=mainModel::limpiar_cadena($_POST['cliente_avatar_reg']);

            /*-- Comprobando campos vacios - Checking empty fields --*/
            if($nombre=="" || $apellido=="" || $telefono=="" || $genero=="" || $provincia=="" || $ciudad=="" || $direccion=="" || $email=="" || $clave_1=="" || $clave_2==""){
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
            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}",$nombre)){
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

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}",$apellido)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El APELLIDO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

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

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,29}",$provincia)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Formato no valido",
                    "Texto"=>"ESTADO, PROVINCIA O DEPARTAMENTO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,29}",$ciudad)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Formato no valido",
                    "Texto"=>"CIUDAD o PUEBLO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,70}",$direccion)){
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

            if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_1) || mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_2)){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"Las CONTRASEÑAS no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Comprobando genero - Checking gender --*/
			if($genero!="Masculino" && $genero!="Femenino"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Opción no valida",
					"Texto"=>"Ha seleccionado un GÉNERO no valido",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Comprobando email - Checking email --*/
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $check_email=mainModel::ejecutar_consulta_simple("SELECT cliente_email FROM cliente WHERE cliente_email='$email'");
                if($check_email->rowCount()>0){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El EMAIL ingresado ya se encuentra registrado",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                $check_email->closeCursor();
                $check_email=mainModel::desconectar($check_email);
            }else{
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

            /*-- Comprobando claves - Checking passwords --*/
			if($clave_1!=$clave_2){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"Las contraseñas que acaba de ingresar no coinciden",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
			}else{
				$clave=mainModel::encryption($clave_1);
            }

            /*-- Comprobando estado de cuenta - Checking account status --*/
			if($estado!="Activa" && $estado!="Deshabilitada"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Opción no valida",
					"Texto"=>"Ha seleccionado un ESTADO DE CUENTA no valido",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Comprobando verificacion de cuenta - Checking account verification --*/
			if($verificacion!="Verificada" && $verificacion!="No verificada"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Opción no valida",
					"Texto"=>"Ha seleccionado un valor de VERIFICACION DE CUENTA no valido",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Comprobando foto o avatar - Checking photo or avatar --*/
            if(!is_file("../vistas/assets/avatar/".$avatar)){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos encontrado el avatar en el sistema, por favor seleccione otro e intente nuevamente",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }


            /*-- Preparando datos para enviarlos al modelo - Preparing data to send to the model --*/
			$datos_cliente_reg=[
				"cliente_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				"cliente_apellido"=>[
					"campo_marcador"=>":Apellido",
					"campo_valor"=>$apellido
                ],
				"cliente_genero"=>[
					"campo_marcador"=>":Genero",
					"campo_valor"=>$genero
                ],
                "cliente_telefono"=>[
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
				],
                "cliente_provincia"=>[
					"campo_marcador"=>":Provincia",
					"campo_valor"=>$provincia
                ],
                "cliente_ciudad"=>[
					"campo_marcador"=>":Ciudad",
					"campo_valor"=>$ciudad
				],
                "cliente_direccion"=>[
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$direccion
				],
				"cliente_email"=>[
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				"cliente_clave"=>[
					"campo_marcador"=>":Clave",
					"campo_valor"=>$clave
				],
				"cliente_foto"=>[
					"campo_marcador"=>":Foto",
					"campo_valor"=>$avatar
				],
				"cliente_cuenta_estado"=>[
					"campo_marcador"=>":Estado",
					"campo_valor"=>$estado
				],
				"cliente_cuenta_verificada"=>[
					"campo_marcador"=>":Verificacion",
					"campo_valor"=>$verificacion
				]
			];

            /*-- Guardando datos del cliente - Saving client data --*/
			$agregar_cliente=mainModel::guardar_datos("cliente",$datos_cliente_reg);

			if($agregar_cliente->rowCount()==1){
                $alerta=[
                    "Alerta"=>"limpiar",
                    "Titulo"=>"¡Cliente registrado!",
                    "Texto"=>"Los datos del cliente se registraron con éxito",
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

			$agregar_cliente->closeCursor();
			$agregar_cliente=mainModel::desconectar($agregar_cliente);

			echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador paginador clientes - Clients Pager Controller ---------*/
        public function paginador_cliente_controlador($pagina,$registros,$url,$busqueda){
            $pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);

			$url=mainModel::limpiar_cadena($url);
			$url=SERVERURL.DASHBOARD."/".$url."/";

            $busqueda=mainModel::limpiar_cadena($busqueda);
            $id=1;
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
            $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
            
            if(isset($busqueda) && $busqueda!=""){
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cliente WHERE (cliente_nombre LIKE '%$busqueda%' OR cliente_apellido LIKE '%$busqueda%' OR cliente_email LIKE '%$busqueda%' OR cliente_provincia LIKE '%$busqueda%' OR cliente_ciudad LIKE '%$busqueda%') ORDER BY cliente_nombre ASC LIMIT $inicio,$registros";
			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cliente ORDER BY cliente_nombre ASC LIMIT $inicio,$registros";
			}

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);

			$datos = $datos->fetchAll();

			$total = $conexion->query("SELECT FOUND_ROWS()");
			$total = (int) $total->fetchColumn();

            $Npaginas =ceil($total/$registros);
            
            /*-- Encabezado de la tabla - Table header --*/
			$tabla.='
            <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr class="text-center font-weight-bold">
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Actualizar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
            ';

            if($total>=1 && $pagina<=$Npaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($datos as $rows){
					$tabla.='
						<tr class="text-center" >
							<td>'.$contador.'</td>
							<td>'.$rows['cliente_nombre'].' '.$rows['cliente_apellido'].'</td>
							<td>'.$rows['cliente_email'].'</td>
							<td>'.$rows['cliente_telefono'].'</td>
							<td><a class="btn btn-link text-success" href="'.SERVERURL.DASHBOARD.'/client-update/'.mainModel::encryption($rows['cliente_id']).'/"><i class="fas fa-sync-alt"></i></a></td>
							<td>
                                <form class="FormularioAjax" action="'.SERVERURL.'ajax/clienteAjax.php" method="POST" data-form="delete" data-lang="'.LANG.'" >
                                    <input type="hidden" name="modulo_cliente" value="eliminar">
									<input type="hidden" name="cliente_id_del" value="'.mainModel::encryption($rows['cliente_id']).'">
									<button type="submit" class="btn btn-link text-danger"><i class="far fa-trash-alt"></i></button>
								</form>
							</td>
						</tr>
					';
					$contador++;
				}
				$pag_final=$contador-1;
			}else{
				if($total>=1){
					$tabla.='
						<tr class="text-center" >
							<td colspan="7">
								<a href="'.$url.'" class="btn btn-primary btn-sm">
									Haga clic acá para recargar el listado
								</a>
							</td>
						</tr>
					';
				}else{
					$tabla.='
						<tr class="text-center" >
							<td colspan="7">
								No hay registros en el sistema
							</td>
						</tr>
					';
				}
			}

            $tabla.='</tbody></table></div>';

			if($total>0 && $pagina<=$Npaginas){
				$tabla.='<p class="text-end">Mostrando clientes <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
			}

			/*--Paginacion - Pagination --*/
			if($total>=1 && $pagina<=$Npaginas){
				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7,LANG);
			}

			return $tabla;
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador eliminar cliente - Controller delete client ---------*/
        public function eliminar_cliente_controlador(){

            /*-- Comprobando privilegios - Checking privileges --*/
			if($_SESSION['cargo_sto']!="Administrador" && $_SESSION['cargo_sto']!="Cajero"){
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

            /*-- Recuperando id del cliente - Retrieving client id - --*/
			$id=mainModel::decryption($_POST['cliente_id_del']);
			$id=mainModel::limpiar_cadena($id);

            /*-- Comprobando cliente en la BD - Checking client in DB --*/
			$check_cliente=mainModel::ejecutar_consulta_simple("SELECT cliente_id FROM cliente WHERE cliente_id='$id'");
			if($check_cliente->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Cliente no encontrado",
					"Texto"=>"El cliente que intenta eliminar no existe en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_cliente->closeCursor();
			$check_cliente=mainModel::desconectar($check_cliente);

            /*-- Comprobando ventas - Checking sales --*/
			$check_ventas=mainModel::ejecutar_consulta_simple("SELECT cliente_id FROM venta WHERE cliente_id='$id' LIMIT 1");
			if($check_ventas->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos eliminar el cliente debido a que tiene ventas asociadas, recomendamos deshabilitar este cliente si ya no será usado en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_ventas->closeCursor();
			$check_ventas=mainModel::desconectar($check_ventas);

            /*-- Eliminando cliente - Deleting client --*/
			$eliminar_cliente=mainModel::eliminar_registro("cliente","cliente_id",$id);

			if($eliminar_cliente->rowCount()==1){
				$alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"¡Cliente eliminado!",
                    "Texto"=>"El cliente ha sido eliminado del sistema exitosamente",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];
			}else{
				$alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido eliminar el cliente del sistema, por favor intente nuevamente",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
			}

			$eliminar_cliente->closeCursor();
			$eliminar_cliente=mainModel::desconectar($eliminar_cliente);

			echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador actualizar cliente - Controller update client ---------*/
		public function actualizar_cliente_controlador(){

            /*-- Recibiendo id del cliente - Receiving client id --*/
			$id=mainModel::decryption($_POST['cliente_id_up']);
			$id=mainModel::limpiar_cadena($id);

            /*-- Comprobando cliente en la DB - Checking client in DB --*/
			$check_cliente=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_id='$id'");
			if($check_cliente->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Cuenta no encontrada",
					"Texto"=>"No hemos encontrado la cuenta en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}else{
				$campos=$check_cliente->fetch();
			}
			$check_cliente->closeCursor();
			$check_cliente=mainModel::desconectar($check_cliente);

            /*-- Comprobando privilegios - Checking privileges --*/
            if(isset($_SESSION['cargo_sto']) && ($_SESSION['cargo_sto']=="Administrador" || $_SESSION['cargo_sto']=="Cajero")){    
                $estado=mainModel::limpiar_cadena($_POST['cliente_estado_up']);
                $verificacion=mainModel::limpiar_cadena($_POST['cliente_verificacion_up']);
            }else{ 
                if($_SESSION['cliente_id_sto']!=$id){
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
                $estado=$campos['cliente_cuenta_estado'];
                $verificacion=$campos['cliente_cuenta_verificada'];
            }

            /*-- Recibiendo datos del formulario - Receiving form data --*/
            $nombre=mainModel::limpiar_cadena($_POST['cliente_nombre_up']);
            $apellido=mainModel::limpiar_cadena($_POST['cliente_apellido_up']);
            $telefono=mainModel::limpiar_cadena($_POST['cliente_telefono_up']);
            $genero=mainModel::limpiar_cadena($_POST['cliente_genero_up']);

            $provincia=mainModel::limpiar_cadena($_POST['cliente_provincia_up']);
            $ciudad=mainModel::limpiar_cadena($_POST['cliente_ciudad_up']);
            $direccion=mainModel::limpiar_cadena($_POST['cliente_direccion_up']);

            $email=mainModel::limpiar_cadena($_POST['cliente_email_up']);
            $clave_1=mainModel::limpiar_cadena($_POST['cliente_clave_1_up']);
            $clave_2=mainModel::limpiar_cadena($_POST['cliente_clave_2_up']);

            $avatar=mainModel::limpiar_cadena($_POST['cliente_avatar_up']);

            $usuario_usuario=mainModel::limpiar_cadena($_POST['usuario_usuario_up']);
			$usuario_clave=mainModel::limpiar_cadena($_POST['usuario_clave_up']);

            /*-- Comprobando campos vacios - Checking empty fields --*/
            if($nombre=="" || $apellido=="" || $telefono=="" || $genero=="" || $provincia=="" || $ciudad=="" || $direccion=="" || $email=="" || $usuario_usuario=="" || $usuario_clave==""){
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
            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}",$nombre)){
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

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}",$apellido)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El APELLIDO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

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

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,29}",$provincia)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Formato no valido",
                    "Texto"=>"ESTADO, PROVINCIA O DEPARTAMENTO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,29}",$ciudad)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Formato no valido",
                    "Texto"=>"CIUDAD o PUEBLO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,70}",$direccion)){
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

            if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$usuario_clave)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"La CONTRASEÑA de TU CUENTA no coincide con el formato solicitado",
					"Icon"=>"error",
					"TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}

            $usuario_clave=mainModel::encryption($usuario_clave);

            /*-- Comprobando genero - Checking gender --*/
			if($genero!="Masculino" && $genero!="Femenino"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Opción no valida",
					"Texto"=>"Ha seleccionado un GÉNERO no valido",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Comprobando estado de cuenta - Checking account status --*/
			if($estado!="Activa" && $estado!="Deshabilitada"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Opción no valida",
					"Texto"=>"Ha seleccionado un ESTADO DE CUENTA no valido",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Comprobando verificacion de cuenta - Checking account verification --*/
			if($verificacion!="Verificada" && $verificacion!="No verificada"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Opción no valida",
					"Texto"=>"Ha seleccionado un valor de VERIFICACION DE CUENTA no valido",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Comprobando foto o avatar - Checking photo or avatar --*/
            if(!is_file("../vistas/assets/avatar/".$avatar)){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos encontrado el avatar en el sistema, por favor seleccione otro e intente nuevamente",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
            }

            /*-- Comprobando email - Checking email --*/
            if($email!=$campos['cliente_email']){
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $check_email=mainModel::ejecutar_consulta_simple("SELECT cliente_email FROM cliente WHERE cliente_email='$email'");
                    if($check_email->rowCount()>0){
                        $alerta=[
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrió un error inesperado",
                            "Texto"=>"El EMAIL ingresado ya se encuentra registrado",
                            "Icon"=>"error",
                            "TxtBtn"=>"Aceptar"
                        ];
                        echo json_encode($alerta);
                        exit();
                    }
                    $check_email->closeCursor();
                    $check_email=mainModel::desconectar($check_email);
                }else{
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


            /*-- Comprobando contraseñas - Checking passwords --*/
			if($clave_1!="" || $clave_2!=""){

				if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_1) || mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_2)){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Formato no valido",
						"Texto"=>"Las NUEVAS CONTRASEÑAS no coincide con el formato solicitado",
						"Icon"=>"error",
						"TxtBtn"=>"Aceptar"
					];
					echo json_encode($alerta);
					exit();
				}else{
					if($clave_1!=$clave_2){
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"Las NUEVAS CONTRASEÑAS que acaba de ingresar no coinciden",
							"Icon"=>"error",
							"TxtBtn"=>"Aceptar"
						];
						echo json_encode($alerta);
						exit();
					}else{
						$clave=mainModel::encryption($clave_1);
					}
				}
			}else{
				$clave=$campos['cliente_clave'];
			}


            /*-- Comprobando credenciales para actualizar datos - Checking credentials to update data --*/
            if(isset($_SESSION['cargo_sto']) && ($_SESSION['cargo_sto']=="Administrador" || $_SESSION['cargo_sto']=="Cajero")){
                if(mainModel::verificar_datos("[a-zA-Z0-9]{4,30}",$usuario_usuario)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Formato no valido",
                        "Texto"=>"El USUARIO de TU CUENTA no coincide con el formato solicitado",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }

                $check_cuenta=mainModel::ejecutar_consulta_simple("SELECT usuario_id FROM usuario WHERE usuario_usuario='$usuario_usuario' AND usuario_clave='$usuario_clave' AND usuario_cuenta_estado='Activa'");
            }else{
                if(!filter_var($usuario_usuario, FILTER_VALIDATE_EMAIL)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Formato no valido",
                        "Texto"=>"El EMAIL de TU CUENTA no coincide con el formato solicitado",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }

                $check_cuenta=mainModel::ejecutar_consulta_simple("SELECT cliente_id FROM cliente WHERE cliente_email='$usuario_usuario' AND cliente_clave='$usuario_clave' AND cliente_id='$id' AND cliente_cuenta_estado='Activa'");
            }

            if($check_cuenta->rowCount()!=1){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Datos incorrectos",
					"Texto"=>"Las credenciales que acaba de ingresar no coinciden con las de su cuenta actual",
					"Icon"=>"error",
					"TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_cuenta->closeCursor();
			$check_cuenta=mainModel::desconectar($check_cuenta);
            

            /*-- Preparando datos para enviarlos al modelo - Preparing data to send to the model --*/
			$datos_cliente_up=[
				"cliente_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				"cliente_apellido"=>[
					"campo_marcador"=>":Apellido",
					"campo_valor"=>$apellido
                ],
				"cliente_genero"=>[
					"campo_marcador"=>":Genero",
					"campo_valor"=>$genero
                ],
                "cliente_telefono"=>[
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
				],
                "cliente_provincia"=>[
					"campo_marcador"=>":Provincia",
					"campo_valor"=>$provincia
                ],
                "cliente_ciudad"=>[
					"campo_marcador"=>":Ciudad",
					"campo_valor"=>$ciudad
				],
                "cliente_direccion"=>[
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$direccion
				],
				"cliente_email"=>[
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				"cliente_clave"=>[
					"campo_marcador"=>":Clave",
					"campo_valor"=>$clave
				],
				"cliente_foto"=>[
					"campo_marcador"=>":Foto",
					"campo_valor"=>$avatar
				],
				"cliente_cuenta_estado"=>[
					"campo_marcador"=>":Estado",
					"campo_valor"=>$estado
				],
				"cliente_cuenta_verificada"=>[
					"campo_marcador"=>":Verificacion",
					"campo_valor"=>$verificacion
				]
			];

            $condicion=[
				"condicion_campo"=>"cliente_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

            if(mainModel::actualizar_datos("cliente",$datos_cliente_up,$condicion)){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Cuenta actualizada!",
					"Texto"=>"Los datos de la cuenta se actualizaron con éxito en el sistema",
					"Icon"=>"success",
					"TxtBtn"=>"Aceptar"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido actualizar los datos de la cuenta, por favor intente nuevamente",
					"Icon"=>"error",
					"TxtBtn"=>"Aceptar"
				];
			}
			echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/
    }