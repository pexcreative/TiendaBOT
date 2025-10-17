<?php
	require_once "config.php";
	require_once "convertImageTmp.php";
	require_once 'classes/DatabasePDOInstance.function.php';
	$db = DatabasePDOInstance();

	if(isset($_REQUEST['s']) && $_REQUEST['s'] != "") {
		$_REQUEST['s'] = implode(" ", explode('-', $_REQUEST['s']));
		$_REQUEST['s'] = implode(" ", explode('/', $_REQUEST['s']));
	}

	if(isset($_REQUEST['cat']) && $_REQUEST['cat'] != "") {
		$_REQUEST['id'] = $mla.$_REQUEST['cat'];
	}
 
	$id_categoria = isset($_REQUEST["id"])? $_REQUEST["id"] : $id_categoria;
	$search = isset($_REQUEST["s"])? $_REQUEST["s"] : '';

	$catInfo = db_select_row("categories", "*", "category = '$id_categoria'");
	$searchInfo = db_select_row("keywords", "*", "keyword = '$search'");


//OBTENER ID DE CATEGORIA

$mla = $id_categoria != "" ? substr($id_categoria, 0, 3) : $mla;
$offset = isset($_REQUEST["offset"])? $_REQUEST["offset"] : '';
$limit = isset($_REQUEST["limit"])? $_REQUEST["limit"] : '15';
$sort = isset($_REQUEST["sort"])? $_REQUEST["sort"] : 'relevance';
$brand = isset($_REQUEST["BRAND"])? $_REQUEST["BRAND"] : '';

$forma_bateria = isset($_REQUEST["CELL_BATTERY_SHAPE"])? $_REQUEST["CELL_BATTERY_SHAPE"] : '';
$tamano_bateria = isset($_REQUEST["CELL_BATTERY_SIZE"])? $_REQUEST["CELL_BATTERY_SIZE"] : '';
$es_recargable = isset($_REQUEST["IS_RECHARGEABLE"])? $_REQUEST["IS_RECHARGEABLE"] : '';
$brand = isset($_REQUEST["BRAND"])? $_REQUEST["BRAND"] : '';

//TRADUCCION DE WIDGET
include_once('traduccion.php');

$url = "https://api.mercadolibre.com/sites/$mla/search?category=".$id_categoria."&limit=".$limit."&offset=".$offset."&sort=".$sort."&condition=new";

//SI NO HAY CATEGORIA PERO HAY KEYWORD ENTONCES CAMBIAR URL
if($search != ''){
	$search = urlencode($search);
	$url = "https://api.mercadolibre.com/sites/$mla/search?q=$search&limit=".$limit."&offset=".$offset."&sort=".$sort."&condition=new";
}

foreach($_REQUEST as $k => $req) {
	if(substr($k, 0, 2) == "__") {
		$url .= "&" . implode("", explode("__", $k)) . "=" . urlencode(urldecode($req));
	}
}

//CONSULTANDO PRODUCTOS DE UNA CATEGORIA
//echo $url;
$sitioweb = curl($url);
$info = json_decode($sitioweb);
//var_dump($sitioweb);
//echo $url; die();

$paginas = isset($info->paging->total)? $info->paging->total : '';
$catego = isset($info->filters[0]->values[0]->name)? $info->filters[0]->values[0]->name : '';

//PRODUCTOS
$results = isset($info->results)? $info->results : '';
if(!isset($info->results)) {
	header('Location: https://'.$_SERVER['HTTP_HOST']);
}
else {
	if(count($info->results) == 0) {
		header('Location: https://'.$_SERVER['HTTP_HOST']);
	}
}
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
$categoria_principal = isset($info3->path_from_root[0]->id)? $info3->path_from_root[0]->id : '';
$caterories = isset($info3->path_from_root)? $info3->path_from_root : '';
$children_categories = isset($info3->children_categories)? $info3->children_categories : '';


	$desc = "";
	if($catInfo) {
		if($catInfo["title"] && $catInfo["title"] != "") {
			$catego = $catInfo["title"];
		}
		if($catInfo["description"] && $catInfo["description"] != "") {
			$desc = $catInfo["description"];
		}
	}
	foreach($filterRemoveWords as $word) {
		$desc = implode("", explode($word, $desc));
	}

	if($search != ''){
		$catego = urldecode($search);
	}
	if($searchInfo) {
		if($searchInfo["title"] && $searchInfo["title"] != "") {
			$catego = $searchInfo["title"];
		}
		if($searchInfo["description"] && $searchInfo["description"] != "") {
			$desc = $searchInfo["description"];
		}
	}

