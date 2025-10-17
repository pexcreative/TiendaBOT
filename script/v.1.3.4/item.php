<?php
    require_once "config.php";
    require_once "convertImageTmp.php";
    require_once 'classes/DatabasePDOInstance.function.php';
    $db = DatabasePDOInstance();

    $id_producto = isset($_REQUEST["id"])? $_REQUEST["id"] : 'MLA1114967856';

    if(strrpos($id_producto, "-") !== false) {
        $id_producto = $mla.substr($id_producto, strrpos($id_producto, "-")+1, strlen($id_producto));
        //echo $id_producto; die();
    }
    $itemInfo = db_select_row("items", "*", "product = '$id_producto'");

//OBTENER ID PRODUCTO

$mla = $id_producto != "" ? substr($id_producto, 0, 3) : $mla;

//CONSULTANDO DATOS DEL ITEM
$url = "https://api.mercadolibre.com/items/".$id_producto;
//echo $url;
//$sitioweb = file_get_contents($url);
$sitioweb = file_get_contents($url);

$info = json_decode($sitioweb);

//var_dump($info); die();

//echo $info->id."<br>";
$categorias = isset($info->category_id)? $info->category_id : '';
$titulo = isset($info->title)? $info->title : '';
$catalog_product_id = isset($info->catalog_product_id)? $info->catalog_product_id : '';
$permalink = isset($info->permalink)? $info->permalink : '';

// echo "PRECIO: ".$info->price;
$precio = isset($info->price)? $info->price : 0;


if($precio == 0) {
    // header("Location: https://$_SERVER[HTTP_HOST]");
}
$precioProducto = $precio;
$precioBase = $precio;
//echo $info->currency_id."<br>";
$currency_id = isset($info->currency_id)? $info->currency_id : '';
// echo $info->available_quantity."<br>";
$imagen_principal = isset($info->pictures[0]->secure_url)? $info->pictures[0]->secure_url : 'assets/img/sin-imagen.png';

$imagen2 = isset($info->pictures[1]->secure_url)? $info->pictures[1]->secure_url : '';
$imagen3 = isset($info->pictures[2]->secure_url)? $info->pictures[2]->secure_url : '';
$imagen4 = isset($info->pictures[3]->secure_url)? $info->pictures[3]->secure_url : '';
$imagen5 = isset($info->pictures[4]->secure_url)? $info->pictures[4]->secure_url : '';
$imagen6 = isset($info->pictures[5]->secure_url)? $info->pictures[5]->secure_url : '';
$imagen7 = isset($info->pictures[6]->secure_url)? $info->pictures[6]->secure_url : '';
$imagen8 = isset($info->pictures[7]->secure_url)? $info->pictures[7]->secure_url : '';
$imagen9 = isset($info->pictures[8]->secure_url)? $info->pictures[8]->secure_url : '';

//DESCRIPCION DEL PRODUCTO
$url2 = "https://api.mercadolibre.com/items/".$id_producto."/description";
$descripcion = curl($url2);
$info2 = json_decode($descripcion);
$descripcion = isset($info2->plain_text)? $info2->plain_text : '';
$descripcion_google = preg_replace("/[\r\n|\n|\r]+/", " ", $descripcion);
$descripcion_google = substr($descripcion_google, 0, 200);
$descripcion = nl2br($descripcion);
$descripcion = @str_replace($buscar, "", $descripcion);

//OBTENER CATEGORIAS DEL PRODUCTO
$url3 = "https://api.mercadolibre.com/categories/".$categorias;
$categorias = curl($url3);
$info3 = json_decode($categorias);
$categoria_principal = isset($info3->path_from_root[0]->id)? $info3->path_from_root[0]->id : '';
// echo $categoria_principal;
$caterories = isset($info3->path_from_root)? $info3->path_from_root : '';

//OBTENER ALTERNATIVAS DEL PRODUCTO
$url4 = 'https://api.mercadolibre.com/sites/'.$mla.'/search?q='.urlencode($titulo).'&limit=4&offset=2&condition=new';
$alternativas = curl($url4);
$info4 = json_decode($alternativas);
$alternativas = isset($info4->results)? $info4->results : '';



