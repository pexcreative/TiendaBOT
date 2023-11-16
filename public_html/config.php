<?php
	session_start();

	//datos de mysql
	$dbServer = "localhost";
	$dbName = "movilpro_web";
	$dbUsername = "movilpro_web";
	$dbPassword = "VYPs7m1qsheg";

	//datos tienda
	$mla = "MLA";
	$empresa = 'MovilPro';
	$metaDescription = "Encontrá lo que buscás. Todo lo que necesitas lo conseguís en un solo lugar";
	$id_categoria = 'MLA1051';
	$titulo = "Celulares y Teléfonos"." - ".$empresa;
	$keyword = "Celulares";
	$descripcion_google = 'Consigue los mejores precios para Celulares y Teléfonos';
	$logo = '';
	$icon = 'https://alquila2.com.ar/icon.png';
	$cdn = "e2c5110997bb5da1e8beec973cdc3b35";
	//PUBLICIDAD
	$adsense_categoria = '';
	$adsense_item = '';
	$adsense_sidebar = '';
	//ENVIO GRATIS A PARTIR DE
	$envio_gratis = 10000;
	//12 CUOTAS
	$cuotas_12 = 250000;
	


	//ELIMINAR LAS WIDGET
	$escapeIds = array("ITEM_CONDITION","MOBILE_NETWORK","WITH_FACIAL_RECOGNITION","WITH_FAST_CHARGING","WITH_FINGERPRINT_READER","WITH_GPS","WITH_GYROSCOPE", "WITH_MEMORY_CARD_SLOT","WITH_RADIO","DISPLAY_TYPE","IS_DUST_RESISTANT","IS_WATERPROOF","IS_PORTABLE","WITH_SCREEN_SHARE_FUNCTION");
	
	//Quitar keywords del campo DESCRIPCION
	$filterRemoveWords = array("https://eshops.mercadolibre.com.ar");

	function getWord($word) {
		$newValue = $word;
		foreach($GLOBALS["replaceIds"] as $inf) {
			if($inf["TEXT_SEARCH"] == $word) {
				$newValue = $inf["REPLACE_FOR"];
			}
		}
		return $newValue;
	}

	function contieneSimbolos($cadena) {
		$patron = '/[^\p{L}\p{N}]+/u';
		if (preg_match($patron, $cadena)) {
			return true;
		} else {
			return false;
		}
	}

	function curl($url) {
		$ch = curl_init($url); // Inicia sesión cURL
		curl_setopt($ch, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)'); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Configura cURL para devolver el resultado como cadena
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
		$info = curl_exec($ch); // Establece una sesión cURL y asigna la información a la variable $info
		curl_close($ch); // Cierra sesión cURL
		return $info; // Devuelve la información de la función
	}

	//CAMBIAR EXTENSION DE IMAGEN
	function change_image_extension($url) {
		$parts = explode('.', $url);
		$extension = end($parts);
		if ($extension == 'jpg') {
			$new_url = str_replace('.jpg', '.webp', $url);
			return $new_url;
		}
		return $url;
	}
	//ENCRIPTAR EN BASE64 IMAGEN
	function convertirImagenABase64($src) {
	$image = file_get_contents($src);
	return 'data:image/jpg;base64,'.base64_encode($image);
	}

	function stripStr($str) {
		//$newStr = "";
		$newStr = implode("|", explode('"', $str));
		$newStr = implode("!", explode('(', $newStr));
		$newStr = implode("$", explode(')', $newStr));
		
	
		return $newStr;
	}
	
	function stripStrDecode($str) {
		//$newStr = "";
		$newStr = implode('"', explode("|", $str));
		$newStr = implode('(', explode("!", $newStr));
		$newStr = implode(')', explode("$", $newStr));
		
	
		return $newStr;
	}

	

?>
