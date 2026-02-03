// Aspetta che il DOM sia pronto
if (typeof document.getElementById('map') === 'undefined') {
    console.error('Elemento #map non trovato!');
} else {
    // Crea mappa
    window.map = L.map('map', {
        center: [43.8564, 18.4131],
        zoom: 7,
        zoomControl: true,
        tap: false
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 18
    }).addTo(window.map);

    // IMPORTANTE: Rendi globali usando window
    window.placesLayer = L.layerGroup().addTo(window.map);
    window.citiesLayer = L.layerGroup().addTo(window.map);

    // Shorthand per compatibilità
    var map = window.map;
    var placesLayer = window.placesLayer;
    var citiesLayer = window.citiesLayer;

    console.log('✅ Mappa inizializzata');
    console.log('✅ placesLayer creato:', window.placesLayer);

    map.on('click', e => {
        console.log("Coordinate: lat=" + e.latlng.lat.toFixed(4) + ", lng=" + e.latlng.lng.toFixed(4));
        navigator.clipboard.writeText(`[${e.latlng.lat.toFixed(4)}, ${e.latlng.lng.toFixed(4)}]`);
        console.log("✅ Coordinate copiate!");
    });

    const audio = document.getElementById('ambient-audio');

    if (audio) {
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
    }

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
}