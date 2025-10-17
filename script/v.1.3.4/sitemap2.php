<?php header("Content-Type: text/plain");?>
<?php
require_once "config.php";
require_once "convertImageTmp.php";
require_once 'classes/DatabasePDOInstance.function.php';
$db = DatabasePDOInstance();


//OBTENER CATEGORIAS
$url = "https://api.mercadolibre.com/categories/".$id_categoria;
$categorias = curl($url);
$info = json_decode($categorias);
$children_categories = isset($info->children_categories)? $info->children_categories : '';


echo "https://".$_SERVER['HTTP_HOST']."\n";
	
foreach ($children_categories as &$children) {
	$newUriCat = sannedStr($children->name)."/".substr($children->id, 3);
	
	echo "https://".$_SERVER['HTTP_HOST']."/categoria/".$newUriCat."\n";
	//OBTENER SUBCATEGORIAS
	$url = "https://api.mercadolibre.com/categories/".$children->id;
	$subcategorias2 = curl($url);
	$info3 = json_decode($subcategorias2);
	$subcategorias = isset($info3->children_categories)? $info3->children_categories : '';
	foreach ($subcategorias as &$children) {
		$newUriCat = sannedStr($children->name)."/".substr($children->id, 3);
		echo "https://".$_SERVER['HTTP_HOST']."/categoria/".$newUriCat."\n";
	}
}

?>
