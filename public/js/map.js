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

function addInteractivePlace(lat, lng, data) {
    const marker = L.marker([lat, lng]).addTo(placesLayer);

    marker.on('click', () => {
        // Invece di aprire un popup, apriamo il drawer laterale
        openStory(data);
        
        // Opzionale: centra la mappa sul punto cliccato con un effetto fluido
        map.flyTo([lat, lng], 15, { duration: 1.5 });
    });
}

// Quando clicchi sulla mappa, si apre un form o ti chiede i dati
map.on('contextmenu', function(e) {
    const name = prompt("Nome del nuovo luogo:");
    if (!name) return;

    const lat = e.latlng.lat;
    const lng = e.latlng.lng;

    fetch('/api/places/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            name: name,
            lat: lat,
            lng: lng,
            description: "Aggiunto via mappa"
        })
    })
    .then(res => {
        if (!res.ok) return res.text().then(t => { throw t });
        return res.json();
    })
    .then(data => {
        // Controlliamo se 'data' e 'data.place' esistono prima di leggere 'name'
    if (data && data.place) {
        alert("Luogo salvato: " + data.place.name);
    } else {
        alert("Luogo salvato correttamente!");
    }
    loadPlaces();
    })
    .catch(err => {
        alert("Errore durante il salvataggio! Controlla i log.");
        console.error(err);
    });
});