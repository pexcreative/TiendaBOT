<?php
    require_once "config.php";

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
    <title>Compra ahora <?php echo $titulo;?></title>
	<?php include_once'head.php';?>

</head>

<body>
    <?php include_once'menu.php';?>
	
    <section id="producto" class="py-3">
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-12">
                    <h1 class="text-capitalize fs-3 text-center sombra">Finaliza tu compra</h1>
                </div>
                <div class="col-md-12 mb-3">
                    <?php include_once'ficha-producto.php';?>
                </div>
                <div class="col-md-5 mx-auto">
                    <p>Luego de completar con tus datos te enviaremos al correo la factura.</p>
                    <div id="ok"></div>
                    <div>
                        <form id="form_compra" class="form-pexsell" method="post">
                            <div class="input-group mb-2"><input class="form-control rounded" type="text" id="nombre" name="nombre" placeholder="Nombre" autocomplete="on" inputmode="latin" required=""></div>
                            <div class="input-group mb-2"><input class="form-control rounded" type="text" id="apellido" name="apellido" placeholder="Apellido" autocomplete="on" inputmode="latin" required=""></div>
                            <div class="input-group mb-2"><input class="form-control rounded" type="email" id="email" placeholder="Tu correo" name="email" required="" autocomplete="on" inputmode="email"></div>
                            <div class="input-group mb-2"><input class="form-control rounded" type="number" data-bs-toggle="tooltip" data-bss-tooltip="" id="tel" required="" placeholder="Tu Whatsapp" name="tel" title="Numero completo. Ejemplo: 5491169200232"></div>
                            <div class="input-group mb-2"><input class="form-control rounded" type="text" id="ciudad" name="ciudad" placeholder="Ciudad" autocomplete="on"></div>
                            <div class="input-group mb-2"><input class="form-control rounded" type="text" id="cp" name="cp" placeholder="Código postal" autocomplete="on"></div>
                            <div class="input-group mb-2"><input class="form-control rounded" type="text" id="calle" name="calle" placeholder="Calle" autocomplete="on" required=""></div>
                            <div class="input-group mb-3"><input class="form-control rounded" type="text" id="numerocasa" name="numerocasa" placeholder="Número" required=""></div><label class="form-label fw-semibold mb-1">Cantidad de unidades:</label><input class="form-control rounded mb-1" type="number" id="cantidad" name="cantidad" placeholder="1" value="1"><label class="form-label fw-semibold mb-1">Mensaje adicional:</label><textarea class="form-control rounded mb-3" id="mensaje" name="mensaje" placeholder="Por favor escribe aquí si neceistas aclarar algún detalle para recibir tus paquetes." rows="8" cols="30" required=""></textarea>
                            <div class="d-flex justify-content-center item-group"><input class="btn btn-primary pulse animated infinite rounded text-black text-uppercase" type="submit" id="enviar_compra" value="Comprar Ahora" name="enviar" style="animation-duration: 3s;"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include_once'footer.php';?>

<script>
    var msg = "";
    var color = localStorage.getItem("color");
    if(color && color != "") {
        localStorage.removeItem("color");
        msg = ` Color: ${color}`
    }
    var talle = localStorage.getItem("talle");
    if(talle && talle != "") {
        localStorage.removeItem("talle");
        msg += ` Talle: ${talle}`
    }
    console.log("mess", msg);
    $("#mensaje").val(msg);
</script>