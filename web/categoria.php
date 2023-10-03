<?php
function curl($url) {
	$ch = curl_init($url); // Inicia sesión cURL
	curl_setopt($ch, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)'); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Configura cURL para devolver el resultado como cadena
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
	$info = curl_exec($ch); // Establece una sesión cURL y asigna la información a la variable $info
	curl_close($ch); // Cierra sesión cURL
	return $info; // Devuelve la información de la función
}

//OBTENER ID DE CATEGORIA
$id_categoria = isset($_REQUEST["id"])? $_REQUEST["id"] : '';
$mla = $id_categoria != "" ? substr($id_categoria, 0, 3) : "MLA";
$offset = isset($_REQUEST["offset"])? $_REQUEST["offset"] : '';
$limit = isset($_REQUEST["limit"])? $_REQUEST["limit"] : '15';
$sort = isset($_REQUEST["sort"])? $_REQUEST["sort"] : 'relevance';
$brand = isset($_REQUEST["BRAND"])? $_REQUEST["BRAND"] : '';

$forma_bateria = isset($_REQUEST["CELL_BATTERY_SHAPE"])? $_REQUEST["CELL_BATTERY_SHAPE"] : '';
$tamano_bateria = isset($_REQUEST["CELL_BATTERY_SIZE"])? $_REQUEST["CELL_BATTERY_SIZE"] : '';
$es_recargable = isset($_REQUEST["IS_RECHARGEABLE"])? $_REQUEST["IS_RECHARGEABLE"] : '';
$brand = isset($_REQUEST["BRAND"])? $_REQUEST["BRAND"] : '';

//ELIMINAR LAS WIDGET
$escapeIds = array("ITEM_CONDITION","MOBILE_NETWORK","WITH_FACIAL_RECOGNITION","WITH_FAST_CHARGING","WITH_FINGERPRINT_READER","WITH_GPS","WITH_GYROSCOPE", "WITH_MEMORY_CARD_SLOT","WITH_RADIO");

$url = "https://api.mercadolibre.com/sites/$mla/search?category=".$id_categoria."&limit=".$limit."&offset=".$offset."&sort=".$sort."";

foreach($_REQUEST as $k => $req) {
	if(substr($k, 0, 2) == "__") {
		$url .= "&" . implode("", explode("__", $k)) . "=" . $req;
	}
}

//CONSULTANDO PRODUCTOS DE UNA CATEGORIA

/*if($brand){
	$url = $url."&BRAND=".$brand;
}
if($forma_bateria){
	$url = $url."&CELL_BATTERY_SHAPE=".$forma_bateria;
}
if($tamano_bateria){
	$url = $url."&CELL_BATTERY_SIZE=".$tamano_bateria;
}
if($es_recargable){
	$url = $url."&IS_RECHARGEABLE=".$es_recargable;
}*/

//echo $url;
$sitioweb = curl($url);
$info = json_decode($sitioweb);
$paginas = isset($info->paging->total)? $info->paging->total : '';
$catego = isset($info->filters[0]->values[0]->name)? $info->filters[0]->values[0]->name : 'Por favor ingresa una catoría';
//PRODUCTOS
$results = isset($info->results)? $info->results : '';
// FILTROS
// print_r ($info->available_filters);
$filtro_marcas = isset($info->available_filters[13]->values)? $info->available_filters[13]->values : '';
// $marca = isset($_REQUEST["marca"])? $_REQUEST["marca"] : '3';
// $filtro_marcas = $info->available_filters[$marca]->values;
$filtros = isset($info->available_filters)? $info->available_filters : array();
$i = 0;
/*foreach ($filtros as &$filtro) {
	echo $i++."-";
	echo $filtro->id."<br>";
	
}*/


//OBTENER CATEGORIAS DEL PRODUCTO
$url3 = "https://api.mercadolibre.com/categories/".$id_categoria;
$categorias = curl($url3);
$info3 = json_decode($categorias);
$caterories = isset($info3->path_from_root)? $info3->path_from_root : '';

?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo $catego;?></title>
    <?php include_once'head.php';?>
	
</head>

