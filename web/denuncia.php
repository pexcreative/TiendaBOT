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
    <title>DENUNCIA</title>
    <?php include_once'head.php';?>
	
</head>

<body>
    <?php include_once'menu.php';?>
	
    <section id="producto" class="py-3">
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-12">
                    <h1 class="fs-3 text-center sombra">¿Por qué quieres reportar este producto?</h1>
                </div>
                <div class="col-md-12 mb-3">
                    <?php include 'ficha-producto.php';?>
                </div>
                <div class="col-md-6 mx-auto">
                    <div id="ok"></div>
                    <div>
                        <form id="form_denuncia" class="form-pexsell" method="post">
                            <div class="my-3">
                                <div class="form-check mb-0 mb-1"><input class="form-check-input" type="radio" id="radio1" name="opcion" value="Es evidente que vende una copia o una falsificación"><label class="form-check-label" for="radio1">Es evidente que vende una copia o una falsificación.</label></div>
                                <div class="form-check mb-0 mb-1"><input class="form-check-input" type="radio" id="radio2" name="opcion" value="El producto es ilegal o no cumple con nuestras políticas de artículos prohibidos."><label class="form-check-label" for="radio2">El producto es ilegal o no cumple con nuestras políticas de artículos prohibidos.</label></div>
                                <div class="form-check mb-1"><input class="form-check-input" type="radio" id="radio3" name="opcion" value="Creo que es un intento de fraude."><label class="form-check-label" for="radio3">Creo que es un intento de fraude.</label></div>
                                <div class="form-check mb-1"><input class="form-check-input" type="radio" id="radio4" name="opcion" value="Quiere cobrar un precio diferente o hay incoherencias con el precio y los productos de la publicación."><label class="form-check-label" for="radio4">Quiere cobrar un precio diferente o hay incoherencias con el precio y los productos de la publicación.</label></div>
                            </div>
                            <div class="input-group mb-2"><input class="form-control rounded" type="text" id="nombre" name="nombre" placeholder="Nombre" autocomplete="on" inputmode="latin" required=""></div>
                            <div class="input-group mb-2"><input class="form-control rounded" type="text" id="apellido" name="apellido" placeholder="Apellido" autocomplete="on" inputmode="latin" required=""></div>
                            <div class="input-group mb-2"><input class="form-control rounded" type="email" id="email" placeholder="Tu correo" name="email" required="" autocomplete="on" inputmode="email"></div><label class="form-label">Cuéntanos más sobre tu reporte</label><textarea class="form-control rounded mb-2" id="mensaje" name="mensaje" rows="6" cols="30" placeholder="Opcional."></textarea>
                            <div class="d-flex justify-content-center item-group"><input class="btn btn-primary pulse animated infinite rounded text-black text-uppercase" type="submit" id="enviar_denuncia" value="Reportar" name="enviar" style="animation-duration: 3s;"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include_once'footer.php';?>