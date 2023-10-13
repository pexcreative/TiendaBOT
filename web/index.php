<?php
	session_start();
	require_once 'classes/Password.php';
	require_once 'classes/DatabasePDOInstance.function.php';
	$db = DatabasePDOInstance();
	

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
$id_categoria = 'MLA1000';
$titulo = "Electrónica, Audio y Video";
$keyword = "tv smart";
$descripcion_google = 'Consigue los mejores precios para Electrónica, Audio y Video';

$mla = $id_categoria != "" ? substr($id_categoria, 0, 3) : "MLA";
$limit = isset($_REQUEST["limit"])? $_REQUEST["limit"] : '4';


$url = "https://api.mercadolibre.com/sites/$mla/search?category=".$id_categoria."&limit=".$limit;

//CONSULTANDO PRODUCTOS DE UNA CATEGORIA
// echo $url;
$sitioweb = curl($url);
$info = json_decode($sitioweb);
$paginas = isset($info->paging->total)? $info->paging->total : '';
$catego = isset($info->filters[0]->values[0]->name)? $info->filters[0]->values[0]->name : 'Por favor ingresa una catoría';
//PRODUCTOS
$results = isset($info->results)? $info->results : '';
// FILTROS
// print_r ($info->available_filters);

//CONSULTANDO PRODUCTOS DE UNA KEYWORD
// echo $url;
$limit = $limit*3;
$keyword = urlencode($keyword);
$url_keyword = "https://api.mercadolibre.com/sites/$mla/search?q=$keyword&limit=".$limit;
// echo $url_keyword;
$sitioweb2 = curl($url_keyword);
$info2 = json_decode($sitioweb2);
$results2 = isset($info2->results)? $info2->results : '';

//CONSULTANDO KEYWORD ALTERNATIVAS
$keyword_alternative = "https://http2.mlstatic.com/resources/sites/$mla/autosuggest?showFilters=true&limit=11&api_version=2&q=$keyword";
// echo $keyword_alternative;
$sitioweb3 = curl($keyword_alternative);
$info3 = json_decode($sitioweb3);
$results3 = isset($info3->suggested_queries)? $info3->suggested_queries : '';

?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<meta name="description" content="<?php echo $descripcion_google;?>">
    <title><?php echo $titulo;?></title>
	<?php include_once'head.php';?>
	
</head>

