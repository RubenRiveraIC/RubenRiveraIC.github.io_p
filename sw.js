
const CACHE_NAME = 'CachePWA_V1',
  urlsToCache = [
    './',
    './index.php',
    './components/headdoc.php',
    './components/footer.php',
    './components/menubar.php',
    './components/navbar.php',
    './AccountSettings.php',
    './cambia_pass.php',
    './Cambia_Sys.php',
    './guarda_pass.php',
    './logout.php',
    './manifest.json',
    './password.php',
    './principal.php',
    './register.php',
    './assets/img/cropped-icon-32x32.png',
    './assets/img/icon_piping_64.png',
    './assets/img/icon_well_96.png',
    './assets/img/Logo_WebTelemetryW.png',
    './assets/img/logo.png.png',
    './assets/img/WebTelemetry_ICON_1024.png',
    './assets/img/WebTelemetry_ICON_512.png',
    './assets/img/WebTelemetry_ICON_384.png',
    './assets/img/WebTelemetry_ICON_256.png',
    './assets/img/WebTelemetry_ICON_192.png',
    './assets/img/WebTelemetry_ICON_128.png',
    './assets/img/WebTelemetry_ICON_96.png',
    './assets/img/WebTelemetry_ICON_64.png',
    './assets/img/WebTelemetry_ICON_32.png',
    './css/bootstrap-theme.min.css',
    './css/bootstrap.min.css',
    './css/daterangepicker.css',
    './css/font-awesome.min.css',
    './css/styles.css',
    './css/sweetalert2.css',
    './funcs/Bombas.php',
    './funcs/fetchDatos.php',
    './funcs/fetchDatosIV.php',
    './funcs/fetchDatosJ.php',
    './funcs/fetchDatosJ2.php',
    './funcs/fetchDatosLH.php',
    './funcs/fetchDatosLHIV.php',
    './funcs/fetchDatosLHJ.php',
    './funcs/fetchDatosLHJ2.php',
    './funcs/fetchSystem.php',
    './funcs/funcs.php',
    './funcs/idSensores.php',
    './js/jmespath/jmespath.js',
    './js/all.min.js',
    './js/api.js',
    './js/apps.js',
    './js/bootstrap.bundle.min.js',
    './js/bootstrap.min.js',
    './js/chart.js',
    './js/chartjs-plugin-zoom.min.js',
    './js/datepicker.js',
    './js/daterangepicker.min.js',
    './js/hammer.min.js',
    './js/jquery-3.6.0.min.js',
    './js/jquery-3.4.1.min.js',
    './js/moment-with-locales.min.js',
    './js/moment.min.js',
    './js/mqtt.min.js',
    './js/scripts.js',
    './sw.js',
    './js/sweetalert2.js',
    'https://htech.mx/'
  ]
//durante la fase de instalación, generalmente se almacena en caché los activos estáticos
self.addEventListener('install', e => {
  e.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        return cache.addAll(urlsToCache)
          .then(() => self.skipWaiting())
      })
      .catch(err => console.log('Falló registro de cache', err))
  )
})

//una vez que se instala el SW, se activa y busca los recursos para hacer que funcione sin conexión
self.addEventListener('activate', e => {
  const cacheWhitelist = [CACHE_NAME]

  e.waitUntil(
    caches.keys()
      .then(cacheNames => {
        return Promise.all(
          cacheNames.map(cacheName => {
            //Eliminamos lo que ya no se necesita en cache
            if (cacheWhitelist.indexOf(cacheName) === -1) {
              return caches.delete(cacheName)
            }
          })
        )
      })
      // Le indica al SW activar el cache actual
      .then(() => self.clients.claim())
  )
})

// //cuando el navegador recupera una url
// self.addEventListener('fetch', e => {
//   //Responder ya sea con el objeto en caché o continuar y buscar la url real
//   e.respondWith(
//     caches.match(e.request)
//       .then(res => {
//         if (res) {
//           //recuperar del cache
//           return res
//         }
//         //recuperar de la petición a la url
//         return fetch(e.request)
//       })
//   )
// })

// //cuando el navegador recupera una url
// self.addEventListener('fetch', e => {
//   //Responder ya sea con el objeto en caché o continuar y buscar la url real
//   e.respondWith(
//     caches.match(e.request)
//       .then(res => {
//         if (res) {
//           //recuperar del cache
//           return res
//         }
//         //recuperar de la petición a la url
//         return fetch(e.request)
//       })
//   )
// })


// self.addEventListener("fetch", event => {
//    event.respondWith(
//      caches.match(event.request).then(cachedResponse => {
//          const networkFetch = fetch(event.request).then(response => {
//            // update the cache with a clone of the network response
//            caches.open("CachePWA_V1").then(cache => {
//                cache.put(event.request, response.clone());
//            });
//          });
//          // prioritize cached response over network
//          return cachedResponse || networkFetch;
//      }
//    )
//   )
// });

  self.addEventListener("fetch", event => {
     event.respondWith(
       fetch(event.request)
       .catch(error => {
         return caches.match(event.request) ;
       })
     );
  });