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

//OBTENER ID PRODUCTO
$id_producto = isset($_REQUEST["sku"])? $_REQUEST["sku"] : '';
$id_producto = base64_decode($id_producto);

//CONSULTANDO DATOS DEL ITEM
$url = "https://api.mercadolibre.com/items/".$id_producto;
$sitioweb = curl($url);
$info = json_decode($sitioweb);
$categorias = isset($info->category_id)? $info->category_id : '';
$titulo = isset($info->title)? $info->title : '';
$precio = isset($info->price)? $info->price : '';
$currency_id = isset($info->currency_id)? $info->currency_id : '';
$imagen_principal = isset($info->pictures[0]->secure_url)? $info->pictures[0]->secure_url : 'assets/img/sin-imagen.png';

?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Consulta por el producto</title>
    <?php include_once'head.php';?>
	
</head>

<body>
    <?php include_once'menu.php';?>
	
    <section id="producto" class="py-3">
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-12">
                    <h1 class="fs-3 text-center sombra">¿Tienes Dudas O Consultas Por Este Producto?</h1>
                </div>
                <div class="col-md-12 mb-3">
					<?php include 'ficha-producto.php';?>
                </div>
                <div class="col-md-5 mx-auto">
                    <div id="ok"></div>
                    <div>
                        <form id="form_consulta" class="form-pexsell" method="post">
                            <div class="input-group mb-2">
								<input class="form-control rounded" type="text" id="nombre" name="nombre" placeholder="Nombre" autocomplete="on" inputmode="latin" required="">
							</div>
                            <div class="input-group mb-2">
								<input class="form-control rounded" type="text" id="apellido" name="apellido" placeholder="Apellido" autocomplete="on" inputmode="latin" required="">
							</div>
                            <div class="input-group mb-2">
								<input class="form-control rounded" type="email" id="email" placeholder="Tu correo" name="email" required="" autocomplete="on" inputmode="email">
							</div>
                            <div class="input-group mb-2">
								<input class="form-control rounded" type="number" data-bs-toggle="tooltip" data-bss-tooltip="" id="tel" required="" placeholder="Tu Whatsapp" name="tel" title="Numero completo. Ejemplo: 5491169200232">
							</div>
                            <div class="input-group mb-2">
								<textarea class="form-control rounded" id="mensaje" name="mensaje" placeholder="Por favor escribe tu consulta..." rows="8" cols="30" required=""></textarea>
							</div>
                            <div class="d-flex justify-content-center item-group">
								<input class="btn btn-primary pulse animated infinite rounded text-black text-uppercase" type="submit" id="enviar_consulta" value="Enviar Consulta" name="enviar" style="animation-duration: 3s;">
							</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include_once'footer.php';?>