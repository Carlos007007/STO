<?php

	/*----------  
	Ruta o dominio del servidor  - Server path or domain
	----------*/
	const SERVERURL="http://localhost/STO/";


	/*----------  
	Nombre de la empresa o compañia -  Company or company name
	----------*/
	const COMPANY="Carlos Alfaro";


	/*----------  Idioma - Language
	Español -> es 
	----------*/
	const LANG="es";

	
	/*----------  
		Palabra clave dashboard - Dashboard keyword
		No usar los siguientes valores - Do not use the following values

		index | product | bag | registration | details | signin
	----------*/
	const DASHBOARD="admin";


	/*----------  
	Nombre de la sesion -  Session name
	----------*/
	const SESSION_NAME="STO";


	/*----------  Redes sociales - Social networks  ----------*/
	const FACEBOOK="https://www.facebook.com/CarlosAlfaroES/";
	const INSTAGRAM="";
	const YOUTUBE="https://www.youtube.com/c/CarlosAlfaro007";
	const TWITTER="";


	/*----------  Direccion - Address  ----------*/
	const COUNTRY="El Salvador";
	const ADDRESS="San Salvador, El Salvador, Centro América";
	

	/*----------  Configuración de moneda - Currency Settings  ----------*/
	const COIN_SYMBOL="$";
	const COIN_NAME="USD";
	const COIN_DECIMALS="2";
	const COIN_SEPARATOR_THOUSAND=",";
	const COIN_SEPARATOR_DECIMAL=".";


	/*----------  Tipos de documentos - Document types ----------*/
	const DOCUMENTS_USERS=["DNI","Cedula","DUI","Licencia","Pasaporte","Otro"];
	const DOCUMENTS_COMPANY=["DNI","Cedula","RUT","NIT","RUC","Otro"];


	/*----------  Tipos de unidades de productos - Types of product units ----------*/
	const PRODUTS_UNITS=["Unidad","Libra","Kilogramo","Caja","Paquete","Lata","Galon","Botella","Tira","Sobre","Bolsa","Saco","Tarjeta","Otro"];

	/*----------  Límite de tamaño de imágenes de productos en MB - Product image size limit in MB ----------*/
	const COVER_PRODUCT=3;
	const GALLERY_PRODUCT=7;


	/*----------  Marcador de campos obligatorios - Mandatory field marker  ----------*/
	const FIELD_OBLIGATORY='&nbsp; <i class="fab fa-font-awesome-alt"></i> &nbsp;';


	/*----------  Configuración de codigos de barras - Bar code settings

		BARCODE_FORMAT -> CODE128 | CODE39 | EAN | EAN-13 | EAN-8 | EAN-5 | EAN-2 | UPC | ITF | ITF-14 | MSI | MSI10 | MSI11 | MSI1010 | MSI1110 | Pharmacode

		BARCODE_TEXT_ALIGN -> center | left | right

		BARCODE_TEXT_POSITION -> top | bottom

	----------*/

	const BARCODE_FORMAT="CODE128";
	const BARCODE_TEXT_ALIGN="center";
	const BARCODE_TEXT_POSITION="bottom";


	/*----------  Tamaño de papel de impresora termica (en milimetros) - Thermal printer paper size (in millimeters)
		THERMAL_PRINT_SIZE -> 80 | 57
	----------*/
	const THERMAL_PRINT_SIZE="80";


	/*----------  Zona horaria - Time zone  ----------*/
	date_default_timezone_set("America/El_Salvador");

	/*
		Configuración de zona horaria de tu país, para más información visita - Time zone configuration of your country, for more information visit
		
		http://php.net/manual/es/function.date-default-timezone-set.php
		http://php.net/manual/es/timezones.php
	*/