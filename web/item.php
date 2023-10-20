<?php
	session_start();
	require_once "config.php";
	require_once "convertImageTmp.php";
	require_once 'classes/Password.php';
	require_once 'classes/DatabasePDOInstance.function.php';
	$db = DatabasePDOInstance();

	$id_producto = isset($_REQUEST["id"])? $_REQUEST["id"] : 'MLA1114967856';

	if(strrpos($id_producto, "-") !== false) {
		$id_producto = $mla.substr($id_producto, strrpos($id_producto, "-")+1, strlen($id_producto));
		//echo $id_producto; die();
	}

	

	$itemInfo = db_select_row("items", "*", "product = '$id_producto'");

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

$mla = $id_producto != "" ? substr($id_producto, 0, 3) : $mla;

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

	$routeImg1 = "";
	$routeImg2 = "";
	$routeImg3 = "";
	$routeImg4 = "";
	$routeImg5 = "";
	$routeImg6 = "";
	$routeImg7 = "";
	$routeImg8 = "";
	$routeImg9 = "";

	$filterRemoveWords = array("https://eshops.mercadolibre.com.ar");
	if($itemInfo) {
		if($itemInfo["title"] && $itemInfo["title"] != "") {
			$titulo = $itemInfo["title"];
		}
		if($itemInfo["price"] && $itemInfo["price"] != "") {
			$precio = $itemInfo["price"];
		}
		if($itemInfo["description"] && $itemInfo["description"] != "") {
			$descripcion = $itemInfo["description"];

			$name = sannedStr($titulo);
			//var_dump($name); die();
			$routeImg1 = "/imagenes/productos/$name-1.webp";
			$routeImg2 = "/imagenes/productos/$name-2.webp";
			$routeImg3 = "/imagenes/productos/$name-3.webp";
			$routeImg4 = "/imagenes/productos/$name-4.webp";
			$routeImg5 = "/imagenes/productos/$name-5.webp";
			$routeImg6 = "/imagenes/productos/$name-6.webp";
			$routeImg7 = "/imagenes/productos/$name-7.webp";
			$routeImg8 = "/imagenes/productos/$name-8.webp";
			$routeImg9 = "/imagenes/productos/$name-9.webp";

			if(!file_exists("imagenes/productos/$name-1.webp")) {
				$routeImg1 = descargarYGuardarImagen($imagen_principal, "imagenes/productos", "$name-1");
			}
			if(!file_exists("imagenes/productos/$name-2.webp") && $imagen2) {
				$routeImg2 = descargarYGuardarImagen($imagen2, "imagenes/productos", "$name-2");
			}
			if(!file_exists("imagenes/productos/$name-3.webp") && $imagen3) {
				$routeImg3 = descargarYGuardarImagen($imagen3, "imagenes/productos", "$name-3");
			}
			if(!file_exists("imagenes/productos/$name-4.webp") && $imagen4) {
				$routeImg4 = descargarYGuardarImagen($imagen4, "imagenes/productos", "$name-4");
			}
			if(!file_exists("imagenes/productos/$name-5.webp") && $imagen5) {
				$routeImg5 = descargarYGuardarImagen($imagen5, "imagenes/productos", "$name-5");
			}
			if(!file_exists("imagenes/productos/$name-6.webp") && $imagen6) {
				$routeImg6 = descargarYGuardarImagen($imagen6, "imagenes/productos", "$name-6");
			}
			if(!file_exists("imagenes/productos/$name-7.webp") && $imagen7) {
				$routeImg7 = descargarYGuardarImagen($imagen7, "imagenes/productos", "$name-7");
			}
			if(!file_exists("imagenes/productos/$name-8.webp") && $imagen8) {
				$routeImg8 = descargarYGuardarImagen($imagen8, "imagenes/productos", "$name-8");
			}
			if(!file_exists("imagenes/productos/$name-9.webp") && $imagen9) {
				$routeImg9 = descargarYGuardarImagen($imagen9, "imagenes/productos", "$name-9");
			}

		}
	}
	foreach($filterRemoveWords as $word) {
		$descripcion = implode("", explode($word, $descripcion));
	}

	$folderFiles = "tmpfiles";

	$namep = substr($id_producto, 3);

	$newPic = $routeImg1 != "" ? $routeImg1 : descargarYGuardarImagen($imagen_principal, $folderFiles, "$namep-1");
	if ($newPic !== false) {
		$imagen_principal = $newPic;
	}
	if($imagen2) {
		$newPic = $routeImg2 != "" ? $routeImg2 : descargarYGuardarImagen($imagen2, $folderFiles, "$namep-2");
		if ($newPic !== false) {
			$imagen2 = $newPic;
		}
	}
	if($imagen3) {
		$newPic = $routeImg3 != "" ? $routeImg3 : descargarYGuardarImagen($imagen3, $folderFiles, "$namep-3");
		if ($newPic !== false) {
			$imagen3 = $newPic;
		}
	}
	if($imagen4) {
		$newPic = $routeImg4 != "" ? $routeImg4 : descargarYGuardarImagen($imagen4, $folderFiles, "$namep-4");
		if ($newPic !== false) {
			$imagen4 = $newPic;
		}
	}
	if($imagen5) {
		$newPic = $routeImg5 != "" ? $routeImg5 : descargarYGuardarImagen($imagen5, $folderFiles, "$namep-5");
		if ($newPic !== false) {
			$imagen5 = $newPic;
		}
	}
	if($imagen6) {
		$newPic = $routeImg6 != "" ? $routeImg6 : descargarYGuardarImagen($imagen6, $folderFiles, "$namep-6");
		if ($newPic !== false) {
			$imagen6 = $newPic;
		}
	}
	if($imagen7) {
		$newPic = $routeImg7 != "" ? $routeImg7 : descargarYGuardarImagen($imagen7, $folderFiles, "$namep-7");
		if ($newPic !== false) {
			$imagen7 = $newPic;
		}
	}
	if($imagen8) {
		$newPic = $routeImg8 != "" ? $routeImg8 : descargarYGuardarImagen($imagen8, $folderFiles, "$namep-8");
		if ($newPic !== false) {
			$imagen8 = $newPic;
		}
	}
	if($imagen9) {
		$newPic = $routeImg9 != "" ? $routeImg9 : descargarYGuardarImagen($imagen9, $folderFiles, "$namep-9");
		if ($newPic !== false) {
			$image9 = $newPic;
		}
	}

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
						$newUriCat = sannedStr($categoria->name)."/".substr($categoria->id, 3);
						echo '<li class="breadcrumb-item"><a href="/categoria/'.$newUriCat.'"><span>'.$categoria->name.'</span></a></li>';
					}
				?>
                <li class="breadcrumb-item active"><span class="titleLabel"><?php echo $titulo;?></span></li>
            </ol>
            <div class="row mb-3">
                <div class="col-md-6 text-center">
                    <div class="bg-white rounded border mb-3">
						<a href="<?php echo change_image_extension($imagen_principal);?>" data-lightbox="producto" data-title="<?php echo $titulo;?>"><img alt="<?php echo $titulo;?>" class="img-fluid rounded img-producto" data-bss-hover-animate="tada" src="<?php echo change_image_extension($imagen_principal);?>" width="350" height="350"></a>
                        
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
					<div class="mb-3 p-2 google-product">PUBLICIDAD</div>
                </div>
                <div class="col-md-6">
                    <div>
                        <h1 class="fs-3 fw-light text-center titulo"><span class="titleLabel"><?php echo $titulo; ?></span>
					
						<?php if(isset($_SESSION["P3xN3w"])): ?>
							<a href="javascript: void(0);" data-bs-toggle="modal" data-bs-target="#mdEdit">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
								<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
								<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
							</svg>
							</a>
						<?php endif ?>
						
						</h1>
                        <h2 class="fw-semibold text-center text-black sombra-2 priceLabel <?php filtro_ocultar($categoria_principal);?>">$<?php echo number_format($precio,0,",",".");?> <?php echo $currency_id;?></h2>
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
                        <div class="d-flex justify-content-center my-3">
							<div class="btn-group botones" role="group">
								<a class="btn btn-primary rounded me-2 <?php filtro_ocultar($categoria_principal);?>" role="button" href="/comprar.php?sku=<?php echo base64_encode($id_producto);?>">COMPRAR</a>
								<a class="btn btn-primary rounded" role="button" href="/consultar.php?sku=<?php echo base64_encode($id_producto);?>">CONSULTAR</a>
							</div>
                        </div>
						
                        <div class="contenido p-2">
							<div class="mb-3 descLabel"><?php echo $descripcion;?></div>
						</div>
						
                        <div class="text-end"><a class="badge bg-danger text-uppercase opacity-75 btn-denuncia rounded" href="/denuncia.php?sku=<?php echo base64_encode($id_producto);?>">Denunciar</a></div>
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

							$namep2 = substr($alternativa->id, 3);
							
							$newPic = descargarYGuardarImagen($imagen_principal, $folderFiles, "$namep2-1");
							if ($newPic !== false) {
								$imagen_principal = $newPic;
							}
							
							//Solo muestra los item nuevos
							$condicion = isset($alternativa->condition)? $alternativa->condition : '';
							//nueva url
							$urlNew = "producto/".sannedStr($alternativa->title)."-".substr($alternativa->id, 3);
							
						if($condicion == 'new'){
							?>
							<div class="col-md-3">
								<div class="text-center border bg-white p-2 rounded mb-3 producto-relacionado" onclick="location.href = &#39;/<?php echo $urlNew;?>&#39;">
									<img class="img-fluid list-product list-product-rel mb-1" data-bss-hover-animate="tada" src="<?php echo change_image_extension($imagen_principal)?>" alt="<?php echo $alternativa->title;?>" width="250" height="250">
									<a href="/<?php echo $urlNew;?>"><h4 class="fs-6 fw-bold text-primary sombra mb-0"><?php echo $alternativa->title;?></h4></a>
									<p class="sombra <?php filtro_ocultar($categoria_principal);?>">$<?php echo number_format($alternativa->price,0,",",".");?></p>
								</div>
							</div>
							<?php
						}
					}
				?>
            </div>
        </div>
    </section>

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
					<input type="text" class="form-control" id="titleForm" placeholder="<?php echo $titulo; ?>" value="<?php echo $titulo; ?>">
				</div>
				<div class="mb-3">
					<label for="priceForm" class="form-label">Precio</label>
					<input type="number" class="form-control" id="priceForm" placeholder="<?php echo $precio; ?>" value="<?php echo $precio; ?>">
				</div>
				<div class="mb-3">
					<label for="descForm" class="form-label">Descripcion</label>
					<textarea class="form-control" id="descForm" rows="15" placeholder='<?php echo $descripcion; ?>'><?php echo $descripcion; ?></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary closeModal" data-bs-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary" id="saveInfo" onclick="saveInfo();">Guardar</button>
			</div>
			</div>
		</div>
	</div>

	<script>
	var idp = "<?php echo $id_producto; ?>";
	function saveInfo() {
		$("#saveInfo").attr("disabled", true);
		$("#saveInfo").addClass("disabled");
		$.ajax({
			type: 'POST',
			url: '/server/',
			data: 'o=2&t='+$("#titleForm").val()+'&p='+$("#priceForm").val()+'&d='+$("#descForm").val()+'&i='+idp,
			dataType: 'json',
			success: function(data) {
				var title = $("#titleForm").val();
				var price = $("#priceForm").val();
				var desc = $("#descForm").val();
				$(".titleLabel").html(title);
				$(".priceLabel").html("$" + price);
				$(".descLabel").html(desc);
				$("#saveInfo").attr("disabled", false);
				$("#saveInfo").removeClass("disabled");
				$(".closeModal").trigger("click");
				$("#titleForm").val(title).attr("placeholder", title);
				$("#priceForm").val(price).attr("placeholder", price);
				$("#descForm").val(desc).attr("placeholder", desc);
			}
		});
	}
    
</script>
	
<?php include_once'footer.php';?>