<body>
    <?php include_once'menu.php';?>
	
    <section id="producto" class="py-3">
        <div class="container">
			<?php if($caterories){?>
            <ol class="breadcrumb text-capitalize p-2 ps-3 rounded">
                <li class="breadcrumb-item"><a href="/"><span><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-house-fill">
                                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"></path>
                                <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z"></path>
                            </svg></span></a></li>
                <!-- <li class="breadcrumb-item"><a href="#"><span>Electrónica, Audio y Video</span></a></li>-->
				<?php
					foreach ($caterories as &$categoria) {
						echo '<li class="breadcrumb-item"><a href="/categoria.php?id='.$categoria->id.'"><span>'.$categoria->name.'</span></a></li>';
					}
				?>
            </ol>
			<?php }?>
            <div class="row">
                <div class="col-12">
                    <h1 class="text-capitalize fs-3"><?php echo $catego;?></h1>
                    <p>Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen.</p>
                </div>
				<?php
					$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
					$a = array('&sort=relevance','&sort=price_asc','&sort=price_desc');
					$b = array('');
					$str = $actual_link;
					$actual_link = @str_replace($a,$b,$str);
				?>
                <div class="col p-0">
                    <div class="dropdown mb-1"><button class="btn btn-primary btn-sm dropdown-toggle rounded" aria-expanded="false" data-bs-toggle="dropdown" type="button">Ordenar&nbsp;</button>
                        <div class="dropdown-menu">
							<a class="dropdown-item" href="<?php echo $actual_link;?>&sort=relevance">Más Relevantes</a>
							<a class="dropdown-item" href="<?php echo $actual_link;?>&sort=price_asc">Menor precio</a>
							<a class="dropdown-item" href="<?php echo $actual_link;?>&sort=price_desc">Mayor precio</a>
						</div>
                    </div>
                </div>
				
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div class="row list-group">
					<?php 
						foreach ($results as &$producto) {
							$id = $producto->id;
							$title = $producto->title;
							$price = $producto->price;
							//CONSULTANDO DATOS DEL ITEM
							$url = "https://api.mercadolibre.com/items/".$id;
							$sitioweb = curl($url);
							$info = json_decode($sitioweb);
							$imagen_principal = isset($info->pictures[0]->secure_url)? $info->pictures[0]->secure_url : 'assets/img/sin-imagen.png';
							?>
							<div class="col-12 p-0 list-group-item rounded" onclick="location.href = &#39;item.php?id=<?php echo $id;?>&#39;">
                            <div class="text-center p-2">
                                <div class="row">
                                    <div class="col-md-3"><a class="list-product" href="item.php?id=<?php echo $id;?>"><img data-bss-hover-animate="tada" class="producto list-product rounded" src="<?php echo $imagen_principal ;?>" alt="<?php echo $title;?>" height="160" width="160"></a></div>
                                    <div class="col text-start pt-3">
										<a href="item.php?id=<?php echo $id;?>"><h2 class="text-capitalize fs-5 text-primary"><?php echo $title;?></h2></a>
                                        <p class="fs-5 sombra mb-0">$<?php echo number_format($price,0,",",".");?></p>
                                        
										<?php if($price >= 250000){?>
										<p class="text-success mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-credit-card-2-back fs-5 me-1"><path d="M11 5.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1z"></path><path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2zm13 2v5H1V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm-1 9H2a1 1 0 0 1-1-1v-1h14v1a1 1 0 0 1-1 1z"></path></svg>12 cuotas de $<?php echo number_format(($price/12),0,",",".");?></p>
										<?php }?>
										<?php if($price >= 10000){?>
										<p class="text-success mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-truck fs-5 me-1">
                                                <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"></path>
                                            </svg>Consulta por Envío gratis</p>
										<?php }?>	
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php }?>
                    </div>
					<?php if($paginas >= 50){?>
                    <nav class="d-flex justify-content-center my-3">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" aria-label="Previous" href="#"><span aria-hidden="true">«</span></a></li>
                            <li class="page-item"><a class="page-link" href="/categoria.php?id=<?php echo $id_categoria;?>&offset=0">1</a></li>
                            <li class="page-item"><a class="page-link" href="/categoria.php?id=<?php echo $id_categoria;?>&offset=15">2</a></li>
                            <li class="page-item"><a class="page-link" href="/categoria.php?id=<?php echo $id_categoria;?>&offset=30">3</a></li>
							<li class="page-item"><a class="page-link" href="/categoria.php?id=<?php echo $id_categoria;?>&offset=45">4</a></li>
                            <li class="page-item"><a class="page-link" aria-label="Next" href="#"><span aria-hidden="true">»</span></a></li>
                        </ul>
                    </nav>
					<?php }?>
                </div>
				<!-- SIDEBAR -->
                <div class="col-md-3">

					

                    <h3 class="fs-2">Categorias</h3>
                    <ul class="text-capitalize list-unstyled ps-2">
						<?php foreach ($caterories as &$categoria) {
							echo '<li><a href="/categoria.php?id='.$categoria->id.'" class="text-black">'.$categoria->name.'</a></li>';
						}?>
                    </ul>
					
					<?php
						foreach($filtros as &$filter):
							if(ctype_upper(implode("", explode("_", $filter->id))) && !in_array($filter->id, $escapeIds)):
				?>
								<h3 class="fs-5"><?php echo $filter->id; ?></h3>
								<ul class="text-capitalize list-unstyled ps-2">
				<?php
								for($ind = 0; $ind < (count($filter->values) <= 10 ? count($filter->values) : 10); $ind++):
				?>
								<li><a href="/categoria.php?id=<?php echo $id_categoria; ?>&__<?php echo $filter->id; ?>=<?php echo $filter->values[$ind]->id; ?>" class="text-black"><?php echo $filter->values[$ind]->name." (".$filter->values[$ind]->results.")"; ?> </a></li>
				<?php
								endfor;
				?>
				</ul>
				<?php
							endif;
						endforeach;
					?>
                </div>
				
            </div>
        </div>
    </section>
	
<?php include_once'footer.php';?>