$alternative = "";

    $routeImg1 = "";
    $routeImg2 = "";
    $routeImg3 = "";
    $routeImg4 = "";
    $routeImg5 = "";
    $routeImg6 = "";
    $routeImg7 = "";
    $routeImg8 = "";
    $routeImg9 = "";

    if($itemInfo) {
        if($itemInfo["title"] && $itemInfo["title"] != "") {
            $titulo = $itemInfo["title"];
        }
        if($itemInfo["price"] && $itemInfo["price"] != "") {
            $precioProducto = $itemInfo["price"];
        }
        if($itemInfo["alternative"] && $itemInfo["alternative"] != "") {
            $alternative = $itemInfo["alternative"];
        }
        if($itemInfo["description"] && $itemInfo["description"] != "") {
            $descripcion = $itemInfo["description"];

            $name = sannedStr($titulo);
            //var_dump($name); die();
            // $routeImg1 = "/imagenes/productos/$name-1.webp";
            // $routeImg2 = "/imagenes/productos/$name-2.webp";
            // $routeImg3 = "/imagenes/productos/$name-3.webp";
            // $routeImg4 = "/imagenes/productos/$name-4.webp";
            // $routeImg5 = "/imagenes/productos/$name-5.webp";
            // $routeImg6 = "/imagenes/productos/$name-6.webp";
            // $routeImg7 = "/imagenes/productos/$name-7.webp";
            // $routeImg8 = "/imagenes/productos/$name-8.webp";
            // $routeImg9 = "/imagenes/productos/$name-9.webp";

            // if(!file_exists("imagenes/productos/$name-1.webp")) {
                // $routeImg1 = descargarYGuardarImagen($imagen_principal, "imagenes/productos", "$name-1");
            // }
            // if(!file_exists("imagenes/productos/$name-2.webp") && $imagen2) {
                // $routeImg2 = descargarYGuardarImagen($imagen2, "imagenes/productos", "$name-2");
            // }
            // if(!file_exists("imagenes/productos/$name-3.webp") && $imagen3) {
                // $routeImg3 = descargarYGuardarImagen($imagen3, "imagenes/productos", "$name-3");
            // }
            // if(!file_exists("imagenes/productos/$name-4.webp") && $imagen4) {
                // $routeImg4 = descargarYGuardarImagen($imagen4, "imagenes/productos", "$name-4");
            // }
            // if(!file_exists("imagenes/productos/$name-5.webp") && $imagen5) {
                // $routeImg5 = descargarYGuardarImagen($imagen5, "imagenes/productos", "$name-5");
            // }
            // if(!file_exists("imagenes/productos/$name-6.webp") && $imagen6) {
                // $routeImg6 = descargarYGuardarImagen($imagen6, "imagenes/productos", "$name-6");
            // }
            // if(!file_exists("imagenes/productos/$name-7.webp") && $imagen7) {
                // $routeImg7 = descargarYGuardarImagen($imagen7, "imagenes/productos", "$name-7");
            // }
            // if(!file_exists("imagenes/productos/$name-8.webp") && $imagen8) {
                // $routeImg8 = descargarYGuardarImagen($imagen8, "imagenes/productos", "$name-8");
            // }
            // if(!file_exists("imagenes/productos/$name-9.webp") && $imagen9) {
                // $routeImg9 = descargarYGuardarImagen($imagen9, "imagenes/productos", "$name-9");
            // }

        }
    }
    foreach($filterRemoveWords as $word) {
        $descripcion = implode("", explode($word, $descripcion));
    }

    $folderFiles = "tmpfiles";

    $namep = substr($id_producto, 3);

    // $newPic = $routeImg1 != "" ? $routeImg1 : descargarYGuardarImagen($imagen_principal, $folderFiles, "$namep-1");
    // if ($newPic !== false) {
        // $imagen_principal = $newPic;
    // }
    // if($imagen2) {
        // $newPic = $routeImg2 != "" ? $routeImg2 : descargarYGuardarImagen($imagen2, $folderFiles, "$namep-2");
        // if ($newPic !== false) {
            // $imagen2 = $newPic;
        // }
    // }
    // if($imagen3) {
        // $newPic = $routeImg3 != "" ? $routeImg3 : descargarYGuardarImagen($imagen3, $folderFiles, "$namep-3");
        // if ($newPic !== false) {
            // $imagen3 = $newPic;
        // }
    // }
    // if($imagen4) {
        // $newPic = $routeImg4 != "" ? $routeImg4 : descargarYGuardarImagen($imagen4, $folderFiles, "$namep-4");
        // if ($newPic !== false) {
            // $imagen4 = $newPic;
        // }
    // }
    // if($imagen5) {
        // $newPic = $routeImg5 != "" ? $routeImg5 : descargarYGuardarImagen($imagen5, $folderFiles, "$namep-5");
        // if ($newPic !== false) {
            // $imagen5 = $newPic;
        // }
    // }
    // if($imagen6) {
        // $newPic = $routeImg6 != "" ? $routeImg6 : descargarYGuardarImagen($imagen6, $folderFiles, "$namep-6");
        // if ($newPic !== false) {
            // $imagen6 = $newPic;
        // }
    // }
    // if($imagen7) {
        // $newPic = $routeImg7 != "" ? $routeImg7 : descargarYGuardarImagen($imagen7, $folderFiles, "$namep-7");
        // if ($newPic !== false) {
            // $imagen7 = $newPic;
        // }
    // }
    // if($imagen8) {
        // $newPic = $routeImg8 != "" ? $routeImg8 : descargarYGuardarImagen($imagen8, $folderFiles, "$namep-8");
        // if ($newPic !== false) {
            // $imagen8 = $newPic;
        // }
    // }
    // if($imagen9) {
        // $newPic = $routeImg9 != "" ? $routeImg9 : descargarYGuardarImagen($imagen9, $folderFiles, "$namep-9");
        // if ($newPic !== false) {
            // $image9 = $newPic;
        // }
    // }

	$talle = array();
	$talles = array();
	$color = array();
	$colors = array();

    $colorsArr = array();

	if($info) {
		if(isset($info->variations)) {
			foreach($info->variations as $v) {

                //var_dump($v); echo "<br>";

                $color = "";
                $talle = "";

                foreach($v->attribute_combinations as $a) {
                    if($color == "" && $a->id == "COLOR") {
                        $color = $a->value_name;
                    }
                    if($talle == "" && $a->name == "Talle") {
                        $talle = $a->value_name;
                    }
                }
                if($color != "" && $talle != "") {
                    if(!isset($colorsArr[$color])) {
                        $colorsArr[$color] = array();
                    }
                    $colorsArr[$color][] = $talle;
                }
                

                //echo "$color->value_name - $talle->value_name"; die();

				/*foreach($v->attribute_combinations as $a) {
					if($a->id == "COLOR") {
						if(!in_array($a->value_name, $colors)) {
							//$color[] = $a;
							//$colors[] = $a->value_name;

                            if(!isset($colorsArr[$a->id])) {
                                $colorsArr[$a->id] = array();
                            }
						}
					}
					if($a->name == "Talle") {
						if(!in_array($a->value_name, $talles)) {
							$talle[] = $a;
							$talles[] = $a->value_name;
						}
					}
				}*/
			}
		}
	}

    //echo json_encode($colorsArr); die();


