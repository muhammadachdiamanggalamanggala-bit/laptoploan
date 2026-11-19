const CACHE_NAME = 'laptoploan-static-v1';
const APP_SHELL = [
    new URL('manifest.webmanifest', self.registration.scope).href,
    new URL('favicon.svg', self.registration.scope).href,
];

self.addEventListener('install', event => {
    event.waitUntil(caches.open(CACHE_NAME).then(cache => cache.addAll(APP_SHELL)));
    self.skipWaiting();
});

self.addEventListener('activate', event => {
    event.waitUntil(caches.keys().then(keys => Promise.all(keys.filter(key => key !== CACHE_NAME).map(key => caches.delete(key)))));
    self.clients.claim();
});

self.addEventListener('fetch', event => {
    if (event.request.method !== 'GET' || new URL(event.request.url).origin !== self.location.origin) return;
    if (event.request.mode === 'navigate') {
        const appRoot = new URL('./', self.registration.scope).href;
        event.respondWith(fetch(event.request).catch(() => caches.match(appRoot)));
        return;
    }
    event.respondWith(caches.match(event.request).then(cached => cached || fetch(event.request)));
});
