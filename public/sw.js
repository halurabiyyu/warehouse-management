const CACHE_NAME = "warehouse-v1";
const urlsToCache = [
  "/",
  "/manifest.json"
];

console.log("Service Worker loading...");

self.addEventListener("install", event => {
  console.log("SW Install event triggered");
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        console.log("Cache opened:", CACHE_NAME);
        return cache.addAll(urlsToCache);
      })
      .then(() => {
        console.log("All files cached successfully");
        return self.skipWaiting();
      })
      .catch(error => {
        console.error("Install failed:", error);
      })
  );
});

self.addEventListener("activate", event => {
  console.log("SW Activate event triggered");
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheName !== CACHE_NAME) {
            console.log("Deleting old cache:", cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    }).then(() => {
      console.log("SW activated successfully");
      return self.clients.claim();
    })
  );
});

self.addEventListener("fetch", event => {
  event.respondWith(
    caches.match(event.request)
      .then(response => {
        if (response) {
          console.log("Serving from cache:", event.request.url);
          return response;
        }
        return fetch(event.request).catch(error => {
          console.log("Fetch failed:", error);
        });
      })
  );
});
