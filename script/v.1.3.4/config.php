<?php
	session_start();

	//version de la tienda principal
	$shopVersion = "1.3.3";

	if(isset($_REQUEST["getVersion"]) && $_REQUEST["getVersion"] != "") {
		echo $shopVersion; die();
	}

	$versionFile = file_get_contents("version.txt");
	$shopUpdate = false;

	//datos de mysql
	$dbServer = "localhost";
	$dbName = "ropaenavellaneda_web";
	$dbUsername = "ropaenavellaneda_web";
	$dbPassword = "ywK5LtiS2ZFQ";
	if($dbName != "ropaenavellaneda_web") {
		$shopVersion = file_get_contents("https://ropaenavellaneda.com.ar/config.php?getVersion=1");
		$shopUpdate = $versionFile != $shopVersion;
		$shopVersion = $versionFile;
	}

	//datos tienda
	$mla = "MLA";
	$empresa = 'Ropa en Avellaneda';
	$metaDescription = "Encontrá lo que buscás. Todo lo que necesitas lo conseguís en un solo lugar";
	$id_categoria = 'MLA1430';
	$titulo = "Ropa y Accesorios"." - ".$empresa;
	$keyword = "Ropa para mujer";
	$descripcion_google = 'Consigue los mejores precios para Ropa y Accesorios';
	$logo = '';
	$icon = 'https://alquila2.com.ar/icon.png';
	$cdn = "51c3f536f187d00500c73857e8145e37";
	//PUBLICIDAD
	$adsense_categoria = '';
	$adsense_item = '
		<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1385318809837552"
			 crossorigin="anonymous"></script>
		<!-- RopaEnAv POST DIC/23 -->
		<ins class="adsbygoogle"
			 style="display:block"
			 data-ad-client="ca-pub-1385318809837552"
			 data-ad-slot="2014921688"
			 data-ad-format="auto"
			 data-full-width-responsive="true"></ins>
		<script>
			 (adsbygoogle = window.adsbygoogle || []).push({});
		</script>';
	$adsense_sidebar = '';
	//ENVIO GRATIS A PARTIR DE
	$envio_gratis = 30000;
	//12 CUOTAS
	$cuotas_12 = 2500000;
	//activar o desactivar el carrito de compras
	$activeCart = true;

	//head.php configuracion de google
	// $idTagManager = "G-LVHPCQTS1B";
	$idTagManager = "<!-- Google tag (gtag.js) -->
<script async src=\"https://www.googletagmanager.com/gtag/js?id=G-LVHPCQTS1B\"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-LVHPCQTS1B');
</script>
<script async src=\"https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1385318809837552\" crossorigin=\"anonymous\"></script>";
	// $idPubClient = "ca-pub-1385318809837552";


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
