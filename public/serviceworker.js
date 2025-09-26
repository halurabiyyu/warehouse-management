const CACHE_NAME = "warehouse-cache-v1";
const urlsToCache = [
    "/",
    "/css/app.css",
    "/js/app.js",
    "/manifest.json"
];

// Install
self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return Promise.all(
                urlsToCache.map((url) =>
                    fetch(url).then((response) => {
                        if (response.ok) {
                            return cache.put(url, response.clone());
                        } else {
                            console.warn("Skip caching:", url, response.status);
                        }
                    }).catch((err) => {
                        console.error("Failed to cache:", url, err);
                    })
                )
            );
        })
    );
});
