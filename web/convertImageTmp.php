<?php
//USO -> descargarYGuardarImagen($imagen_principal)
	function descargarYGuardarImagen($url) {
		$imagenContenido = file_get_contents($url);

		if ($imagenContenido === false) {
			return false;
		}

		$dt = strtotime(date("Y-m-d H:i:s")) . uniqid();

		file_put_contents("tmpfiles/$dt.png", $imagenContenido);
		$nuevaURL = 'tmpfiles/' . $dt.".png";
		return $nuevaURL;
	}

?>