//PORCENTAJE DE GANANCIAS
include('ganancia.php');
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
            <ol class="breadcrumb p-2 ps-3 rounded">
                <li class="breadcrumb-item"><a href="/" title="Home"><span><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-house-fill"><path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"></path><path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z"></path></svg></span></a></li>
                <!--<li class="breadcrumb-item"><a href="categoria.html"><span>Categoria</span></a></li>-->
                <?php
                    foreach ($caterories as &$categoria) {
                        $newUriCat = sannedStr($categoria->name)."/".substr($categoria->id, 3);
                        echo '<li class="breadcrumb-item"><a href="/categoria/'.$newUriCat.'" class="text-black"><span>'.$categoria->name.'</span></a></li>';
                    }
                ?>
                <li class="breadcrumb-item active"><span class="titleLabel"><?php echo $titulo;?></span></li>
            </ol>
            <div class="row mb-3">
                <div class="col-md-6 text-center">
                    <div class="bg-white rounded border mb-3">
                        <a href="<?php echo change_image_extension($imagen_principal);?>" data-lightbox="producto" data-title="<?php echo $titulo;?>"><img alt="<?php echo $titulo;?>" class="img-fluid rounded img-producto" data-bss-hover-animate="tada" src="<?php echo change_image_extension($imagen_principal);?>" width="350" height="350" loading="lazy"></a>
                        
                        <?php if($imagen2){?>
                        <hr class="m-0">
                        <div class="row my-2 mb-3">
                            <?php if($imagen2){?>
                            <div class="col-3 mx-auto" data-bss-hover-animate="pulse">
                                <a href="<?php echo change_image_extension($imagen2);?>" data-lightbox="producto" data-title="<?php echo $titulo;?>"><img alt="<?php echo $titulo;?>" class="img-fluid rounded list-product" src="<?php echo change_image_extension($imagen2);?>" width="150" height="150" loading="lazy"></a>
                            </div>
                            <?php }?>
                            
                            <?php if($imagen3){?>
                            <div class="col-3 mx-auto" data-bss-hover-animate="pulse">
                                <a href="<?php echo change_image_extension($imagen3);?>" data-lightbox="producto" data-title="<?php echo $titulo;?>"><img alt="<?php echo $titulo;?>" class="img-fluid rounded list-product" src="<?php echo change_image_extension($imagen3);?>" width="150" height="150" loading="lazy"></a>
                            </div>
                            <?php }?>
                            
                            <?php if($imagen4){?>
                            <div class="col-3 mx-auto" data-bss-hover-animate="pulse">
                                <a href="<?php echo change_image_extension($imagen4);?>" data-lightbox="producto" data-title="<?php echo $titulo;?>"><img alt="<?php echo $titulo;?>" class="img-fluid rounded list-product" src="<?php echo change_image_extension($imagen4);?>" width="150" height="150" loading="lazy"></a>
                            </div>
                            <?php }?>
                            
                            <?php if($imagen5){?>
                            <div class="col-3 mx-auto" data-bss-hover-animate="pulse">
                                <a href="<?php echo change_image_extension($imagen5);?>" data-lightbox="producto" data-title="<?php echo $titulo;?>"><img alt="<?php echo $titulo;?>" class="img-fluid rounded list-product" src="<?php echo change_image_extension($imagen5);?>" width="150" height="150" loading="lazy"></a>
                            </div>
                            <?php }?>
                            
                            <?php if($imagen6){?>
                            <div class="col-3 mx-auto d-none" data-bss-hover-animate="pulse">
                                <a href="<?php echo change_image_extension($imagen6);?>" data-lightbox="producto" data-title="<?php echo $titulo;?>"><img alt="<?php echo $titulo;?>" class="img-fluid rounded list-product" src="<?php echo change_image_extension($imagen6);?>" width="150" height="150" loading="lazy"></a>
                            </div>
                            <?php }?>
                            
                            <?php if($imagen7){?>
                            <div class="col-3 mx-auto d-none" data-bss-hover-animate="pulse">
                                <a href="<?php echo change_image_extension($imagen7);?>" data-lightbox="producto" data-title="<?php echo $titulo;?>"><img alt="<?php echo $titulo;?>" class="img-fluid rounded list-product" src="<?php echo change_image_extension($imagen7);?>" width="150" height="150" loading="lazy"></a>
                            </div>
                            <?php }?>
                            
                            <?php if($imagen8){?>
                            <div class="col-3 mx-auto d-none" data-bss-hover-animate="pulse">
                                <a href="<?php echo change_image_extension($imagen8);?>" data-lightbox="producto" data-title="<?php echo $titulo;?>"><img alt="<?php echo $titulo;?>" class="img-fluid rounded list-product" src="<?php echo change_image_extension($imagen8);?>" width="150" height="150" loading="lazy"></a>
                            </div>
                            <?php }?>
                            
                            <?php if($imagen9){?>
                            <div class="col-3 mx-auto d-none" data-bss-hover-animate="pulse">
                                <a href="<?php echo change_image_extension($imagen9);?>" data-lightbox="producto" data-title="<?php echo $titulo;?>"><img alt="<?php echo $titulo;?>" class="img-fluid rounded list-product" src="<?php echo change_image_extension($imagen9);?>" width="150" height="150" loading="lazy"></a>
                            </div>
                            <?php }?>
                            
                        </div>
                        <?php }?>
                    </div>
                    <div class="mb-3 p-2 google-product"><?php echo $adsense_item;?></div>
                </div>
                <div class="col-md-6">
                    <div>
                        <h1 class="fs-3 fw-light text-center titulo"><span class="titleLabel"><?php echo $titulo; ?></span>
                    
                        <?php if(isset($_SESSION["P3xN3w"])): ?>
                            <a title="Editar" href="javascript: void(0);" data-bs-toggle="modal" data-bs-target="#mdEdit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg>
                            </a>
                        <?php endif ?>
                        </h1>
						<?php
						// $id_alternativa = 'MLA721377548';
						if($alternative == '' || $alternative == null){?>
						<?php
						$precioProducto = $precio;
						?>
						<div class="con-stock">
                        <h2 class="fw-semibold text-center text-black sombra-2 priceLabel <?php filtro_ocultar($categoria_principal);?>">$<?php echo number_format($precioProducto,0,",",".");?> <?php echo $currency_id;?></h2>
                        <div class="d-flex justify-content-center d-none" data-aos="zoom-in" data-aos-duration="1500" data-aos-delay="350">
                            <select class="unitsArr form-select form-select-sm w-50 my-2 rounded">
                                <optgroup label="Cantidad">
                                    <option value="1" selected="">1 Unidad</option>
                                    <option value="2">2 Unidades</option>
                                    <option value="3">3 Unidades</option>
                                    <option value="4">4 Unidades</option>
                                    <option value="5">5 Unidades</option>
                                </optgroup>
                            </select>
                        </div>
						
						<?php if(count($colorsArr) > 0): ?>
							<div>Colores</div>
							<select onchange="colors(this);" class="colorsArr form-select form-select-sm w-50 my-2 rounded">
                                <optgroup label="Colores">
                                    <option value="" selected="">Seleccione</option>
									<?php foreach($colorsArr as $k => $c): ?>
										<option value="<?php echo $k; ?>" ><?php echo $k; ?></option>
									<?php endforeach ?>
                                </optgroup>
                            </select>
							<div>Talle</div>
							<select id="tll" onchange="talles(this);" class="talleArr form-select form-select-sm w-50 my-2 rounded">
                                <optgroup label="Talle">
                                    <option value="" selected="">Seleccione</option>
                                </optgroup>
                            </select>
						<?php endif ?>



                        <div class="d-flex justify-content-center my-3 d-none d-md-block d-lg-block">
                            <div class="btn-group btn-group-justified botones" role="group">
                                <a class="btn btn-primary <?php filtro_ocultar($categoria_principal);?>" href="/comprar.php?idproducto=<?php echo preg_replace("/[^0-9]/", "", $id_producto);?>&sku=<?php echo base64_encode($id_producto);?>">COMPRAR</a>
                                <a class="btn btn-primary" href="/consultar.php?idproducto=<?php echo preg_replace("/[^0-9]/", "", $id_producto);?>&sku=<?php echo base64_encode($id_producto);?>">CONSULTAR</a>
                                <?php if($activeCart): ?>
                                    <a class="btn btn-info addToCart item" href="javascript:(0);" d-pr="$<?php echo number_format($precioProducto,0,",",".");?>" d-prc="<?php echo $precioProducto; ?>" d-p="<?php echo $id_producto; ?>" d-t="<?php echo $titulo; ?>">CARRITO</a>
                                <?php endif ?>
                            </div>
                        </div>
						<div class="d-flex justify-content-center my-3 d-sm-none">
                            <div class="btn-group-vertical btn-group-justified botones" role="group">
                                <a class="btn btn-primary <?php filtro_ocultar($categoria_principal);?>" href="/comprar.php?idproducto=<?php echo preg_replace("/[^0-9]/", "", $id_producto);?>&sku=<?php echo base64_encode($id_producto);?>">COMPRAR</a>
                                <a class="btn btn-primary" href="/consultar.php?idproducto=<?php echo preg_replace("/[^0-9]/", "", $id_producto);?>&sku=<?php echo base64_encode($id_producto);?>">CONSULTAR</a>
                                <?php if($activeCart): ?>
                                    <a class="btn btn-info addToCart item" href="javascript:(0);" d-pr="$<?php echo number_format($precioProducto,0,",",".");?>" d-prc="<?php echo $precioProducto; ?>" d-p="<?php echo $id_producto; ?>" d-t="<?php echo $titulo; ?>">CARRITO</a>
                                <?php endif ?>
                            </div>
                        </div>
						</div>
						<?php }?>
						<?php if($alternative && $alternative != ""){ ?>
                        <div class="sin-stock">
						<span class="badge text-bg-info">Producto alternativo</span>
						<?php
						//CONSULTANDO DATOS DEL ITEM ALTERNATIVO

						$url = "https://api.mercadolibre.com/items/".$alternative;
						$sitioweb = curl($url);
						$info = json_decode($sitioweb);
						$imagen_principal = isset($info->pictures[0]->secure_url)? $info->pictures[0]->secure_url : 'assets/img/sin-imagen.png';
						$condition = isset($info->condition)? $info->condition : '';
						$title = isset($info->title)? $info->title : '';
						$precio = isset($info->price)? $info->price : '';
						include('ganancia.php');
						?>
						<?php if($condition == 'new')
							$urlNew = "producto/".sannedStr($title)."-".substr($alternative, 3);
						{?>
						<div class="col-12 list-group-item rounded bg-info py-4" onclick="location.href = &#39;/<?php echo $urlNew;?>&#39;">
						<div class="text-center p-2">
							<div class="row">
								<div class="col-md-3"><a class="list-product" href="/<?php echo $urlNew;?>"><img data-bss-hover-animate="tada" loading="lazy" class="producto list-product rounded img-fluid" src="<?php echo $imagen_principal;?>" alt="<?php echo $title;?>" width="250" height="250"></a></div>
								<div class="col-md-9 text-start">
									<a href="/<?php echo $urlNew;?>"><h2 class="text-capitalize fs-5 text-primary"><?php echo $info->title;?></h2></a>
									<p class="fs-5 sombra mb-0 <?php filtro_ocultar($categoria_principal);?>">$<?php echo number_format($precio,0,",",".");?></p>
									
									<?php if($precio >= $cuotas_12){?>
									<p class="mb-0 <?php filtro_ocultar($categoria_principal);?>"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-credit-card-2-back fs-5 me-1"><path d="M11 5.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1z"></path><path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2zm13 2v5H1V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm-1 9H2a1 1 0 0 1-1-1v-1h14v1a1 1 0 0 1-1 1z"></path></svg>12 cuotas de $<?php echo number_format(($precio/12),0,",",".");?></p>
									<?php }?>
									<?php if($precio >= $envio_gratis){?>
									<p class="mb-0 <?php filtro_ocultar($categoria_principal);?>"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-truck fs-5 me-1">
											<path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"></path>
										</svg>Consulta por Envío gratis</p>
									<?php }?>	
								</div>
							</div>
						</div>
						</div>
						<?php }?>
						</div>
						<?php }?>
                        <div class="contenido p-2">
                            <div class="mb-3 descLabel"><?php echo $descripcion;?></div>
                            <div>
                                <!-- AddToAny BEGIN -->
                                <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                                <a class="a2a_button_facebook"></a>
                                <a class="a2a_button_twitter"></a>
                                <a class="a2a_button_whatsapp"></a>
                                <a class="a2a_button_facebook_messenger"></a>
                                <a class="a2a_button_telegram"></a>
                                <a class="a2a_button_google_gmail"></a>
                                <a class="a2a_button_email"></a>
                                </div>
                                <script>
                                var a2a_config = a2a_config || {};
                                a2a_config.locale = "es-AR";
                                </script>
                                <script async src="https://static.addtoany.com/menu/page.js"></script>
                                <!-- AddToAny END -->
                            </div>
                        </div>
                        
                        <div class="text-end"><a class="badge bg-danger text-uppercase btn-denuncia rounded text-white" href="/denuncia.php?idproducto=<?php echo preg_replace("/[^0-9]/", "", $id_producto);?>&sku=<?php echo base64_encode($id_producto);?>">Denunciar</a></div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <h4 class="fs-3 sombra-2">Productos relacionados</h4>
                </div>
                <?php
                    foreach ($alternativas as &$alternativa) {
                        // echo $alternativa->id."<br>";
                        // echo $alternativa->title."<br>";
                        // echo $alternativa->price."<br>";
                        // echo $alternativa->thumbnail."<br>";
                        // $imagen_principal = $alternativa->thumbnail;
                        //CONSULTANDO DATOS DEL ITEM
                            $url = "https://api.mercadolibre.com/items/".$alternativa->id;
                            //$sitioweb = curl($url);
                            $sitioweb = file_get_contents($url);
                            $info = json_decode($sitioweb);
                            $imagen_principal = isset($info->pictures[0]->secure_url)? $info->pictures[0]->secure_url : 'assets/img/sin-imagen.png';

                            $namep2 = substr($alternativa->id, 3);
                            
                            // $newPic = descargarYGuardarImagen($imagen_principal, $folderFiles, "$namep2-1");
                            // if ($newPic !== false) {
                                // $imagen_principal = $newPic;
                            // }
                            
                            //Solo muestra los item nuevos
                            $condicion = isset($alternativa->condition)? $alternativa->condition : '';
                            //nueva url
                            $urlNew = "producto/".sannedStr($alternativa->title)."-".substr($alternativa->id, 3);
                            
                            $precio = $alternativa->price;
                            //PORCENTAJE DE GANANCIAS
                            include('ganancia.php');
                            
                        if($condicion == 'new'){
                            ?>
                            <div class="col-md-3">
                                <div class="text-center border bg-white p-2 rounded mb-3 producto-relacionado" onclick="location.href = &#39;/<?php echo $urlNew;?>&#39;">
                                    <img class="img-fluid list-product list-product-rel mb-1" loading="lazy" data-bss-hover-animate="tada" src="<?php echo $imagen_principal;?>" alt="<?php echo $alternativa->title;?>" width="250" height="250">
                                    <a href="/<?php echo $urlNew;?>"><h4 class="fs-6 fw-bold text-primary sombra mb-0"><?php echo $alternativa->title;?></h4></a>
                                    <p class="sombra <?php filtro_ocultar($categoria_principal);?>">$<?php echo number_format($precio,0,",",".");?></p>
                                </div>
                            </div>
                            <?php
                        }
                    }
                ?>
            </div>
        </div>
    </section>
    <?php if(isset($_SESSION["P3xN3w"])): ?>
        <div class="modal" tabindex="-1" id="mdEdit">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modificar propiedades</h5>
					<div class="btn-group ms-3">
						<button class="btn btn-info btn-sm dropdown-toggle rounded" type="button" data-bs-toggle="dropdown" aria-expanded="false">
						  Acciones
						</button>
						<ul class="dropdown-menu" style="">
						  <li><a class="dropdown-item" target="_blank" href="<?php echo $permalink; ?>">Ver producto en ML</a></li>
						  <li><a class="dropdown-item" target="_blank" href="https://api.mercadolibre.com/items/<?php echo $id_producto; ?>">Datos del producto</a></li>
						  <li><a class="dropdown-item" target="_blank" href="https://listado.mercadolibre.com.ar/<?php echo urlencode($titulo)?>">Buscar en Mercadolibre</a></li>
						  <li><a class="dropdown-item" target="_blank" href="https://pex.website/mercadolibre/seo.php?keyword=<?php echo $titulo; ?>">Plantilla SEO</a></li>
						  <li><a class="dropdown-item" target="_blank" href="https://chat.openai.com/chat">chatGPT</a></li>
						  <li><hr class="dropdown-divider"></li>
						  <?php if($catalog_product_id){?>
						  <li><a class="dropdown-item" target="_blank" href="https://app.pexsell.com/producto.php?id=<?php echo $catalog_product_id;?>">Ver compentencia</a></li>
						  <?php }?>
						</ul>
					  </div>
					<div class="acciones d-none">
					<a class="ms-2" title="Datos del producto" href="https://api.mercadolibre.com/items/<?php echo $id_producto; ?>" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" fill="currentColor" class="bi bi-window-desktop" viewBox="0 0 16 16"><path d="M3.5 11a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"></path><path d="M2.375 1A2.366 2.366 0 0 0 0 3.357v9.286A2.366 2.366 0 0 0 2.375 15h11.25A2.366 2.366 0 0 0 16 12.643V3.357A2.366 2.366 0 0 0 13.625 1zM1 3.357C1 2.612 1.611 2 2.375 2h11.25C14.389 2 15 2.612 15 3.357V4H1zM1 5h14v7.643c0 .745-.611 1.357-1.375 1.357H2.375A1.366 1.366 0 0 1 1 12.643z"></path></svg></a>
					<a class="ms-2" title="Buscar en Mercadolibre" href="https://listado.mercadolibre.com.ar/<?php echo urlencode($titulo)?>" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/></svg></a>
					<a class="ms-2" title="SEO" href="https://pex.website/mercadolibre/seo.php?keyword=<?php echo $titulo; ?>" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" fill="currentColor" class="bi bi-clipboard-data" viewBox="0 0 16 16"><path d="M4 11a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0zm6-4a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0zM7 9a1 1 0 0 1 2 0v3a1 1 0 1 1-2 0z"/><path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/><path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/></svg></a>
					<a class="ms-2" title="chatGPT" href="https://chat.openai.com/chat" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" fill="currentColor" class="bi bi-robot" viewBox="0 0 16 16"><path d="M6 12.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5M3 8.062C3 6.76 4.235 5.765 5.53 5.886a26.58 26.58 0 0 0 4.94 0C11.765 5.765 13 6.76 13 8.062v1.157a.933.933 0 0 1-.765.935c-.845.147-2.34.346-4.235.346-1.895 0-3.39-.2-4.235-.346A.933.933 0 0 1 3 9.219zm4.542-.827a.25.25 0 0 0-.217.068l-.92.9a24.767 24.767 0 0 1-1.871-.183.25.25 0 0 0-.068.495c.55.076 1.232.149 2.02.193a.25.25 0 0 0 .189-.071l.754-.736.847 1.71a.25.25 0 0 0 .404.062l.932-.97a25.286 25.286 0 0 0 1.922-.188.25.25 0 0 0-.068-.495c-.538.074-1.207.145-1.98.189a.25.25 0 0 0-.166.076l-.754.785-.842-1.7a.25.25 0 0 0-.182-.135Z"/><path d="M8.5 1.866a1 1 0 1 0-1 0V3h-2A4.5 4.5 0 0 0 1 7.5V8a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1v1a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-1a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1v-.5A4.5 4.5 0 0 0 10.5 3h-2zM14 7.5V13a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7.5A3.5 3.5 0 0 1 5.5 4h5A3.5 3.5 0 0 1 14 7.5"/></svg></a>
					<?php if($catalog_product_id){?>
					<a class="ms-2" title="Ver compentencia" href="https://app.pexsell.com/producto.php?id=<?php echo $catalog_product_id;?>" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" fill="currentColor" class="bi bi-bar-chart-line" viewBox="0 0 16 16"><path d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1zm1 12h2V2h-2zm-3 0V7H7v7zm-5 0v-3H2v3z"/></svg></a>
					<?php }?>
					</div>
					
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titleForm" class="form-label">Titulo</label>
                        <input type="text" class="form-control" id="titleForm" placeholder="<?php echo $titulo; ?>" value="<?php echo $titulo; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="priceForm" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="priceForm" placeholder="<?php echo $precioProducto; ?>" value="<?php echo $precioProducto; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="descForm" class="form-label">Descripcion</label>
                        <textarea class="form-control" id="descForm" rows="15" placeholder='<?php echo $descripcion; ?>'><?php echo $descripcion; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="altForm" class="form-label">Producto alternativo</label>
                        <input type="text" class="form-control" id="altForm" placeholder="<?php echo $alternative; ?>" value="<?php echo $alternative; ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closeModal" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="saveInfo" onclick="saveInfo();">Guardar</button>
                </div>
                </div>
            </div>
        </div>
    <?php endif ?>

    <script>
    var prb = "<?php echo $precioBase; ?>";
    var idp = "<?php echo $id_producto; ?>";
    var cls = <?php echo json_encode($colorsArr); ?>;
    function colors(el) {
		localStorage.setItem("color", el.value);
        var opts = '<option value="">Seleccione</option>';
        Object.keys(cls).forEach(function(key) {
            if(key == el.value) {
                cls[key].forEach(function(val) {
                    opts += `<option value="${val}">${val}</option>`;
                });
            }
        });
        $("#tll").html(opts);
        localStorage.removeItem("talle");
	}
    function talles(el) {
		localStorage.setItem("talle", el.value);
	}
    function saveInfo() {
        $("#saveInfo").attr("disabled", true);
        $("#saveInfo").addClass("disabled");
        $.ajax({
            type: 'POST',
            url: '/server/',
            data: 'o=2&t='+$("#titleForm").val()+'&p='+$("#priceForm").val()+'&d='+$("#descForm").val()+'&i='+idp+`&alt=${$("#altForm").val()}`,
            dataType: 'json',
            success: function(data) {
                var title = $("#titleForm").val();
                var price = $("#priceForm").val();

                if(price == "" || price == null) {
                    price = prb;
                }

                var desc = $("#descForm").val();
                var alt = $("#altForm").val();
                $(".titleLabel").html(title);
                $(".priceLabel").html("$" + price);
                $(".descLabel").html(desc);
                $("#saveInfo").attr("disabled", false);
                $("#saveInfo").removeClass("disabled");
                $(".closeModal").trigger("click");
                $("#titleForm").val(title).attr("placeholder", title);
                $("#priceForm").val(price).attr("placeholder", price);
                $("#descForm").val(desc).attr("placeholder", desc);
                $("#altForm").val(alt).attr("placeholder", alt);
            }
        });
    }
    
