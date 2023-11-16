<?php
$url_ganancia = 'https://tiendaspexbot-default-rtdb.firebaseio.com/-NhPDwNYG-e7PzB0eSYl.json';
$ganancia = curl($url_ganancia);
$infog = json_decode($ganancia);
$porcentaje = isset($infog->ganancia)? $infog->ganancia : '';

if ($precio > 100000) {
	$precio += $precio * 0.05;  // Aumenta en un 5%
} elseif ($precio <= 100000 && $precio > 50000) {
	$precio += $precio * 0.10;  // Aumenta en un 10%
} elseif ($precio <= 50000 && $precio > 10000) {
	$precio += $precio * 0.20;  // Aumenta en un 20%
} elseif ($precio <= 10000) {
	$precio += $precio * 0.30;  // Aumenta en un 30%
}
?>