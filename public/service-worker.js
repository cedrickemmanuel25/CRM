self.addEventListener('install', (event) => {
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(clients.claim());
});

self.addEventListener('fetch', (event) => {
    // Simple pass-through for now to satisfy PWA requirements
    // In a real production app, we would cache static assets here
    event.respondWith(fetch(event.request));
});
