<?php

	function descargarYGuardarImagen($url, $folder = "tmpfiles", $name = "") {
		$imagenContenido = file_get_contents($url);

		if ($imagenContenido === false) {
			return false;
		}

		$dt = strtotime(date("Y-m-d H:i:s")) . uniqid();
		if($name != "") {
			$dt = $name;
		}

		if($folder == "tmpfiles" && $name != "") {
			if(!file_exists("$folder/$dt.webp")) {
				file_put_contents("$folder/$dt.webp", $imagenContenido);
			}
		}
		else {
			file_put_contents("$folder/$dt.webp", $imagenContenido);
		}
		$nuevaURL = "/$folder/$dt.webp";
		return $nuevaURL;
	}
	//FILTRO CATEGORIA INMUEBLES
	$filterHiddens = array(
		"MLA1459"
	);

	function filtro_ocultar($str, $display = true) {
		$text = "";
		if(in_array($str, $GLOBALS["filterHiddens"])) {
			$text = "d-none invisible";
		}
		/*foreach($GLOBALS["filterHiddens"] as $fil) {
			if($fil == $str) {
				$text = "d-none invisible";
			}
		}*/
		if($display) {
			echo $text;
		}
	}

	function sannedStr( $string, $separator = '-' ) {
		$accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|Grave|lig|orn|ring|slash|th|tilde|uml);~i';
		$special_cases = array( '&' => 'and', "'" => '');
		$string = mb_strtolower( trim( $string ), 'UTF-8' );
		$string = str_replace( array_keys($special_cases), array_values( $special_cases), $string );
		$string = preg_replace( $accents_regex, '$1', htmlentities( $string, ENT_QUOTES, 'UTF-8' ) );
		$string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
		$string = preg_replace("/[$separator]+/u", "$separator", $string);
		return $string;
	}

?>