?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<meta name="description" content="<?php echo $metaDescription;?>">
    <title><?php echo $catego;?></title>
    <?php include_once'head.php';?>
	
</head>

<body>
    <?php include_once'menu.php';?>
	
    <section id="producto" class="py-3">
        <div class="container">
			<?php if($caterories){?>
            <ol class="breadcrumb text-capitalize p-2 ps-3 rounded">
                <li class="breadcrumb-item"><a href="/" title="Home"><span><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-house-fill"><path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"></path><path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z"></path></svg></span></a></li>
                <!-- <li class="breadcrumb-item"><a href="#"><span>Electrónica, Audio y Video</span></a></li>-->
				<?php
					foreach ($caterories as &$categoria) {
						//$newUriCat = $categoria->id;
						$newUriCat = sannedStr($categoria->name)."/".substr($categoria->id, 3);
						echo '<li class="breadcrumb-item"><a href="/categoria/'.$newUriCat.'" class="link-underline-primary"><span>'.$categoria->name.'</span></a></li>';
					}
				?>
            </ol>
			<?php }?>
            <div class="row">
                <div class="col-12">
                    <h1 class="text-capitalize fs-3">
						<span class="titleLabel"><?php echo $catego;?></span>
						<?php if(isset($_SESSION["P3xN3w"])): ?>
							<a href="javascript: void(0);" data-bs-toggle="modal" data-bs-target="#mdEdit">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
								<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
								<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
							</svg>
							</a>
						<?php endif ?>
					</h1>
                    <div class="descLabel mb-0">
						<?php echo $desc; ?>
					</div>
					<div class="google-sidebar text-center"><?php echo $adsense_categoria;?></div>
                </div>
				<?php
					$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
					$a = array('&sort=relevance','&sort=price_asc','&sort=price_desc');
					$b = array('');
					$str = $actual_link;
					$actual_link = @str_replace($a,$b,$str);
				?>
                <div class="col p-0">
                    <div class="dropdown mb-1">
						<button class="btn btn-primary btn-sm dropdown-toggle rounded text-black" aria-expanded="false" data-bs-toggle="dropdown" type="button">Ordenar&nbsp;</button>
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
							$precio = $producto->price;
							//PORCENTAJE DE GANANCIAS
							include('ganancia.php');
							
							//CONSULTANDO DATOS DEL ITEM
							$url = "https://api.mercadolibre.com/items/".$id;
							$sitioweb = curl($url);
							$sitioweb = file_get_contents($url);
							$info = json_decode($sitioweb);
							$imagen_principal = isset($info->pictures[0]->secure_url)? $info->pictures[0]->secure_url : 'assets/img/sin-imagen.png';
							$condition = isset($info->condition)? $info->condition : '';
							?>
							<?php if($condition == 'new')
								$urlNew = "producto/".sannedStr($title)."-".substr($id, 3);
							{?>
							<div class="col-12 list-group-item rounded" onclick="location.href = &#39;/<?php echo $urlNew;?>&#39;">
                            <div class="text-center p-2">
                                <div class="row">
                                    <div class="col-md-3"><a class="list-product" href="/<?php echo $urlNew;?>"><img data-bss-hover-animate="tada" loading="lazy" class="producto list-product rounded img-fluid" src="<?php echo 
									$imagen_principal;?>" alt="<?php echo $title;?>" width="250" height="250"></a></div>
                                    <div class="col text-start pt-3">
										<a href="/<?php echo $urlNew;?>"><h2 class="text-capitalize fs-5 text-primary"><?php echo $title;?></h2></a>
                                        <p class="fs-5 sombra mb-0 <?php filtro_ocultar($categoria_principal);?>">$<?php echo number_format($precio,0,",",".");?></p>
                                        
										<?php if($precio >= $cuotas_12){?>
										<p class="text-success mb-0 <?php filtro_ocultar($categoria_principal);?>"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-credit-card-2-back fs-5 me-1"><path d="M11 5.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1z"></path><path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2zm13 2v5H1V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm-1 9H2a1 1 0 0 1-1-1v-1h14v1a1 1 0 0 1-1 1z"></path></svg>12 cuotas de $<?php echo number_format(($precio/12),0,",",".");?></p>
										<?php }?>
										<?php if($precio >= $envio_gratis){?>
										<p class="text-success mb-0 <?php filtro_ocultar($categoria_principal);?>"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-truck fs-5 me-1">
                                                <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"></path>
                                            </svg>Consulta por Envío gratis</p>
										<?php }?>	
                                    </div>
                                </div>
                            </div>
                        </div>
							<?php }?>
						<?php }?>
                    </div>
					<?php if($paginas >= 50){?>
                    <nav class="d-flex justify-content-center my-3">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" aria-label="Previous" href="#"><span aria-hidden="true">«</span></a></li>
                            <li class="page-item"><a class="page-link" href="<?php echo $actual_link;?>&offset=0">1</a></li>
                            <li class="page-item"><a class="page-link" href="<?php echo $actual_link;?>&offset=15">2</a></li>
                            <li class="page-item"><a class="page-link" href="<?php echo $actual_link;?>&offset=30">3</a></li>
							<li class="page-item"><a class="page-link" href="<?php echo $actual_link;?>&offset=45">4</a></li>
                            <li class="page-item"><a class="page-link" aria-label="Next" href="#"><span aria-hidden="true">»</span></a></li>
                        </ul>
                    </nav>
					<?php }?>
                </div>
				<!-- SIDEBAR -->
                <div class="col-md-3">
					<div class="mb-3 p-2 google-sidebar"><?php echo $adsense_sidebar;?></div>
					<?php if($children_categories && $search == ''){?>
                    <h3 class="fs-5 p-2 bg-warning bg-gradient text-dark rounded mb-1">Categorias</h3>
                    <ul class="text-capitalize list-unstyled ps-2 list-group mb-2">
						<?php foreach ($children_categories as &$children) {
							$newUriCat = sannedStr($children->name)."/".substr($children->id, 3);
							echo '<li><a href="/categoria/'.$newUriCat.'" class="list-group-item text-black">'.$children->name.'</a></li>';
						}?>
                    </ul>
					<?php }?>
					
					
					
					<?php
						foreach($filtros as &$filter): 
							if(ctype_upper(implode("", explode("_", $filter->id))) && !in_array($filter->id, $escapeIds)):
				?>
								<h3 class="fs-5 p-2 bg-warning bg-gradient text-dark rounded mb-1 <?php echo $filter->id; ?>"><?php echo getWord($filter->name); ?></h3>
								<ul class="text-capitalize list-unstyled ps-2 list-group mb-2">
				<?php
								for($ind = 0; $ind < (count($filter->values) <= 10 ? count($filter->values) : 10); $ind++):
									$idTmp = urlencode($filter->values[$ind]->id);
				?>
								<li><a href="<?php echo $actual_link;?>&__<?php echo $filter->id; ?>=<?php echo $idTmp; ?>" class="list-group-item text-black"> <?php echo $filter->values[$ind]->name." <span class='d-none'>(".$filter->values[$ind]->results.")</span>"; ?> </a></li>
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
	<?php if(isset($_SESSION["P3xN3w"])): ?>
	<div class="modal" tabindex="-1" id="mdEdit">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Modificar propiedades</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="mb-3">
					<label for="titleForm" class="form-label">Titulo</label>
					<input type="text" class="form-control" id="titleForm" placeholder="<?php echo $catego; ?>" value="<?php echo $catego; ?>">
				</div>
				<div class="mb-3">
					<label for="descForm" class="form-label">Descripcion</label>
					<textarea class="form-control" id="descForm" rows="8" placeholder="<?php echo $desc; ?>"><?php echo $desc; ?></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary closeModal" data-bs-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary" id="saveInfo" onclick="saveInfo(this);" data-s="<?php echo $search != "" ? 1 : 0; ?>">Guardar</button>
			</div>
			</div>
		</div>
	</div>

	<script>

		var idp = "<?php echo $id_categoria; ?>";
		var search = "<?php echo $search; ?>";
		function saveInfo(el) {
			$("#saveInfo").attr("disabled", true);
			$("#saveInfo").addClass("disabled");
			$.ajax({
				type: 'POST',
				url: '/server/',
				data: 'o=3&t='+$("#titleForm").val()+'&d='+$("#descForm").val()+'&i='+(search != "" ? search : idp)+'&s=' + $(el).attr("data-s"),
				dataType: 'json',
				success: function(data) {
					var title = $("#titleForm").val();
					var desc = $("#descForm").val();
					$(".titleLabel").html(title);
					$(".descLabel").html(desc);
					$("#saveInfo").attr("disabled", false);
					$("#saveInfo").removeClass("disabled");
					$(".closeModal").trigger("click");
					$("#titleForm").val(title).attr("placeholder", title);
					//$("#descForm").val(desc).attr("placeholder", desc);
				}
			});
		}
		
	</script>

	<?php endif ?>
	
<?php include_once'footer.php';?>