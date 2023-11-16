<?php
	require_once "config.php";
	require_once "convertImageTmp.php";
	require_once 'classes/DatabasePDOInstance.function.php';
	$db = DatabasePDOInstance();

//OBTENER ID DE CATEGORIA
$mla = $id_categoria != "" ? substr($id_categoria, 0, 3) : $mla;
$offset = isset($_REQUEST["offset"])? $_REQUEST["offset"] : '';
$limit = isset($_REQUEST["limit"])? $_REQUEST["limit"] : '15';
$sort = isset($_REQUEST["sort"])? $_REQUEST["sort"] : 'relevance';
$brand = isset($_REQUEST["BRAND"])? $_REQUEST["BRAND"] : '';


//OBTENER CATEGORIAS
$url = "https://api.mercadolibre.com/categories/".$id_categoria;
$categorias = curl($url);
$info = json_decode($categorias);
$children_categories = isset($info->children_categories)? $info->children_categories : '';


?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Categorías</title>
    <?php include_once'head.php';?>
	
</head>

<body>
    <?php include_once'menu.php';?>
	
    <section id="producto" class="py-3">
        <div class="container">
            <div class="row my-5">
			
			<?php
				foreach ($children_categories as &$children) {
					$newUriCat = sannedStr($children->name)."/".substr($children->id, 3);
					?>

					<div class="col-md-6">
						<ul class="list-group my-3">
							<li class="list-group-item fs-4 fw-bold text-uppercase"><a href="/categoria/<?php echo $newUriCat;?>" class="text-dark d-block list-group-item-action d-flex justify-content-between align-items-center text-capitalize"><span><?php echo $children->name;?></span> <span class="badge badge-pill bg-info bg-gradient"><?php echo $children->total_items_in_this_category;?></span></a></li>
							<?php 
							//OBTENER SUBCATEGORIAS
							$url = "https://api.mercadolibre.com/categories/".$children->id;
							$subcategorias2 = curl($url);
							$info3 = json_decode($subcategorias2);
							$subcategorias = isset($info3->children_categories)? $info3->children_categories : '';
							foreach ($subcategorias as &$children) {
								$newUriCat = sannedStr($children->name)."/".substr($children->id, 3);
								echo '<li class="list-group-item"><a href="/categoria/'.$newUriCat.'" class="d-block list-group-item-action d-flex justify-content-between align-items-center text-capitalize"><span>'.$children->name.'</span> <span class="badge badge-pill bg-warning bg-gradient">'.$children->total_items_in_this_category.'</span></a></li>';
							}
							?>
							
						</ul>
					</div>
			<?php }?>
                
            </div>
        </div>
    </section>

<?php include_once'footer.php';?>