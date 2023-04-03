const OFFLINE_VERSION = 2;
const cacheName = 'pwa-cache';
// Customize this with a different URL if needed.
const urlsToCache = ['/index.html', '/src/css/calendar.css', '/src/css/footer.css', '/src/css/style.css', '/src/css/styles.css', 'js/calendar.js'];

// install service worker
self.addEventListener('install', (e) => {
    console.log('sw installed');
    e.waitUntil(
        caches.open(cacheName)
            .then(cache => cache.addAll(urlsToCache))
    );
});

// activate service worker
self.addEventListener("activate", (e) => {
    console.log('sw activated');
    e.waitUntil(
        (async () => {
            // Enable navigation preload if it's supported.
            if ("navigationPreload" in self.registration) {
                await self.registration.navigationPreload.enable();
            }
        })
    );

    // Tell the active service worker to take control of the page immediately.
    self.clients.claim();
});

// fetch (network first, then cache)
self.addEventListener('fetch', function (e) {
    e.respondWith(
        fetch(e.request)
            .then(function (response) {
                // If you have internet connection, cache the data so you have it when ur offline
                let responseToCache = response.clone();
                caches.open(cacheName)
                    .then(function (cache) {
                        cache.put(e.request, responseToCache);
                    });
                return response;
            })
            .catch(function () {
                // If there is no network connection, use the cache
                return caches.match(e.request);
            })
    );
});