</script>
<?php 
// $vendidos = isset($_REQUEST["id"])? $_REQUEST["id"] : 'MLA1114967856';

    echo '
        <script type="application/ld+json">
            {
                "@context": "https://schema.org/",
                "@type": "Product",
                "name": "'.$titulo.'",
                "image": ["https://alquila2.com.ar'.$imagen_principal.'"],
                "gtin14": "'.base64_encode($id_producto).'",
                "description": "'.str_replace('"', "", strip_tags($descripcion_google)).'",
                "sku": "'.base64_encode($id_producto).'",
                "mpn": "'.base64_encode($id_producto).'",
                "brand": {
                    "@type": "Brand",
                    "name": "'.(isset($brand) ? $brand : 'PEX').'"
                },
                "review": {
                    "@type": "Review",
                    "reviewRating": {
                    "@type": "Rating",
                    "ratingValue": "4",
                    "bestRating": "5"
                    },
                    "author": {
                    "@type": "Person",
                    "name": "Pex Creative"
                    }
                },
                "aggregateRating": {
                    "@type": "AggregateRating",
                    "ratingValue": "4.7",
                    "reviewCount": "197"
                },
                "offers": {
                    "@type": "Offer",
                    "url": "https://'."$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]".'",
                    "priceCurrency": "'.$currency_id.'",
                    "price": "'.(isset($precio) ? $precio : '').'",
                    "priceValidUntil": "2025-12-06",
                    "itemCondition": "https://schema.org/UsedCondition",
                    "availability": "https://schema.org/InStock"
                }
            }
        </script>
    ';
?>
<?php include_once'footer.php';?>