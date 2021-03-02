<?php

	if($peticion_ajax){
		require_once "../config/SERVER.php";
	}else{
		require_once "./config/SERVER.php";
	}

	class mainModel{

		/*----------  Funcion conectar a BD - Function connect to BD ----------*/
		protected static function conectar(){
			$conexion = new PDO(SGBD,USER,PASS);
			$conexion->exec("SET CHARACTER SET utf8");
			return $conexion;
		} /*--  Fin Funcion - End Function --*/


		/*----------  Funcion desconectar de DB - Function disconnect from DB  ----------*/
		public function desconectar($consulta){
			global $conexion, $consulta;
			$consulta=null;
			$conexion=null;
			return $consulta;
		} /*--  Fin Funcion - End Function --*/


		/*----------  Funcion ejecutar consultas simples - Run simple queries function  ----------*/
		protected static function ejecutar_consulta_simple($consulta){
			$sql=self::conectar()->prepare($consulta);
			$sql->execute();
			return $sql;
		} /*--  Fin Funcion - End Function --*/


		/*----------  Funcion para ejecutar una consulta INSERT preparada - Function to execute a prepared INSERT query ----------*/
		protected static function guardar_datos($tabla,$datos){
			$query="INSERT INTO $tabla (";
			$C=0;
			foreach ($datos as $campo => $indice){
				if($C<=0){
					$query.=$campo;
				}else{
					$query.=",".$campo;
				}
				$C++;
			}
			
			$query.=") VALUES(";
			$Z=0;
			foreach ($datos as $campo => $indice){
				if($Z<=0){
					$query.=$indice["campo_marcador"];
				}else{
					$query.=",".$indice["campo_marcador"];
				}
				$Z++;
			}

			$query.=")";
			$sql=self::conectar()->prepare($query);

			foreach ($datos as $campo => $indice){
				$sql->bindParam($indice["campo_marcador"],$indice["campo_valor"]);
			}

			$sql->execute();

			return $sql;
		} /*-- Fin Funcion - End Function --*/


		/*---------- Funcion datos tabla - Table data function ----------*/
        public function datos_tabla($tipo,$tabla,$campo,$id){
			$tipo=self::limpiar_cadena($tipo);
			$tabla=self::limpiar_cadena($tabla);
			$campo=self::limpiar_cadena($campo);

			$id=self::decryption($id);
			$id=self::limpiar_cadena($id);

            if($tipo=="Unico"){
                $sql=self::conectar()->prepare("SELECT * FROM $tabla WHERE $campo=:ID");
                $sql->bindParam(":ID",$id);
            }elseif($tipo=="Normal"){
                $sql=self::conectar()->prepare("SELECT $campo FROM $tabla");
            }
            $sql->execute();

            return $sql;
		} /*-- Fin Funcion - End Function --*/


		/*----------  Funcion para ejecutar una consulta UPDATE preparada - Function to execute a prepared UPDATE query ----------*/
		protected static function actualizar_datos($tabla,$datos,$condicion){
			$query="UPDATE $tabla SET ";

			$C=0;
			foreach ($datos as $campo => $indice){
				if($C<=0){
					$query.=$campo."=".$indice["campo_marcador"];
				}else{
					$query.=",".$campo."=".$indice["campo_marcador"];
				}
				$C++;
			}

			$query.=" WHERE ".$condicion["condicion_campo"]."=".$condicion["condicion_marcador"];

			$sql=self::conectar()->prepare($query);

			foreach ($datos as $campo => $indice){
				$sql->bindParam($indice["campo_marcador"],$indice["campo_valor"]);
			}

			$sql->bindParam($condicion["condicion_marcador"],$condicion["condicion_valor"]);

			$sql->execute();

			return $sql;
		} /*-- Fin Funcion - End Function --*/
		

		/*---------- Funcion eliminar registro - Delete record function ----------*/
        protected static function eliminar_registro($tabla,$campo,$id){
            $sql=self::conectar()->prepare("DELETE FROM $tabla WHERE $campo=:ID");

            $sql->bindParam(":ID",$id);
            $sql->execute();
            
            return $sql;
        } /*-- Fin Funcion - End Function --*/


		/*----------  Encriptar cadenas - Encrypt strings ----------*/
		public function encryption($string){
			$output=FALSE;
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		} /*--  Fin Funcion - End Function --*/


		/*----------  Desencriptar cadenas - Decrypt strings ----------*/
		protected static function decryption($string){
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
		} /*--  Fin Funcion - End Function --*/


		/*----------  Limitar cadenas de texto - Limit text strings  ----------*/
		public function limitar_cadena($cadena,$limite,$sufijo){
			if(strlen($cadena)>$limite){
				return substr($cadena,0,$limite).$sufijo;
			}else{
				return $cadena;
			}
		} /*--  Fin Funcion - End Function --*/


		/*----------  Funcion generar codigos aleatorios - Generate random codes function ----------*/
		protected static function generar_codigo_aleatorio($longitud,$correlativo){
			$codigo="";
			$caracter="Letra";
			for($i=1; $i<=$longitud; $i++){
				if($caracter=="Letra"){
					$letra_aleatoria=chr(rand(ord("a"),ord("z")));
					$letra_aleatoria=strtoupper($letra_aleatoria);
					$codigo.=$letra_aleatoria;
					$caracter="Numero";
				}else{
					$numero_aleatorio=rand(0,9);
					$codigo.=$numero_aleatorio;
					$caracter="Letra";
				}
			}
			return $codigo."-".$correlativo;
		} /*--  Fin Funcion - End Function --*/


		/*----------  Funcion limpiar cadenas - Function to clean text strings ----------*/
		protected static function limpiar_cadena($cadena){
			$cadena=trim($cadena);
			$cadena=stripslashes($cadena);
			$cadena=str_ireplace("<script>", "", $cadena);
			$cadena=str_ireplace("</script>", "", $cadena);
			$cadena=str_ireplace("<script src", "", $cadena);
			$cadena=str_ireplace("<script type=", "", $cadena);
			$cadena=str_ireplace("SELECT * FROM", "", $cadena);
			$cadena=str_ireplace("DELETE FROM", "", $cadena);
			$cadena=str_ireplace("INSERT INTO", "", $cadena);
			$cadena=str_ireplace("DROP TABLE", "", $cadena);
			$cadena=str_ireplace("DROP DATABASE", "", $cadena);
			$cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
			$cadena=str_ireplace("SHOW TABLES;", "", $cadena);
			$cadena=str_ireplace("SHOW DATABASES;", "", $cadena);
			$cadena=str_ireplace("<?php", "", $cadena);
			$cadena=str_ireplace("?>", "", $cadena);
			$cadena=str_ireplace("--", "", $cadena);
			$cadena=str_ireplace("^", "", $cadena);
			$cadena=str_ireplace("<", "", $cadena);
			$cadena=str_ireplace(">", "", $cadena);
			$cadena=str_ireplace("[", "", $cadena);
			$cadena=str_ireplace("]", "", $cadena);
			$cadena=str_ireplace("==", "", $cadena);
			$cadena=str_ireplace(";", "", $cadena);
			$cadena=str_ireplace("::", "", $cadena);
			$cadena=trim($cadena);
			$cadena=stripslashes($cadena);
			return $cadena;
		} /*--  Fin Funcion - End Function --*/


		/*---------- Funcion verificar datos (expresion regular) - Check data function (regular expression) ----------*/
		protected static function verificar_datos($filtro,$cadena){
			if(preg_match("/^".$filtro."$/", $cadena)){
				return false;
            }else{
                return true;
            }
		} /*--  Fin Funcion - End Function --*/


		/*---------- Funcion verificar fechas - Check dates function ----------*/
		protected static function verificar_fecha($fecha){
			$valores=explode('-',$fecha);
			if(count($valores)==3 && checkdate($valores[1], $valores[2], $valores[0])){
				return false;
			}else{
				return true;
			}
		} /*--  Fin Funcion - End Function --*/


		/*---------- Funcion obtener nombre de mes - Get month name function ----------*/
		public function obtener_nombre_mes($mes){
			switch($mes){
				case 1:
					$nombre_mes="enero";
				break;
				case 2:
					$nombre_mes="febrero";
				break;
				case 3:
					$nombre_mes="marzo";
				break;
				case 4:
					$nombre_mes="abril";
				break;
				case 5:
					$nombre_mes="mayo";
				break;
				case 6:
					$nombre_mes="junio";
				break;
				case 7:
					$nombre_mes="julio";
				break;
				case 8:
					$nombre_mes="agosto";
				break;
				case 9:
					$nombre_mes="septiembre";
				break;
				case 10:
					$nombre_mes="octubre";
				break;
				case 11:
					$nombre_mes="noviembre";
				break;
				case 12:
					$nombre_mes="diciembre";
				break;
				default:
					$nombre_mes="No definido";
				break;
			}
			return $nombre_mes;
		} /*--  Fin Funcion - End Function --*/


		/*----------  Funcion paginador de tablas - Table pager function ----------*/
		protected static function paginador_tablas($pagina,$Npaginas,$url,$botones,$idioma){
			if($idioma=="es"){
				$txt_anterior="Anterior";
				$txt_siguiente="Siguiente";
			}else{
				$txt_anterior="Previous";
				$txt_siguiente="Next";
			}
			$tabla='<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">';

			if($pagina==1){
				$tabla.='<li class="page-item disabled" ><a class="page-link" ><i class="fas fa-angle-double-left"></i></a></li>';
			}else{
				$tabla.='
				<li class="page-item" ><a class="page-link" href="'.$url.'1/"><i class="fas fa-angle-double-left"></i></a></li>
				<li class="page-item" ><a class="page-link" href="'.$url.($pagina-1).'/">'.$txt_anterior.'</a></li>
				';
			}

			$ci=0;
			for($i=$pagina; $i<=$Npaginas; $i++){
				if($ci>=$botones){
					break;
				}
				if($pagina==$i){
					$tabla.='<li class="page-item active" ><a class="page-link" href="'.$url.$i.'/">'.$i.'</a></li>';
				}else{
					$tabla.='<li class="page-item" ><a class="page-link" href="'.$url.$i.'/">'.$i.'</a></li>';
				}
				$ci++;
			}

			if($pagina==$Npaginas){
				$tabla.='<li class="page-item disabled" ><a class="page-link" ><i class="fas fa-angle-double-right"></i></a></li>';
			}else{
				$tabla.='
				<li class="page-item" ><a class="page-link" href="'.$url.($pagina+1).'/">'.$txt_siguiente.'</a></li>
				<li class="page-item" ><a class="page-link" href="'.$url.$Npaginas.'/"><i class="fas fa-angle-double-right"></i></a></li>
				';
			}

			$tabla.='</ul></nav>';
			return $tabla;
		} /*--  Fin Funcion - End Function --*/


		/*----------  Funcion generar select - Generate select function ----------*/
		public function generar_select($datos,$campo_db){
			$check_select='';
			$text_select='';
			$count_select=1;
			$select='';
			foreach($datos as $row){

				if($campo_db==$row){
					$check_select='selected=""';
					$text_select=' (Actual)';
				}

				$select.='<option value="'.$row.'" '.$check_select.'>'.$count_select.' - '.$row.$text_select.'</option>';

				$check_select='';
				$text_select='';
				$count_select++;
			}
			return $select;
		} /*--  Fin Funcion - End Function --*/
	}