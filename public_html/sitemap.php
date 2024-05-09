<?php header('Content-type: application/xml; charset=utf-8'); ?>
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

echo "<?xml version='1.0' encoding='UTF-8'?>
<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>
	";

echo "<url>
		<loc>https://".$_SERVER['HTTP_HOST']."</loc>
		<lastmod>2023-11-16</lastmod>
		<changefreq>weekly</changefreq>
		<priority>0.9</priority>
	</url>
	";
	
foreach ($children_categories as &$children) {
	$newUriCat = sannedStr($children->name)."/".substr($children->id, 3);
	
	echo "<url>
		<loc>https://".$_SERVER['HTTP_HOST']."/categoria/".$newUriCat."</loc>
		<lastmod>2023-11-16</lastmod>
		<changefreq>weekly</changefreq>
		<priority>0.9</priority>
	</url>
	";
	//OBTENER SUBCATEGORIAS
	$url = "https://api.mercadolibre.com/categories/".$children->id;
	$subcategorias2 = curl($url);
	$info3 = json_decode($subcategorias2);
	$subcategorias = isset($info3->children_categories)? $info3->children_categories : '';
	foreach ($subcategorias as &$children) {
		$newUriCat = sannedStr($children->name)."/".substr($children->id, 3);
		echo "<url>
		<loc>https://".$_SERVER['HTTP_HOST']."/categoria/".$newUriCat."</loc>
		<lastmod>2023-11-16</lastmod>
		<changefreq>weekly</changefreq>
		<priority>0.9</priority>
	</url>
	";
	}
}
//AGREGAR LISTA DE PRODUCTOS Y KEYWORDS GUARDADAS

$products = db_select_all("items", "*", "");
$keywords = db_select_all("keywords", "*", "");
foreach ($products as $p) {
	echo "<url>
		<loc>https://".$_SERVER['HTTP_HOST']."/producto"."/".sannedStr($p["title"])."-".substr($p["product"], 3)."</loc>
		<lastmod>".date("Y-m-d", strtotime($p["date"]))."</lastmod>
		<changefreq>weekly</changefreq>
		<priority>0.9</priority>
	</url>
	";
}
foreach ($keywords as $p) {
	echo "<url>
		<loc>https://".$_SERVER['HTTP_HOST']."/productos"."/".sannedStr($p["title"])."/"."</loc>
		<lastmod>".date("Y-m-d", strtotime($p["date"]))."</lastmod>
		<changefreq>weekly</changefreq>
		<priority>0.9</priority>
	</url>
	";
}

echo '
</urlset>';
?>
