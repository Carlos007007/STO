<?php

	require_once __DIR__."/../modelos/mainModel.php";

	class loginControlador extends mainModel{

		/*----------  Controlador iniciar sesion administrador - Controller login administrator ----------*/
		public function iniciar_sesion_administrador_controlador(){

			$usuario=mainModel::limpiar_cadena($_POST['dashboard_usuario']);
			$clave=mainModel::limpiar_cadena($_POST['dashboard_clave']);

			/*-- Comprobando campos vacios - Checking empty fields --*/
			if($usuario=="" || $clave==""){
				echo'<script>
					Swal.fire({
					  title: "Ocurrió un error inesperado",
					  text: "No has llenado todos los campos que son requeridos.",
					  icon: "error",
					  confirmButtonText: "Aceptar"
					});
				</script>';
				exit();
			}


			/*-- Verificando integridad datos - Verifying data integrity --*/
			if(mainModel::verificar_datos("[a-zA-Z0-9]{4,30}",$usuario)){
				echo'<script>
					Swal.fire({
					  title: "Ocurrió un error inesperado",
					  text: "El nombre de usuario no coincide con el formato solicitado.",
					  icon: "error",
					  confirmButtonText: "Aceptar"
					});
				</script>';
				exit();
			}
			if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave)){
				echo'<script>
					Swal.fire({
					  title: "Ocurrió un error inesperado",
					  text: "La contraseña no coincide con el formato solicitado.",
					  icon: "error",
					  confirmButtonText: "Aceptar"
					});
				</script>';
				exit();
			}

			$clave=mainModel::encryption($clave);

			/*-- Verificando datos de la cuenta - Verifying account details --*/
			$datos_cuenta=mainModel::datos_tabla("Normal","usuario WHERE usuario_usuario='$usuario' AND usuario_clave='$clave' AND usuario_cuenta_estado='Activa'","*",0);

			if($datos_cuenta->rowCount()==1){

				$row=$datos_cuenta->fetch();

				$datos_cuenta->closeCursor();
			    $datos_cuenta=mainModel::desconectar($datos_cuenta);

				$_SESSION['id_sto']=$row['usuario_id'];
				$_SESSION['nombre_sto']=$row['usuario_nombre'];
				$_SESSION['apellido_sto']=$row['usuario_apellido'];
				$_SESSION['genero_sto']=$row['usuario_genero'];
				$_SESSION['usuario_sto']=$row['usuario_usuario'];
				$_SESSION['cargo_sto']=$row['usuario_cargo'];
				$_SESSION['foto_sto']=$row['usuario_foto'];

				if(headers_sent()){
					echo "<script> window.location.href='".SERVERURL.DASHBOARD."/home/'; </script>";
				}else{
					header("Location: ".SERVERURL.DASHBOARD."/home/");
				}

			}else{
				echo'<script>
					Swal.fire({
					  title: "Datos incorrectos",
					  text: "El nombre de usuario o contraseña no son correctos.",
					  icon: "error",
					  confirmButtonText: "Aceptar"
					});
				</script>';
			}
		} /*-- Fin controlador - End controller --*/


		/*----------  Controlador iniciar sesion cliente - Controller login client ----------*/
		public function iniciar_sesion_cliente_controlador(){

			$email=mainModel::limpiar_cadena($_POST['login_email']);
			$clave=mainModel::limpiar_cadena($_POST['login_clave']);

			/*-- Comprobando campos vacios - Checking empty fields --*/
			if($email=="" || $clave==""){
				$alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No has llenado todos los campos que son requeridos.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
				exit();
			}


			/*-- Verificando integridad datos - Verifying data integrity --*/
			if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave)){
				$alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Formato no valido",
                    "Texto"=>"La contraseña no coincide con el formato solicitado.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
				exit();
			}

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

			$clave=mainModel::encryption($clave);

			/*-- Verificando datos de la cuenta - Verifying account details --*/
			$datos_cuenta=mainModel::datos_tabla("Normal","cliente WHERE cliente_email='$email' AND cliente_clave='$clave' AND cliente_cuenta_estado='Activa'","*",0);

			if($datos_cuenta->rowCount()==1){

				$row=$datos_cuenta->fetch();

				$datos_cuenta->closeCursor();
			    $datos_cuenta=mainModel::desconectar($datos_cuenta);

				$_SESSION['cliente_id_sto']=$row['cliente_id'];
				$_SESSION['cliente_nombre_sto']=$row['cliente_nombre'];
				$_SESSION['cliente_apellido_sto']=$row['cliente_apellido'];
				$_SESSION['cliente_genero_sto']=$row['cliente_genero'];
				$_SESSION['cliente_email_sto']=$row['cliente_email'];
				$_SESSION['cliente_foto_sto']=$row['cliente_foto'];

				$alerta=[
					"Alerta"=>"redireccionar",
					"URL"=>SERVERURL."home/"
				];

				return json_encode($alerta);

			}else{
				$alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Datos incorrectos",
                    "Texto"=>"El nombre de usuario o contraseña no son correctos.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
				echo json_encode($alerta);
			}
		} /*-- Fin controlador - End controller --*/


		/*----------  Controlador forzar cierre de sesion - Controller force logout ----------*/
		public function cierre_sesion_controlador(){

			unset($_SESSION['id_sto']);
			unset($_SESSION['nombre_sto']);
			unset($_SESSION['apellido_sto']);
			unset($_SESSION['genero_sto']);
			unset($_SESSION['usuario_sto']);
			unset($_SESSION['cargo_sto']);
			unset($_SESSION['foto_sto']);
			unset($_SESSION['token_sto']);

			session_destroy();

			if(headers_sent()){
				echo "<script> window.location.href='".SERVERURL."index/'; </script>";
			}else{
				header("Location: ".SERVERURL."index/");
			}
		} /*-- Fin controlador - End controller --*/
		
	}