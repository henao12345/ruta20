const CACHE = 'ruta20-v1';
const ARCHIVOS = [
  '/ruta20/',
  '/ruta20/public/css/style.css',
  '/ruta20/public/css/bootstrap.css',
  '/ruta20/public/css/responsive.css',
  '/ruta20/public/images/logo.png',
  '/ruta20/public/images/slider-img.png'
];

// Instalar — guardar archivos en caché
self.addEventListener('install', e => {
  e.waitUntil(
    caches.open(CACHE).then(cache => cache.addAll(ARCHIVOS))
  );
});

// Activar — limpiar caché vieja
self.addEventListener('activate', e => {
  e.waitUntil(
    caches.keys().then(keys =>
      Promise.all(keys.filter(k => k !== CACHE).map(k => caches.delete(k)))
    )
  );
});

// Fetch — servir desde caché si no hay internet
self.addEventListener('fetch', e => {
  e.respondWith(
    caches.match(e.request).then(cached => cached || fetch(e.request))
  );
});