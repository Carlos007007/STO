<?php
	require_once "../config/APP.php";
	include "../vistas/inc/session_start.php";
	
	if(isset($_POST['busqueda_inicial']) || isset($_POST['eliminar_busqueda']) || isset($_POST['fecha_inicio']) || isset($_POST['fecha_final'])){

		$data_url=[
			"usuario"=>"admin-search",
			"cliente"=>"client-search",
			"categoria"=>"category-search",
			"producto"=>"product-search",
			"tienda"=>"product"
		];

		if(isset($_POST['modulo'])){
			$modulo=$_POST['modulo'];
			if(!isset($data_url[$modulo])){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos realizar la búsqueda debido a un problema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
				];
				echo json_encode($alerta);
				exit();
			}
		}else{
			$alerta=[
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"No podemos realizar la búsqueda debido a un problema de configuración",
				"Icon"=>"error",
				"TxtBtn"=>"Aceptar"
			];
			echo json_encode($alerta);
			exit();
		}
		
		if($modulo=="pedido"){
			$fecha_inicio="fecha_inicio_".$modulo;
			$fecha_final="fecha_final_".$modulo;

			/*----------  Iniciar busqueda  ----------*/
			if(isset($_POST['fecha_inicio']) || isset($_POST['fecha_final'])){
				if($_POST['fecha_inicio']=="" || $_POST['fecha_final']==""){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Por favor introduce una fecha de inicio y una fecha final para poder realizar la búsqueda",
						"Icon"=>"error",
						"TxtBtn"=>"Aceptar"
					];
					echo json_encode($alerta);
					exit();
				}
				$_SESSION[$fecha_inicio]=$_POST['fecha_inicio'];
				$_SESSION[$fecha_final]=$_POST['fecha_final'];
			}

			/*----------  Eliminar busqueda  ----------*/
			if(isset($_POST['eliminar_busqueda'])){
				unset($_SESSION[$fecha_inicio]);
				unset($_SESSION[$fecha_final]);
			}

		}else{
			$name_var="busqueda_".$modulo;

			/*----------  Iniciar busqueda  ----------*/
			if(isset($_POST['busqueda_inicial'])){
				if($_POST['busqueda_inicial']==""){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Por favor introduce un término de búsqueda para comenzar",
						"Icon"=>"error",
						"TxtBtn"=>"Aceptar"
					];
					echo json_encode($alerta);
					exit();
				}
				$_SESSION[$name_var]=$_POST['busqueda_inicial'];
			}

			/*----------  Eliminar busqueda  ----------*/
			if(isset($_POST['eliminar_busqueda'])){
				unset($_SESSION[$name_var]);
			}
		}

		$url=$data_url[$modulo];	

		/*----------  Redireccionamiento general  ----------*/
		if($modulo!="tienda"){
			$alerta=[
				"Alerta"=>"redireccionar",
				"URL"=>SERVERURL.DASHBOARD."/".$url."/"
			];
		}else{
			$alerta=[
				"Alerta"=>"redireccionar",
				"URL"=>SERVERURL.$url."/all/ASC/1/"
			];
		}
		echo json_encode($alerta);
	}else{
        session_destroy();
		header("Location: ".SERVERURL."index/");
	}