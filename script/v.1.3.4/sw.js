self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open('pexsell').then(function(cache) {
            return cache.addAll([
                '/',
                '/index.php',
                '/manifest.json',
                '/icon.png' // Agrega aqu� otros recursos
            ]);
        })
    );
});

self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request).then(function(response) {
            return response || fetch(event.request);
        })
    );
});