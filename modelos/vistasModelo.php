<?php 
	class vistasModelo{

		/*---------- Modelo obtener vistas ----------*/
		protected static function obtener_vistas_modelo($vistas,$modulo,$idioma){
			$lista_blanca=["index","signin","product","home","registration","bag","details","admin-new","admin-list","admin-search","admin-update","client-new","client-list","client-search","client-update","category-new","category-list","category-search","category-update","company","product-new","product-list","product-search","product-minimum","product-update","product-cover","product-gallery","product-info"];
			if(in_array($vistas, $lista_blanca)){
				if(is_file("./vistas/contenidos/".$idioma."/".$modulo."-".$vistas.".php")){
					$contenido="./vistas/contenidos/".$idioma."/".$modulo."-".$vistas.".php";
				}else{
					$contenido="404";
				}
			}else{
				$contenido="404";
			}
			return $contenido;
		}
	}