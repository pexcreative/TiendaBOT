<meta name="theme-color" content="#FFC600">
<link rel="icon" href="<?php echo $icon;?>" type="image/x-icon">
<link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="/assets/css/Inter.css">
<link rel="stylesheet" href="/assets/css/Open%20Sans.css">
<link rel="stylesheet" href="/assets/css/aos.css">
<link rel="stylesheet" href="/assets/css/animate.min.css">
<link rel="stylesheet" href="/assets/css/lightbox.min.css">
<link rel="stylesheet" href="/assets/css/z-personalizado.css">
<link rel="manifest" href="/manifest.json">
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js')
                .then(function(registration) {
                    console.log('Service Worker registrado con éxito:', registration);
                })
                .catch(function(error) {
                    console.log('Error al registrar el Service Worker:', error);
                });
        }
    </script>