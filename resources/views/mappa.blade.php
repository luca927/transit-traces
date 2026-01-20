<!DOCTYPE html>
<html>
<head>
    <title>Transit Traces 🏕️ Domiz Camp</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        #map { height: 100vh; width: 100%; }
        .controls {
            position: fixed; top: 10px; left: 10px; 
            background: white; padding: 20px; border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3); z-index: 1000; 
            font-family: Arial; width: 320px; max-width: 320px;
            box-sizing: border-box;
        }
/* HEADER TRASPARENTE SOPRA MAPPA */
header { 
    position: fixed; 
    top: 0; 
    right: 40px; 
    left: auto; 
    padding: 1rem 1.5rem; 
    z-index: 2000; 
    display: flex; 
    gap: 1rem;
    align-items: center; 
    backdrop-filter: blur(5px);
    border-radius: 0 0 0 25px;
}

/* Icone social */
header a[href*="facebook"],
header a[href*="twitter"] {
    margin-right: 1rem;
}

/* Stile per i link delle lingue */
header a {
    color: #000;
    text-decoration: none;
    transition: color 0.3s ease;
}

header a:hover,
header a:active,
header a:focus {
    color: #0066cc;
}

/* SIDEBAR SINISTRA */
.leaflet-control-container .leaflet-top.leaflet-left {
    margin: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0;
}

/* Controlli zoom rimangono in alto */
.leaflet-control-zoom {
    order: 1;
}

/* Pannello Refugee Republic sotto i controlli zoom */
.leaflet-control-layers,
.leaflet-control:not(.leaflet-control-zoom) {
    order: 2;
    margin-top: 5rem !important;
}

/* SIDEBAR SINISTRA - Pannello Controls */
.controls {
    position: fixed;
    top: 6rem;
    left: 1rem;
    z-index: 1000;
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    padding: 0;
    min-width: 320px;
    max-width: 400px;
}

/* Titolo Refugee Republic */
.controls h3,
#controls-title {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1rem 1.25rem;
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    border-radius: 15px 15px 0 0;
}

/* Campo di ricerca */
.controls input[type="text"],
#search {
    width: calc(100% - 2rem);
    padding: 1rem 1.25rem;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    margin: 1.25rem 1rem 1rem 1rem;
    box-sizing: border-box;
    display: block;
}

.controls input[type="text"]::placeholder,
#search::placeholder {
    color: #999;
}

.controls input[type="text"]:focus,
#search:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Select dropdown */
.controls select,
#filter {
    width: calc(100% - 2rem);
    padding: 1rem 1.25rem;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 1rem;
    margin: 1rem;
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
    display: block;
    box-sizing: border-box;
}

.controls select:focus,
#filter:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Bottone Aggiorna */
.controls button {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 1rem 1.5rem;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 0 1rem 1.25rem 1rem;
    width: calc(100% - 2rem);
    display: block;
    box-sizing: border-box;
}

.controls button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.controls button:active {
    transform: translateY(0);
}

/* Stats */
.controls .stats,
#stats {
    padding: 0.5rem 1.25rem 1rem 1.25rem;
    margin: 0;
    color: #666;
    font-size: 0.9rem;
    font-weight: 500;
}

