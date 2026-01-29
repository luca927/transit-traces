// =========================
// CREA MAPPA ILLUSTRATA
// =========================

var map = L.map('map', {
    center: [43.8564, 18.4131], // Centro sui Balcani (Sarajevo)
    zoom: 7,
    zoomControl: true,
    tap: false
});

// =========================
// LAYER DI BASE E GRUPPI
// =========================

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors',
    maxZoom: 18
}).addTo(map);

// Layer groups
var placesLayer = L.layerGroup().addTo(map);
var citiesLayer = L.layerGroup().addTo(map);

// =========================
// CLICK → COORDINATE GEOGRAFICHE
// =========================

map.on('click', e => {
    console.log("Coordinate: lat=" + e.latlng.lat.toFixed(4) + ", lng=" + e.latlng.lng.toFixed(4));
    // Copia negli appunti
    navigator.clipboard.writeText(`[${e.latlng.lat.toFixed(4)}, ${e.latlng.lng.toFixed(4)}]`);
    console.log("✅ Coordinate copiate negli appunti!");
});


// =========================
// AUDIO AMBIENTALE
// =========================

const audio = document.getElementById('ambient-audio');

map.whenReady(() => {
    audio.volume = 0.3;
    audio.muted = true;

    audio.addEventListener('canplaythrough', () => {
        audio.play().catch(() => {});
    }, { once: true });
});

document.addEventListener('click', () => {
    if (audio.muted) audio.muted = false;
}, { once: true });

// =========================
// VIDEO NEI POPUP
// =========================

map.on('popupopen', e => {
    const video = e.popup._contentNode.querySelector('video');
    if (video) {
        video.muted = false;
        video.play().catch(() => {});
        setTimeout(() => video.classList.add('loaded'), 50);
    }
});

map.on('popupclose', e => {
    const video = e.popup._contentNode.querySelector('video');
    if (video) {
        video.pause();
    }
});