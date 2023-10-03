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


//OBTENER ID PRODUCTO
$id_producto = isset($_REQUEST["id"])? $_REQUEST["id"] : 'MLA1114967856';

//CONSULTANDO DATOS DEL ITEM
$url = "https://api.mercadolibre.com/items/".$id_producto;
$sitioweb = curl($url);
$info = json_decode($sitioweb);
//echo $info->id."<br>";
$categorias = isset($info->category_id)? $info->category_id : '';
$titulo = isset($info->title)? $info->title : '';
//echo $info->price."<br>";
$precio = isset($info->price)? $info->price : '';
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
$descripcion_google = $descripcion;
$descripcion = nl2br($descripcion);
$descripcion = @str_replace($buscar, "", $descripcion);

//OBTENER CATEGORIAS DEL PRODUCTO
$url3 = "https://api.mercadolibre.com/categories/".$categorias;
$categorias = curl($url3);
$info3 = json_decode($categorias);
$caterories = isset($info3->path_from_root)? $info3->path_from_root : '';

//OBTENER ALTERNATIVAS DEL PRODUCTO
$url4 = 'https://api.mercadolibre.com/sites/MLA/search?q='.urlencode($titulo).'&limit=4&offset=2';
$alternativas = curl($url4);
$info4 = json_decode($alternativas);
$alternativas = isset($info4->results)? $info4->results : '';

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
                <li class="breadcrumb-item"><a href="/"><span><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-house-fill"><path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"></path><path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z"></path></svg></span></a></li>
                <!--<li class="breadcrumb-item"><a href="categoria.html"><span>Categoria</span></a></li>-->
				<?php
					foreach ($caterories as &$categoria) {
						echo '<li class="breadcrumb-item"><a href="/categoria.php?id='.$categoria->id.'"><span>'.$categoria->name.'</span></a></li>';
					}
				?>
                <li class="breadcrumb-item active"><span><?php echo $titulo;?></span></li>
            </ol>
            <div class="row mb-3">
                <div class="col-md-6 text-center">
                    <div class="bg-white rounded border mb-3">
						<a href="<?php echo change_image_extension($imagen_principal);?>" data-lightbox="producto" data-title="<?php echo $titulo;?>"><img alt="<?php echo $titulo;?>" class="img-fluid rounded" data-bss-hover-animate="tada" src="<?php echo change_image_extension($imagen_principal);?>" width="350" height="350"></a>
                        
						<?php if($imagen2){?>
						<hr class="m-0">
                        <div class="row my-2 mb-3">
                            <?php if($imagen2){?>
							<div class="col-3 mx-auto" data-bss-hover-animate="pulse">
								<a href="<?php echo change_image_extension($imagen2);?>" data-lightbox="producto" data-title="<?php echo $titulo;?>"><img alt="<?php echo $titulo;?>" class="img-fluid rounded list-product" src="<?php echo change_image_extension($imagen2);?>" width="150" height="150"></a>
							</div>
							<?php }?>
							
							<?php if($imagen3){?>
                            <div class="col-3 mx-auto" data-bss-hover-animate="pulse">
								<a href="<?php echo change_image_extension($imagen3);?>" data-lightbox="producto" data-title="<?php echo $titulo;?>"><img alt="<?php echo $titulo;?>" class="img-fluid rounded list-product" src="<?php echo change_image_extension($imagen3);?>" width="150" height="150"></a>
							</div>
							<?php }?>
							
							<?php if($imagen4){?>
                            <div class="col-3 mx-auto" data-bss-hover-animate="pulse">
								<a href="<?php echo change_image_extension($imagen4);?>" data-lightbox="producto" data-title="<?php echo $titulo;?>"><img alt="<?php echo $titulo;?>" class="img-fluid rounded list-product" src="<?php echo change_image_extension($imagen4);?>" width="150" height="150"></a>
							</div>
							<?php }?>
							
							<?php if($imagen5){?>
							<div class="col-3 mx-auto" data-bss-hover-animate="pulse">
								<a href="<?php echo change_image_extension($imagen5);?>" data-lightbox="producto" data-title="<?php echo $titulo;?>"><img alt="<?php echo $titulo;?>" class="img-fluid rounded list-product" src="<?php echo change_image_extension($imagen5);?>" width="150" height="150"></a>
							</div>
							<?php }?>
							
							<?php if($imagen6){?>
							<div class="col-3 mx-auto d-none" data-bss-hover-animate="pulse">
								<a href="<?php echo change_image_extension($imagen6);?>" data-lightbox="producto" data-title="<?php echo $titulo;?>"><img alt="<?php echo $titulo;?>" class="img-fluid rounded list-product" src="<?php echo change_image_extension($imagen6);?>" width="150" height="150"></a>
							</div>
							<?php }?>
							
							<?php if($imagen7){?>
							<div class="col-3 mx-auto d-none" data-bss-hover-animate="pulse">
								<a href="<?php echo change_image_extension($imagen7);?>" data-lightbox="producto" data-title="<?php echo $titulo;?>"><img alt="<?php echo $titulo;?>" class="img-fluid rounded list-product" src="<?php echo change_image_extension($imagen7);?>" width="150" height="150"></a>
							</div>
							<?php }?>
							
							<?php if($imagen8){?>
							<div class="col-3 mx-auto d-none" data-bss-hover-animate="pulse">
								<a href="<?php echo change_image_extension($imagen8);?>" data-lightbox="producto" data-title="<?php echo $titulo;?>"><img alt="<?php echo $titulo;?>" class="img-fluid rounded list-product" src="<?php echo change_image_extension($imagen8);?>" width="150" height="150"></a>
							</div>
							<?php }?>
							
							<?php if($imagen9){?>
							<div class="col-3 mx-auto d-none" data-bss-hover-animate="pulse">
								<a href="<?php echo change_image_extension($imagen9);?>" data-lightbox="producto" data-title="<?php echo $titulo;?>"><img alt="<?php echo $titulo;?>" class="img-fluid rounded list-product" src="<?php echo change_image_extension($imagen9);?>" width="150" height="150"></a>
							</div>
							<?php }?>
							
                        </div>
						<?php }?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <h1 class="fs-3 fw-light text-center titulo"><?php echo $titulo;?></h1>
                        <h2 class="fw-semibold text-center text-black sombra-2">$<?php echo number_format($precio,0,",",".");?> <?php echo $currency_id;?></h2>
                        <div class="d-flex justify-content-center d-none" data-aos="zoom-in" data-aos-duration="1500" data-aos-delay="350">
							<select class="form-select form-select-sm w-50 my-2 rounded">
								<optgroup label="Cantidad">
									<option value="1" selected="">1 Unidad</option>
									<option value="2">2 Unidades</option>
									<option value="3">3 Unidades</option>
                                    <option value="4">4 Unidades</option>
                                    <option value="5">5 Unidades</option>
                                </optgroup>
							</select>
						</div>
                        <div class="d-flex justify-content-center my-3" data-aos="zoom-in" data-aos-duration="1500" data-aos-delay="350">
							<div class="btn-group botones" role="group">
								<a class="btn btn-primary rounded me-2" role="button" href="comprar.php?sku=<?php echo base64_encode($id_producto);?>">COMPRAR</a>
								<a class="btn btn-primary rounded" role="button" href="consultar.php?sku=<?php echo base64_encode($id_producto);?>">CONSULTAR</a>
							</div>
                        </div>
						
                        <div class="contenido p-2">
							<div class="mb-3"><?php echo $descripcion;?></div>
						</div>
						
                        <div class="text-end"><a class="badge bg-danger text-uppercase opacity-75 btn-denuncia rounded" href="denuncia.php?sku=<?php echo base64_encode($id_producto);?>">Denunciar</a></div>
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
							$sitioweb = curl($url);
							$info = json_decode($sitioweb);
							$imagen_principal = isset($info->pictures[0]->secure_url)? $info->pictures[0]->secure_url : 'assets/img/sin-imagen.png';
							//Solo muestra los item nuevos
							$condicion = isset($alternativa->condition)? $alternativa->condition : '';
						if($condicion == 'new'){
							echo '<div class="col-md-3">
								<div class="text-center border bg-white p-2 rounded mb-3 producto-relacionado" onclick="location.href = &#39;item.php?id='.$alternativa->id.'&#39;">
									<img class="img-fluid list-product list-product-rel" data-bss-hover-animate="tada" src="'.change_image_extension($imagen_principal).'" alt="'.$alternativa->title.'" width="250" height="250">
									<a href="item.php?id='.$alternativa->id.'"><h4 class="fs-6 fw-bold text-primary sombra mb-0">'.$alternativa->title.'</h4></a>
									<p class="sombra">$'.number_format($alternativa->price,0,",",".").'</p>
								</div>
							</div>';
						}
					}
				?>
            </div>
        </div>
    </section>
	
<?php include_once'footer.php';?>