/* Titolo Refugee Republic */
.leaflet-control h3,
.leaflet-control-layers-base h3 {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1rem 1.25rem;
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* Campo di ricerca */
.leaflet-control input[type="text"] {
    width: calc(100% - 2rem);
    padding: 0.85rem 1.25rem;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    margin: 1.25rem 1rem;
    box-sizing: border-box;
}

.leaflet-control input[type="text"]::placeholder {
    color: #999;
}

.leaflet-control input[type="text"]:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Select dropdown */
.leaflet-control select {
    width: calc(100% - 2rem);
    padding: 0.85rem 1.25rem;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 0.95rem;
    margin: 0 1rem 1.25rem 1rem;
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
}

.leaflet-control select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Bottone Aggiorna */
.leaflet-control button,
.leaflet-control input[type="button"] {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 0.85rem 1.5rem;
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 0 1rem 1.25rem 1rem;
    width: calc(100% - 2rem);
}

.leaflet-control button:hover,
.leaflet-control input[type="button"]:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.leaflet-control button:active,
.leaflet-control input[type="button"]:active {
    transform: translateY(0);
}

/* Contatore luoghi */
.leaflet-control p {
    padding: 0.5rem 1.25rem 1rem 1.25rem;
    margin: 0;
    color: #666;
    font-size: 0.9rem;
    font-weight: 500;
}

/* Controlli zoom */
.leaflet-control-zoom {
    border: none;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
}

.leaflet-control-zoom a {
    width: 42px;
    height: 42px;
    line-height: 42px;
    font-size: 1.3rem;
    border: none;
    transition: all 0.3s ease;
}

.leaflet-control-zoom a:hover {
    background: #667eea;
    color: white;
}

.leaflet-control-zoom a:first-child {
    border-bottom: 1px solid #e0e0e0;
}

.video-fade {
    opacity: 0;
    transform: scale(0.98);
    transition: opacity 0.6s ease, transform 0.6s ease;
}

.video-fade.loaded {
    opacity: 1;
    transform: scale(1);
}

</style>

</head>
<body>
    <!-- HEADER CON I TUOI BUTTON -->
    <header>
        <!-- Social Icons SINISTRA -->
        <div class="social-header">
            <a href="https://facebook.com/transittraces" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com/transittraces" target="_blank"><i class="fab fa-twitter"></i></a>
        </div>
        
        <!-- I TUOI BUTTON DESTRA -->
      <div class="language-switcher" style="
    display: flex; 
    gap: 0.5rem; 
    font-family: Arial; 
    font-size: 0.85rem; 
    font-weight: 500;
">
    <a href="#" onclick="setLanguage('it'); return false;" id="it-btn"
       style="color: white; text-decoration: none; padding: 0.3rem 0.8rem; 
              border-radius: 4px; transition: all 0.3s ease; background: #1e40af;">
        ITALIANO
    </a>

    <a href="#" onclick="setLanguage('en'); return false;" id="en-btn"
       style="color: #0e0c0b; text-decoration: none; padding: 0.3rem 0.8rem; 
              border-radius: 4px; border: 1px solid #0e0c0b; transition: all 0.3s ease;">
        ENGLISH
    </a>
</div>
    </header>

    <div class="controls">
        <h3 id="controls-title">🏕️ Refugee Republic</h3>
        <input type="text" id="search" placeholder="Cerca luoghi...">
        <select id="filter">
            <option value="">Tutti i luoghi</option>
            <option value="Ahmed">Ahmed Stall</option>
            <option value="Fatma">Fatma Spot</option>
            <option value="Entrance">Domiz Entrance</option>
        </select>
        <button onclick="loadPlaces()">🔄 Aggiorna</button>
        <div class="stats" id="stats">Caricamento...</div>
    </div>
    <div id="map"></div>
    <!-- audio mappa -->
    <audio id="ambient-audio" src="/audio/ambient.mp3" loop></audio>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>

        var map = L.map('map').setView([36.805, 43.105], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

     const audio = document.getElementById('ambient-audio');

// 1) Avvio in mute quando la mappa è pronta
map.whenReady(() => {
    audio.volume = 1;
    audio.muted = true;

    // Aspetta che il file sia pronto
    audio.addEventListener('canplaythrough', () => {
        audio.play().catch(() => {});
    }, { once: true });
});

// 2) Sblocco al primo click OVUNQUE
document.addEventListener('click', () => {
    if (audio.muted) {
        audio.muted = false;
    }
}, { once: true });
    // Quando si apre un popup → avvia il video e applica fade-in
    map.on('popupopen', function (e) {
        const video = e.popup._contentNode.querySelector('video');
        if (video) {
            video.muted = true;
            video.play().catch(() => {});
            setTimeout(() => video.classList.add('loaded'), 50);
        }
    });

    // 1️⃣ CREA PRIMA I LAYER
    var placesLayer = L.layerGroup().addTo(map);   // luoghi filtrati
    var citiesLayer = L.layerGroup().addTo(map);   // città fisse

    // 2️⃣ AGGIUNGI LE CITTÀ
    const cities = [
        { name: "Domiz", lat: 36.805, lng: 43.105 },
        { name: "Duhok", lat: 36.867, lng: 42.988 },
        { name: "Ahmed", lat: 36.82, lng: 43.12}
    ];

    cities.forEach(city => {
        L.marker([city.lat, city.lng])
            .addTo(citiesLayer)
            .bindPopup(`<b>${city.name}</b>`);
    });

    // 3️⃣ VARIABILI GLOBALI
    var allPlaces = [];
    let currentLang = 'it';

    // 4️⃣ CARICA I LUOGHI DAL SERVER
    function loadPlaces() {
        fetch('/places')
            .then(r => r.json())
            .then(places => {
                allPlaces = places;
                document.getElementById('stats').innerHTML =
                    `${places.length} luoghi trovati`;
                filterPlaces();
            });
    }

    const tentIcon = L.divIcon({
    html: `
        <svg viewBox="0 0 36 28" xmlns="http://www.w3.org/2000/svg">
          <path d="M2 24L18 4L34 24H2Z" fill="#d9c7a3" stroke="#6e5b4b" stroke-width="2"/>
          <path d="M18 4V24" stroke="#6e5b4b" stroke-width="2"/>
        </svg>
    `,
    className: 'custom-marker',
    iconSize: [36, 36],
    iconAnchor: [18, 28]
    });

    const stallIcon = L.divIcon({
        html: `
            <svg viewBox="0 0 40 32" xmlns="http://www.w3.org/2000/svg">
            <rect x="4" y="14" width="32" height="14" fill="#d9c7a3" stroke="#6e5b4b" stroke-width="2"/>
            <path d="M4 14L8 4H32L36 14H4Z" fill="#bfa98a" stroke="#6e5b4b" stroke-width="2"/>
            </svg>
        `,
        className: 'custom-marker',
        iconSize: [40, 40],
        iconAnchor: [20, 32]
    });

    const spotIcon = L.divIcon({
        html: `
            <svg viewBox="0 0 28 28" xmlns="http://www.w3.org/2000/svg">
            <circle cx="14" cy="14" r="12" fill="#d9c7a3" stroke="#6e5b4b" stroke-width="2"/>
            <circle cx="14" cy="14" r="5" fill="#6e5b4b"/>
            </svg>
        `,
        className: 'custom-marker',
        iconSize: [28, 28],
        iconAnchor: [14, 28]
    });

    // 5️⃣ FILTRO E AGGIUNTA DEI MARKER
    function filterPlaces() {
    var search = document.getElementById('search').value.toLowerCase();
    var filter = document.getElementById('filter').value;

    // Cancella SOLO i luoghi, NON le città
    placesLayer.clearLayers();

    var filtered = allPlaces.filter(place => {
        var matchesSearch = !search ||
            place.name.toLowerCase().includes(search) ||
            place.description.toLowerCase().includes(search);

        var matchesFilter = !filter ||
            place.name.includes(filter) ||
            place.description.includes(filter);

        return matchesSearch && matchesFilter;
    });

    filtered.forEach((place, index) => {

        // Scegli l'icona giusta
        let iconToUse = spotIcon; // default

        if (place.name.includes('Domiz')) {
            iconToUse = tentIcon;
        } else if (place.name.includes('Ahmed')) {
            iconToUse = stallIcon;
        }

        // Offset per evitare sovrapposizioni
        var offset = index * 0.00003;

        // CREA IL MARKER
        var marker = L.marker(
            [parseFloat(place.latitude) + offset, parseFloat(place.longitude) + offset],
            { icon: iconToUse }
        ).addTo(placesLayer);

        // POPUP
        marker.bindPopup(`
            <div style="width: 300px; font-family: Arial; line-height: 1.4;">
                <h3 style="color: #e67e22; margin: 0 0 15px 0; font-size: 18px; border-bottom: 2px solid #e67e22;">
                    🏕️ ${place.name}
                </h3>
                <video class = "video-fade" 
                    poster="https://via.placeholder.com/300x180/FF8C00/white?text=${place.name}"
                    controls preload="metadata" style="width: 100%; border-radius: 8px; margin-bottom: 12px;">
                    <source src="${place.video_url}" type="video/mp4">
                    Video non supportato.
                </video>
                <p style="margin: 8px 0; color: #333;">📍 ${place.description}</p>
                <div style="background: #f8f8f8; padding: 10px; border-radius: 5px; font-size: 12px; color: #666;">
                    ID: ${place.id} | Domiz Camp
                </div>
            </div>
        `);
    });

    document.getElementById('stats').innerHTML =
        `${filtered.length}/${allPlaces.length} luoghi mostrati`;
    }
            // ✅ I TUOI BUTTON FUNZIONANO!
            function setLanguage(lang) {
                currentLang = lang;
                const italianoBtn = document.getElementById('it-btn');
                const englishBtn = document.getElementById('en-btn');
                
                if (lang === 'it') {
                    italianoBtn.style.background = '#1e40af';
                    italianoBtn.style.color = 'white';
                    italianoBtn.style.border = 'none';
                    englishBtn.style.background = 'transparent';
                    englishBtn.style.color = '#0e0c0b';
                    englishBtn.style.border = '1px solid #0e0c0b';
                    document.getElementById('controls-title').textContent = '🏕️ Refugee Republic';
                    document.getElementById('search').placeholder = 'Cerca luoghi...';
                } else {
                    englishBtn.style.background = '#1e40af';
                    englishBtn.style.color = 'white';
                    englishBtn.style.border = 'none';
                    italianoBtn.style.background = 'transparent';
                    italianoBtn.style.color = '#0e0c0b';
                    italianoBtn.style.border = '1px solid #0e0c0b';
                    document.getElementById('controls-title').textContent = '🏕️ Domiz Map';
                    document.getElementById('search').placeholder = 'Search places...';
                }
            }


            // Init italiano + mappa
            setLanguage('it');
            loadPlaces();
            
            // Filter su keyup
            document.getElementById('search').onkeyup = filterPlaces;
            document.getElementById('filter').onchange = filterPlaces;
</script>
</body>
</html>