<body>
    <?php include_once'menu.php';?>
	
    <section id="producto" class="py-3">
        <div class="container">
            <div class="row mt-3">
                <div class="col">
                    <div class="carousel slide" data-bs-ride="carousel" id="carousel-1">
                        <div class="carousel-inner">
                            <div class="carousel-item active"><img class="w-100 d-block" src="assets/img/1.webp" alt="<?php echo $results3[1]->q;?>"></div>
                            <div class="carousel-item"><img class="w-100 d-block" src="assets/img/2.webp" alt="<?php echo $results3[3]->q;?>"></div>
                            <div class="carousel-item"><img class="w-100 d-block" src="assets/img/3.webp" alt="<?php echo $results3[5]->q;?>"></div>
                            <div class="carousel-item"><img class="w-100 d-block" src="assets/img/4.webp" alt="<?php echo $results3[7]->q;?>"></div>
                            <div class="carousel-item"><img class="w-100 d-block" src="assets/img/5.webp" alt="<?php echo $results3[9]->q;?>"></div>
                        </div>
                        <div><a class="carousel-control-prev" href="#carousel-1" role="button" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span><span class="visually-hidden">Previous</span></a><a class="carousel-control-next" href="#carousel-1" role="button" data-bs-slide="next"><span class="carousel-control-next-icon"></span><span class="visually-hidden">Next</span></a></div>
                        <div class="carousel-indicators"><button type="button" data-bs-target="#carousel-1" data-bs-slide-to="0" class="active"></button> <button type="button" data-bs-target="#carousel-1" data-bs-slide-to="1"></button> <button type="button" data-bs-target="#carousel-1" data-bs-slide-to="2"></button> <button type="button" data-bs-target="#carousel-1" data-bs-slide-to="3"></button> <button type="button" data-bs-target="#carousel-1" data-bs-slide-to="4"></button></div>
                    </div>
                </div>
            </div>
            <div class="row mt-4 mb-4">
                <div class="col-md-4"><a href="/categoria.php?s=aire Acondicionado">
                        <div class="card rounded producto-relacionado">
							<img class="card-img-top w-100 d-block" alt="<?php echo $results3[0]->q;?>" src="assets/img/D_NQ_NP737077-MLA43145775567_082020-B.webp">
                            <p class="text-center h4 text-uppercase">Aire Acondicionado</p>
                        </div>
                    </a></div>
                <div class="col-md-4"><a href="/categoria.php?s=aires Inverter">
                        <div class="card rounded producto-relacionado">
							<img class="card-img-top w-100 d-block" alt="<?php echo $results3[1]->q;?>" src="assets/img/D_NQ_NP988455-MLA43145987130_082020-B.webp">
                            <p class="text-center h4 text-uppercase">Aires Inverter</p>
                        </div>
                    </a></div>
                <div class="col-md-4"><a href="/categoria.php?s=calefaccion">
                        <div class="card rounded producto-relacionado">
							<img class="card-img-top w-100 d-block" alt="<?php echo $results3[2]->q;?>" src="assets/img/D_NQ_NP617229-MLA49984275554_052022-B.webp">
                            <p class="text-center h4 text-uppercase">Calefacción</p>
                        </div>
                    </a></div>
            </div>
            <div class="row my-4">
                <div class="col-12">
                    <h1 class="text-uppercase fs-3 fw-bold sombra-2 text-center text-dark"><?php echo $titulo;?></h1>
                </div>
				
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
				<div class="col-md-3">
					<div class="text-center border bg-white p-2 rounded mb-3 producto-relacionado" onclick="location.href = &#39;item.php?id=<?php echo $id;?>&#39;">
						<img class="img-fluid list-product" data-bss-hover-animate="tada" alt="<?php echo $title;?>" src="<?php echo $imagen_principal ;?>">
						<a href="/item.php?id=<?php echo $id;?>"><h4 class="fs-6 fw-bold text-primary sombra mb-0"><?php echo $title;?></h4></a>
						<?php if($price >= 10000){?>
						<p class="text-success mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-truck fs-5 me-1">
								<path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"></path>
							</svg>Consulta por Envío gratis</p>
						<?php }?>
						<p class="sombra mb-0 fw-bold">$<?php echo number_format($price,0,",",".");?></p>
                    </div>
                </div>
				<?php }?>
				
            </div>
            <div class="row">
                <div class="col-md-5"><a href="/categoria.php?s=cafetera">
                        <div class="card producto-relacionado" style="background: url(&quot;assets/img/electrodomesticos.jpg&quot;) left / cover no-repeat;height: 235px;"></div>
                    </a></div>
                <div class="col-md-4"><a href="/categoria.php?s=heladeras">
                        <div class="card bg-white rounded producto-relacionado" style="background: url(&quot;assets/img/heladeras.jpg&quot;) bottom / contain no-repeat;height: 235px;"></div>
                    </a></div>
                <div class="col-md-3"><a class="producto-relacionado" href="/categoria.php?s=lavarropas">
                        <div class="card bg-white rounded producto-relacionado" style="background: url(&quot;assets/img/lavarropas.jpg&quot;) bottom / contain no-repeat;height: 235px;"></div>
                    </a></div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4"><a href="/categoria.php?s=cocina">
                        <div class="card producto-relacionado" style="background: url(&quot;assets/img/cocinas.jpg&quot;) left / cover no-repeat;height: 235px;"></div>
                    </a></div>
                <div class="col-md-2"><a href="/categoria.php?s=freezer">
                        <div class="card bg-white rounded producto-relacionado" style="background: url(&quot;assets/img/freezers.jpg&quot;) bottom / contain no-repeat;height: 235px;"></div>
                    </a></div>
                <div class="col-md-2"><a href="/categoria.php?s=horno">
                        <div class="card bg-white rounded producto-relacionado" style="background: url(&quot;assets/img/hornos.jpg&quot;) bottom / contain no-repeat;height: 235px;"></div>
                    </a></div>
                <div class="col-md-4"><a href="/categoria.php?s=microondas">
                        <div class="card producto-relacionado" style="background: url(&quot;assets/img/microondas.jpg&quot;) left / cover no-repeat;height: 235px;"></div>
                    </a></div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6"><a href="/categoria.php?s=tv smart">
                        <div class="card"><img class="card-img-top w-100 d-block" alt="<?php echo $results3[4]->q;?>" src="assets/img/12-cuotas-sin-interes.webp"></div>
                    </a></div>
                <div class="col-md-6"><a href="/categoria.php?s=aire acondicionado frio calor">
                        <div class="card"><img class="card-img-top w-100 d-block" alt="<?php echo $results3[5]->q;?>" src="assets/img/full-envios.webp"></div>
                    </a></div>
            </div>
            <div class="row my-4">
                <div class="col-12">
                    <h4 class="text-uppercase fs-3 fw-bold text-center sombra-2">Últimos productos</h4>
                </div>
				
				<?php 
				foreach ($results2 as &$producto) {
					$id = $producto->id;
					$title = $producto->title;
					$price = $producto->price;
					//CONSULTANDO DATOS DEL ITEM
					$url = "https://api.mercadolibre.com/items/".$id;
					$sitioweb = curl($url);
					$info = json_decode($sitioweb);
					$imagen_principal = isset($info->pictures[0]->secure_url)? $info->pictures[0]->secure_url : 'assets/img/sin-imagen.png';
					?>
				<div class="col-md-3">
					<div class="text-center border bg-white p-2 rounded mb-3 producto-relacionado" onclick="location.href = &#39;item.php?id=<?php echo $id;?>&#39;">
						<img class="img-fluid list-product" data-bss-hover-animate="tada" alt="<?php echo $title;?>" src="<?php echo $imagen_principal ;?>">
						<a href="/item.php?id=<?php echo $id;?>"><h4 class="fs-6 fw-bold text-primary sombra mb-0"><?php echo $title;?></h4></a>
						<?php if($price >= 10000){?>
						<p class="text-success mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-truck fs-5 me-1">
								<path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"></path>
							</svg>Envío gratis!</p>
						<?php }?>
						<p class="sombra mb-0 fw-bold">$<?php echo number_format($price,0,",",".");?></p>
                    </div>
                </div>
				<?php }?>

            </div>
        </div>
    </section>
	
    <div class="modal fade" role="dialog" tabindex="-1" id="buscar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Title</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>The content of your modal.</p>
                    <form><input class="form-control" type="search"><input class="form-control form-control-color" type="color">
                        <div class="input-group"><input class="form-control" type="text"><button class="btn btn-primary" type="button">Button</button></div>
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button">Save</button></div>
            </div>
        </div>
    </div>
	
	<?php include_once'footer.php';?>
	