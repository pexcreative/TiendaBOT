<meta name="theme-color" content="#FFC600">
<link rel="icon" href="<?php echo $icon;?>" type="image/x-icon">
<link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="/assets/css/Inter.css">
<link rel="stylesheet" href="/assets/css/Open%20Sans.css">
<link rel="stylesheet" href="/assets/css/aos.css">
<link rel="stylesheet" href="/assets/css/animate.min.css">
<link rel="stylesheet" href="/assets/css/lightbox.min.css">
<link rel="stylesheet" href="/assets/css/z-personalizado.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anton&family=Open+Sans:wght@300&family=Signika+Negative:wght@700&display=swap" rel="stylesheet">
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
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-6L7DW9G8V9"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-6L7DW9G8V9');
</script>