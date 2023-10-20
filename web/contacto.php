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


?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Contáctanos</title>
    <?php include_once'head.php';?>
	
</head>

<body>
    <?php include_once'menu.php';?>
	
    <section id="producto" class="py-3">
        <div class="container">
            <div class="row my-3">
                <div class="col-md-12">
                    <h1 class="fs-3 text-center sombra mb-3">Comunícate con nosotros</h1>
                </div>
                <div class="col-md-5 mx-auto mb-3">
                    <div id="ok"></div>
                    <div>
                        <form id="form_contacto" class="form-pexsell" method="post">
                            <div class="input-group mb-2">
								<input class="form-control rounded" type="text" id="nombre" name="nombre" placeholder="Nombre" autocomplete="on" inputmode="latin" required="">
							</div>
                            <div class="input-group mb-2">
								<input class="form-control rounded" type="number" data-bs-toggle="tooltip" data-bss-tooltip="" id="tel" required="" placeholder="Tu Whatsapp" name="tel" title="Numero completo. Ejemplo: 5491169200232">
							</div>
                            <div class="input-group mb-2">
								<input class="form-control rounded" type="email" id="email" placeholder="Tu correo" name="email" required="" autocomplete="on" inputmode="email">
							</div>
							<label class="form-label mb-0">¿Como nos conociste?</label>
							<select class="form-select rounded mb-2" id="conocio" name="conocio">
                                <optgroup label="¿Cómo nos conociste?">
                                    <option value="Publicidad por correo">Publicidad por correo</option>
                                    <option value="Google" selected="">Google</option>
                                    <option value="Bing">Bing</option>
                                    <option value="Recomendado">Recomendado</option>
                                </optgroup>
                            </select>
							<label class="form-label mb-0">Asunto:</label>
							<select class="form-select rounded mb-2" id="asunto" name="asunto">
                                <optgroup label="Asunto">
                                    <option value="Consulta" selected="">Consulta</option>
                                    <option value="Sugerencia">Sugerencia</option>
                                    <option value="Reclamo">Reclamo</option>
                                </optgroup>
                            </select>
							<label class="form-label mb-0">Mensaje:</label>
                            <div class="input-group mb-3">
								<textarea class="form-control rounded" id="mensaje" name="mensaje" placeholder="Por favor escribe tu mensaje..." rows="8" cols="30" required=""></textarea>
							</div>
                            <div class="d-flex justify-content-center item-group mb-3">
								<input class="btn btn-primary pulse animated infinite rounded text-black text-uppercase" type="submit" id="enviar_contacto" value="Enviar ahora!" name="enviar" style="animation-duration: 3s;">
							</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
	
<?php include_once'footer.php';?>