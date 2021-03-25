<?php

    if($peticion_ajax){
        require_once "../modelos/mainModel.php";
    }else{
        require_once "./modelos/mainModel.php";
    }

	class administradorControlador extends mainModel{

        /*--------- Controlador registrar administrador - Controller register administrator ---------*/
        public function registrar_administrador_controlador(){

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
            $nombre=mainModel::limpiar_cadena($_POST['usuario_nombre_reg']);
            $apellido=mainModel::limpiar_cadena($_POST['usuario_apellido_reg']);
            $telefono=mainModel::limpiar_cadena($_POST['usuario_telefono_reg']);
            $genero=mainModel::limpiar_cadena($_POST['usuario_genero_reg']);
            $cargo=mainModel::limpiar_cadena($_POST['usuario_cargo_reg']);

            $usuario=mainModel::limpiar_cadena($_POST['usuario_usuario_reg']);
            $email=mainModel::limpiar_cadena($_POST['usuario_email_reg']);
            $clave_1=mainModel::limpiar_cadena($_POST['usuario_clave_1_reg']);
            $clave_2=mainModel::limpiar_cadena($_POST['usuario_clave_2_reg']);
            $estado=mainModel::limpiar_cadena($_POST['usuario_estado_reg']);
            $avatar=mainModel::limpiar_cadena($_POST['usuario_avatar_reg']);


            /*-- Comprobando campos vacios - Checking empty fields --*/
            if($nombre=="" || $apellido=="" || $usuario=="" || $email=="" || $clave_1=="" || $clave_2==""){
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

            if(mainModel::verificar_datos("[a-zA-Z0-9]{4,30}",$usuario)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El USUARIO no coincide con el formato solicitado",
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
            
            /*-- Comprobando cargo - Checking position --*/
			if($cargo!="Administrador" && $cargo!="Cajero"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Opción no valida",
					"Texto"=>"Ha seleccionado un CARGO no valido",
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
			if($email!=""){
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					$check_email=mainModel::ejecutar_consulta_simple("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
					if($check_email->rowCount()>0){
                        $alerta=[
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrió un error inesperado",
                            "Texto"=>"El EMAIL ingresado ya se encuentra registrado en el sistema",
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

            /*-- Comprobando usuario - Checking user --*/
            $check_usuario=mainModel::ejecutar_consulta_simple("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$usuario'");
			if($check_usuario->rowCount()>0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El nombre de usuario ingresado ya está siendo utilizado, por favor elija otro",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
			}
			$check_usuario->closeCursor();
            $check_usuario=mainModel::desconectar($check_usuario);
            

            /*-- Preparando datos para enviarlos al modelo - Preparing data to send to the model --*/
			$datos_usuario_reg=[
				"usuario_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				"usuario_apellido"=>[
					"campo_marcador"=>":Apellido",
					"campo_valor"=>$apellido
                ],
                "usuario_telefono"=>[
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
				],
				"usuario_genero"=>[
					"campo_marcador"=>":Genero",
					"campo_valor"=>$genero
                ],
                "usuario_cargo"=>[
					"campo_marcador"=>":Cargo",
					"campo_valor"=>$cargo
                ],
                "usuario_usuario"=>[
					"campo_marcador"=>":Usuario",
					"campo_valor"=>$usuario
				],
				"usuario_email"=>[
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				"usuario_clave"=>[
					"campo_marcador"=>":Clave",
					"campo_valor"=>$clave
				],
				"usuario_cuenta_estado"=>[
					"campo_marcador"=>":Estado",
					"campo_valor"=>$estado
				],
				"usuario_foto"=>[
					"campo_marcador"=>":Foto",
					"campo_valor"=>$avatar
				]
			];

            /*-- Guardando datos del usuario - Saving user data --*/
			$agregar_usuario=mainModel::guardar_datos("usuario",$datos_usuario_reg);

			if($agregar_usuario->rowCount()==1){
                $alerta=[
                    "Alerta"=>"limpiar",
                    "Titulo"=>"¡$cargo registrado!",
                    "Texto"=>"Los datos del $cargo se registraron con éxito en el sistema",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];
			}else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido registrar el $cargo, por favor intente nuevamente",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
			}

			$agregar_usuario->closeCursor();
			$agregar_usuario=mainModel::desconectar($agregar_usuario);

			echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador paginador administradores - Administrators Pager Controller ---------*/
        public function paginador_administrador_controlador($pagina,$registros,$url,$busqueda){
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
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM usuario WHERE ((usuario_id!='$id' AND usuario_id!='".$_SESSION['id_sto']."') AND (usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' OR usuario_cargo LIKE '%$busqueda%' OR usuario_usuario LIKE '%$busqueda%')) ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";
			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM usuario WHERE usuario_id!='".$_SESSION['id_sto']."' AND usuario_id!='1' ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";
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
                        <th>Usuario</th>
                        <th>Cargo</th>
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
							<td>'.$rows['usuario_nombre'].' '.$rows['usuario_apellido'].'</td>
							<td>'.$rows['usuario_usuario'].'</td>
							<td>'.$rows['usuario_cargo'].'</td>
							<td><a class="btn btn-link text-success" href="'.SERVERURL.DASHBOARD.'/admin-update/'.mainModel::encryption($rows['usuario_id']).'/"><i class="fas fa-sync-alt"></i></a></td>
							<td>
                                <form class="FormularioAjax" action="'.SERVERURL.'ajax/administradorAjax.php" method="POST" data-form="delete" data-lang="'.LANG.'" >
                                    <input type="hidden" name="modulo_administrador" value="eliminar">
									<input type="hidden" name="usuario_id_del" value="'.mainModel::encryption($rows['usuario_id']).'">
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
				$tabla.='<p class="text-end">Mostrando administradores <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
			}

			/*--Paginacion - Pagination --*/
			if($total>=1 && $pagina<=$Npaginas){
				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7,LANG);
			}

			return $tabla;
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador eliminar administrador - Controller delete administrator ---------*/
        public function eliminar_administrador_controlador(){

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

			/*-- Recuperando id del administrador - Retrieving administrator id - --*/
			$id=mainModel::decryption($_POST['usuario_id_del']);
			$id=mainModel::limpiar_cadena($id);

			/*-- Comprobando usuario principal - Checking primary user --*/
			if($id==1){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos eliminar el administrador principal del sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}

			/*-- Comprobando usuario en la BD - Checking user in DB --*/
			$check_usuario=mainModel::ejecutar_consulta_simple("SELECT usuario_id FROM usuario WHERE usuario_id='$id'");
			if($check_usuario->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Administrador no encontrado",
					"Texto"=>"El administrador que intenta eliminar no existe en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_usuario->closeCursor();
			$check_usuario=mainModel::desconectar($check_usuario);


			/*-- Comprobando ventas - Checking sales --*/
			$check_ventas=mainModel::ejecutar_consulta_simple("SELECT usuario_id FROM venta WHERE usuario_id='$id' LIMIT 1");
			if($check_ventas->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos eliminar el administrador debido a que tiene ventas asociadas, recomendamos deshabilitar este administrador si ya no será usado en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_ventas->closeCursor();
			$check_ventas=mainModel::desconectar($check_ventas);

			
			/*-- Eliminando administrador - Deleting administrator --*/
			$eliminar_usuario=mainModel::eliminar_registro("usuario","usuario_id",$id);

			if($eliminar_usuario->rowCount()==1){
				$alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"¡Administrador eliminado!",
                    "Texto"=>"El administrador ha sido eliminado del sistema exitosamente",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];
			}else{
				$alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido eliminar el usuario del sistema, por favor intente nuevamente",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
			}

			$eliminar_usuario->closeCursor();
			$eliminar_usuario=mainModel::desconectar($eliminar_usuario);

			echo json_encode($alerta);
		} /*-- Fin controlador - End controller --*/
		

		/*--------- Controlador actualizar administrador - Controller update administrator ---------*/
		public function actualizar_administrador_controlador(){

			/*-- Recibiendo id del usuario - Receiving user id --*/
			$id=mainModel::decryption($_POST['usuario_id_up']);
			$id=mainModel::limpiar_cadena($id);

			/*-- Comprobando usuario en la DB - Checking user in DB --*/
			$check_user=mainModel::ejecutar_consulta_simple("SELECT * FROM usuario WHERE usuario_id='$id'");
			if($check_user->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Administrador no encontrado",
					"Texto"=>"No hemos encontrado la cuenta del administrador en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}else{
				$campos=$check_user->fetch();
			}
			$check_user->closeCursor();
			$check_user=mainModel::desconectar($check_user);


			/*-- Comprobando actualizacion del administrador principal - Checking main admin update --*/
			if($id==1 && $_SESSION['id_sto']!=$id){
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
            $nombre=mainModel::limpiar_cadena($_POST['usuario_nombre_up']);
            $apellido=mainModel::limpiar_cadena($_POST['usuario_apellido_up']);
            $telefono=mainModel::limpiar_cadena($_POST['usuario_telefono_up']);
			$genero=mainModel::limpiar_cadena($_POST['usuario_genero_up']);

			if(isset($_POST['usuario_cargo_up'])){
				$cargo=mainModel::limpiar_cadena($_POST['usuario_cargo_up']);
			}else{
				$cargo=$campos['usuario_cargo'];
			}

            $usuario=mainModel::limpiar_cadena($_POST['usuario_usuario_up']);
            $email=mainModel::limpiar_cadena($_POST['usuario_email_up']);
            $clave_1=mainModel::limpiar_cadena($_POST['usuario_nueva_clave_1_up']);
			$clave_2=mainModel::limpiar_cadena($_POST['usuario_nueva_clave_2_up']);
			
			if(isset($_POST['usuario_estado_up'])){
				$estado=mainModel::limpiar_cadena($_POST['usuario_estado_up']);	
			}else{
				$estado=$campos['usuario_cuenta_estado'];
			}
			$avatar=mainModel::limpiar_cadena($_POST['usuario_avatar_up']);
			
			$administrador_usuario=mainModel::limpiar_cadena($_POST['administrador_usuario_up']);
			$administrador_clave=mainModel::limpiar_cadena($_POST['administrador_clave_up']);


			/*-- Comprobando campos vacios - Checking empty fields --*/
            if($nombre=="" || $apellido=="" || $usuario=="" || $email=="" || $administrador_usuario=="" || $administrador_clave==""){
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

            if(mainModel::verificar_datos("[a-zA-Z0-9]{4,30}",$usuario)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Formato no valido",
					"Texto"=>"El USUARIO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_datos("[a-zA-Z0-9]{4,30}",$administrador_usuario)){
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

			if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$administrador_clave)){
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

			$administrador_clave=mainModel::encryption($administrador_clave);
			
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
            
            /*-- Comprobando cargo - Checking position --*/
			if($cargo!="Administrador" && $cargo!="Cajero"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Opción no valida",
					"Texto"=>"Ha seleccionado un CARGO no valido",
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
					"Texto"=>"Ha seleccionado un ESTADO no valido",
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


			/*-- Comprobando credenciales para actualizar datos - Checking credentials to update data --*/
			if($_SESSION['id_sto']!=$id){

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

				$check_cuenta=mainModel::ejecutar_consulta_simple("SELECT usuario_id FROM usuario WHERE usuario_usuario='$administrador_usuario' AND usuario_clave='$administrador_clave' AND usuario_cuenta_estado='Activa'");
			}else{
				$check_cuenta=mainModel::ejecutar_consulta_simple("SELECT usuario_id FROM usuario WHERE usuario_usuario='$administrador_usuario' AND usuario_clave='$administrador_clave' AND usuario_id='$id' AND usuario_cuenta_estado='Activa'");
			}


			if($check_cuenta->rowCount()!=1){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Datos incorrectos",
					"Texto"=>"El nombre de usuario y contraseña ingresados no coinciden con los de su cuenta",
					"Icon"=>"error",
					"TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}
			$check_cuenta->closeCursor();
			$check_cuenta=mainModel::desconectar($check_cuenta);


            /*-- Comprobando email - Checking email --*/
			if($email!=$campos['usuario_email'] && $email!=""){
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					$check_email=mainModel::ejecutar_consulta_simple("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
					if($check_email->rowCount()>0){
                        $alerta=[
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrió un error inesperado",
                            "Texto"=>"El EMAIL ingresado ya se encuentra registrado en el sistema",
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
				$clave=$campos['usuario_clave'];
			}


			/*-- Comprobando usuario - Checking user --*/
			if($usuario!=$campos['usuario_usuario']){
				$check_usuario=mainModel::ejecutar_consulta_simple("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$usuario'");
				if($check_usuario->rowCount()>0){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El nombre de usuario ingresado ya está siendo utilizado, por favor elija otro",
						"Icon"=>"error",
						"TxtBtn"=>"Aceptar"
					];
					echo json_encode($alerta);
					exit();
				}
				$check_usuario->closeCursor();
				$check_usuario=mainModel::desconectar($check_usuario);
			}


			/*-- Preparando datos para enviarlos al modelo - Preparing data to send to the model --*/
			$datos_usuario_up=[
				"usuario_nombre"=>[
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				"usuario_apellido"=>[
					"campo_marcador"=>":Apellido",
					"campo_valor"=>$apellido
                ],
                "usuario_telefono"=>[
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
				],
				"usuario_genero"=>[
					"campo_marcador"=>":Genero",
					"campo_valor"=>$genero
                ],
                "usuario_cargo"=>[
					"campo_marcador"=>":Cargo",
					"campo_valor"=>$cargo
                ],
                "usuario_usuario"=>[
					"campo_marcador"=>":Usuario",
					"campo_valor"=>$usuario
				],
				"usuario_email"=>[
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				"usuario_clave"=>[
					"campo_marcador"=>":Clave",
					"campo_valor"=>$clave
				],
				"usuario_cuenta_estado"=>[
					"campo_marcador"=>":Estado",
					"campo_valor"=>$estado
				],
				"usuario_foto"=>[
					"campo_marcador"=>":Foto",
					"campo_valor"=>$avatar
				]
			];

			$condicion=[
				"condicion_campo"=>"usuario_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if(mainModel::actualizar_datos("usuario",$datos_usuario_up,$condicion)){

				if($_SESSION['id_sto']==$id){
					$_SESSION['nombre_sto']=$nombre;
					$_SESSION['apellido_sto']=$apellido;
					$_SESSION['genero_sto']=$genero;
					$_SESSION['usuario_sto']=$usuario;
					$_SESSION['cargo_sto']=$cargo;
					$_SESSION['foto_sto']=$avatar;
				}

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