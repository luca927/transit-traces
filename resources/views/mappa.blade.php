<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Transit Traces 🗺️ Sistema Gerarchico</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --accent: #e67e22;
            --dark: #0e0c0b;
        }

        body, html { margin: 0; padding: 0; height: 100%; font-family: 'Segoe UI', sans-serif; overflow: hidden; }
        #map { height: 100vh; width: 100vw; background: #222; }

        /* HEADER & LANGUAGE */
        header {
            position: fixed; top: 0; right: 0; padding: 15px 30px;
            z-index: 5000; display: flex; gap: 20px; align-items: center;
            background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);
            border-bottom-left-radius: 30px; border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .lang-btn {
            padding: 8px 16px; border-radius: 20px; border: 2px solid #ddd; cursor: pointer;
            font-weight: bold; transition: 0.3s; text-transform: uppercase; background: white; color: #333;
        }
        .lang-btn.active { background: var(--primary); color: white; border-color: var(--primary); }

        /* SIDEBAR CONTROLS */
        .controls {
            position: fixed; top: 100px; left: 20px; z-index: 4000;
            width: 350px; background: white; border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3); overflow: hidden;
        }
        .controls h3 {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white; margin: 0; padding: 20px; font-size: 1.2rem;
        }
        .controls-content { padding: 20px; display: flex; flex-direction: column; gap: 15px; }
        
        input, select {
            padding: 12px; border: 2px solid #eee; border-radius: 12px;
            font-size: 14px; outline: none; transition: 0.3s; width: 100%;
        }
        input:focus { border-color: var(--primary); }

        .btn-main {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white; border: none; padding: 15px; border-radius: 12px;
            font-weight: bold; cursor: pointer; transition: 0.3s;
        }
        .btn-main:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102,126,234,0.4); }

        /* INFO BOX */
        .info-box {
            position: fixed; top: 100px; right: 20px; background: white;
            padding: 20px; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            z-index: 4000; max-width: 300px;
        }
        .info-box h2 { color: #2c3e50; font-size: 1.3rem; margin-bottom: 10px; }
        .info-box p { color: #7f8c8d; font-size: 0.95rem; line-height: 1.6; }

        /* STATISTICS */
        #stats {
            position: fixed; bottom: 20px; left: 20px;
            background: rgba(255,255,255,0.95); padding: 12px 20px;
            border-radius: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            z-index: 4000; font-weight: 600; color: #333;
        }

        /* MAPPA STILE VINTAGE */
        .leaflet-tile-pane {
            filter: sepia(20%) contrast(1.1) brightness(0.9) grayscale(30%);
        }
        .leaflet-container { background: #1a1a1a !important; }

        /* COUNTRY POLYGON STYLING */
        .country-polygon {
            cursor: pointer !important;
            transition: all 0.3s ease !important;
        }
        
        /* PULSING ANIMATION FOR COUNTRIES */
        @keyframes countryPulse {
            0%, 100% { filter: brightness(1); }
            50% { filter: brightness(1.15); }
        }
        
        .leaflet-interactive {
            animation: countryPulse 3s ease-in-out infinite;
        }
        
        /* COUNTRY LABEL HOVER */
        .country-label:hover {
            transform: scale(1.1) !important;
            box-shadow: 0 6px 20px rgba(0,0,0,0.5) !important;
        }

        /* CUSTOM MARKERS */
        .city-marker {
            animation: cityPulse 2s infinite;
        }

        @keyframes cityPulse {
            0%, 100% { 
                transform: scale(1); 
                filter: drop-shadow(0 0 8px rgba(102, 126, 234, 0.6)); 
            }
            50% { 
                transform: scale(1.15); 
                filter: drop-shadow(0 0 15px rgba(102, 126, 234, 0.9)); 
            }
        }

        /* SPLASH SCREEN */
        .splash {
            position: fixed; inset: 0; z-index: 9999; 
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex; align-items: center; justify-content: center; 
            color: white; text-align: center; transition: opacity 0.5s;
        }
        .splash.hidden { opacity: 0; pointer-events: none; }

        /* DRAWER CITTÀ */
        #city-detail-drawer {
            position: fixed; top: 0; right: -100%;
            width: 600px; max-width: 90vw; height: 100vh;
            background: white; z-index: 6000;
            transition: right 0.7s cubic-bezier(0.19, 1, 0.22, 1);
            box-shadow: -10px 0 40px rgba(0,0,0,0.3);
            overflow-y: auto;
        }

        /* =========================
   STILI SOFT PER I PAESI
   ========================= */

        /* Poligoni dei paesi - Stile minimalista */
        .country-polygon-soft {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Tooltip discreto */
        .country-tooltip-soft {
            background: rgba(255, 255, 255, 0.95) !important;
            border: none !important;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.15) !important;
            border-radius: 8px !important;
            padding: 8px 14px !important;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        }

        .country-tooltip-soft::before {
            border-top-color: rgba(255, 255, 255, 0.95) !important;
        }

        /* Popup informativo */
        .country-info-popup-soft .leaflet-popup-content-wrapper {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            padding: 20px;
        }

        .country-info-popup-soft .leaflet-popup-tip {
            background: white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        /* Label dei paesi - Effetto hover */
        .country-label-soft:hover {
            transform: scale(1.08) !important;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.18) !important;
            opacity: 1 !important;
        }

        /* Animazioni smooth */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .country-popup-soft {
            animation: fadeIn 0.3s ease-out;
        }

        /* Bottone back con effetto glassmorphism */
        #back-to-overview-btn {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Stati responsive per mobile */
        @media (max-width: 768px) {
            .country-label-soft {
                font-size: 11px !important;
                padding: 4px 10px !important;
            }
            
            #back-to-overview-btn {
                left: 20px !important;
                font-size: 12px !important;
                padding: 8px 16px !important;
            }
        }

        /* Effetto pulse per indicare interattività */
        @keyframes softPulse {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(231, 76, 60, 0.4);
            }
            50% {
                box-shadow: 0 0 0 10px rgba(231, 76, 60, 0);
            }
        }

        .country-polygon-soft:hover {
            animation: softPulse 2s infinite;
        }

        /* Cursore pointer sui paesi */
        .country-polygon-soft {
            cursor: pointer !important;
        }

        /* Stile per il messaggio "nessuna storia" */
        .leaflet-popup-content p {
            margin: 0;
            line-height: 1.5;
        }
        /* Marker personalizzati stile Refugee Republic */
        .city-marker-icon {
            background: white;
            border: 2px solid #667eea;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 0 15px rgba(102, 126, 234, 0.5);
            transition: all 0.3s;
        }

        .city-marker-icon:hover {
            transform: scale(1.2);
            background: #667eea;
        }
    </style>
</head>
<body>
<!-- HEADER -->
<header>
    <div class="socials" style="color: #333; font-size: 1.2rem; display: flex; gap: 15px;">
        <i class="fab fa-facebook"></i>
        <i class="fab fa-twitter"></i>
        <i class="fab fa-instagram"></i>
    </div>
    <div>
        <button id="it-btn" class="lang-btn active" onclick="setLanguage('it')">IT</button>
        <button id="en-btn" class="lang-btn" onclick="setLanguage('en')">EN</button>
    </div>
</header>

<!-- SIDEBAR CONTROLS -->
<div class="controls">
    <h3 id="controls-title">🗺️ Esplora Stati e Città</h3>
    <div class="controls-content">
        <input type="text" id="search" placeholder="Cerca città o luoghi...">
        <select id="filter">
            <option value="">Tutti i luoghi</option>
            <option value="città">🏛️ Città</option>
            <option value="campo">⛺ Campi</option>
            <option value="natura">🌊 Luoghi naturali</option>
        </select>
        <button class="btn-main" onclick="filterPlaces()">🔄 Aggiorna</button>
    </div>
</div>

<!-- INFO BOX -->
<div class="info-box">
    <h2>Come Funziona</h2>
    <p>
        <strong style="color: #e74c3c;">1. Clicca sugli stati colorati</strong><br>
        <span style="font-size: 0.85rem; color: #95a5a6;">
            🔴 Bosnia • 🟠 Bulgaria • 🔵 Grecia
        </span><br><br>
        <strong>2.</strong> Esplora le <strong>città</strong> visitate<br>
        <strong>3.</strong> Apri i <strong>dettagli</strong> completi
    </p>
</div>

<!-- STATISTICS -->
<div id="stats">📍 Caricamento...</div>

<!-- MAPPA -->
<div id="map"></div>

<!-- AUDIO AMBIENTALE -->
<audio id="ambient-audio" loop></audio>

<script src="{{ asset('js/layers.js') }}"></script>
<script src="{{ asset('js/cities.js') }}"></script>
<script src="{{ asset('js/countries.js') }}"></script>

<!-- SCRIPTS - ORDINE IMPORTANTE -->
<script>
// =========================
// INIZIALIZZAZIONE MAPPA
// =========================

window.addEventListener('load', () => {
    console.log('🚀 Inizializzo Transit Traces...');

    // Variabili globali
    window.allPlaces = [];
    window.currentLang = 'it';

    const mapEl = document.getElementById('map');
    if (!mapEl) {
        console.error('❌ Elemento #map non trovato!');
        return;
    }

    // Crea mappa
    const map = L.map('map', {
        center: [43, 19],
        zoom: 6,
        zoomControl: true,
        minZoom: 5,
        maxZoom: 18,
        tap: false
    });
    window.map = map;

    // Tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 18
    }).addTo(map);

    // Zoom control
    L.control.zoom({ position: 'bottomright' }).addTo(map);

    // Layer group per i marker delle città
    window.placesLayer = L.layerGroup().addTo(map);

    console.log('✅ Mappa inizializzata');

    // Click sulla mappa per ottenere coordinate
    map.on('click', e => {
        console.log(`Coordinate: lat=${e.latlng.lat.toFixed(4)}, lng=${e.latlng.lng.toFixed(4)}`);
        navigator.clipboard.writeText(`[${e.latlng.lat.toFixed(4)}, ${e.latlng.lng.toFixed(4)}]`);
        console.log("✅ Coordinate copiate!");
    });

    // Audio ambientale
    const audio = document.getElementById('ambient-audio');
    if (audio) {
        map.whenReady(() => {
            audio.volume = 0.3;
            audio.muted = true;
            audio.addEventListener('canplaythrough', () => { audio.play().catch(() => {}); }, { once: true });
        });

        document.addEventListener('click', () => { if (audio.muted) audio.muted = false; }, { once: true });
    }

    // Auto-init senza splash
    window.mapEntered = true;
    setTimeout(() => {
        if (window.initCountries) window.initCountries();
    }, 1000);

    window.dispatchEvent(new Event('mapReady'));
});

// =========================
// INTEGRAZIONE CITTÀ SU PLACES
// =========================

window.addEventListener('mapReady', () => {
    console.log('🏙️ Integro città in allPlaces e creo marker...');
    
    // 1️⃣ Popola allPlaces
    if (window.cities) {
        cities.forEach(city => {
            const exists = window.allPlaces.some(p => p.id === city.id);
            if (!exists) window.allPlaces.push(city);
        });
    }

    // 2️⃣ Aggiungi marker sulla mappa
    window.allPlaces.forEach(city => {
        const marker = L.marker([city.lat, city.lng], { title: city.name })
            .bindPopup(window.createCityPopupWithLink(city))
            .addTo(window.placesLayer);
        
        marker.on('click', () => window.goToCityPage(city.country, city.id));
    });

    console.log('✅ Marker delle città creati:', window.allPlaces.length);
});

function setLanguage(lang) {
    window.currentLang = lang;

    const itBtn = document.getElementById('it-btn');
    const enBtn = document.getElementById('en-btn');

    if (lang === 'it') {
        itBtn.classList.add('active');
        enBtn.classList.remove('active');
        document.getElementById('controls-title').textContent = '🗺️ Esplora Stati e Città';
        document.getElementById('search').placeholder = 'Cerca città o luoghi...';
    } else {
        enBtn.classList.add('active');
        itBtn.classList.remove('active');
        document.getElementById('controls-title').textContent = '🗺️ Explore States and Cities';
        document.getElementById('search').placeholder = 'Search cities or places...';
    }

    if (window.filterPlaces) {
        window.filterPlaces();
    }
}

// =========================
// FILTER PLACES
// =========================

function filterPlaces() {
    if (!window.placesLayer) {
        console.error('❌ placesLayer non definito');
        return;
    }

    window.placesLayer.clearLayers();

    const search = document.getElementById('search').value.toLowerCase();
    const filter = document.getElementById('filter').value;

    const filtered = window.allPlaces.filter(place => {
        const matchesSearch = !search ||
            place.name.toLowerCase().includes(search) ||
            (place.description && place.description.toLowerCase().includes(search));

        const matchesFilter = !filter || place.type === filter;

        return matchesSearch && matchesFilter;
    });

    filtered.forEach(place => {
        if (window.addIllustrationMarker) {
            window.addIllustrationMarker(place.lat, place.lng, place);
        }
    });

    // Aggiorna statistiche
    const statsEl = document.getElementById('stats');
    if (statsEl) {
        const text = window.currentLang === 'it' 
            ? `📍 ${filtered.length}/${window.allPlaces.length} luoghi mostrati`
            : `📍 ${filtered.length}/${window.allPlaces.length} places shown`;
        statsEl.textContent = text;
    }

    console.log(`✅ Filtrati ${filtered.length} luoghi`);
}

// Event listeners
document.getElementById('search').addEventListener('keyup', filterPlaces);
document.getElementById('filter').addEventListener('change', filterPlaces);

// RENDI GLOBALE
window.filterPlaces = filterPlaces;
window.setLanguage = setLanguage;

// INIZIALIZZAZIONE FINALE

window.addEventListener('mapReady', () => {
    console.log('🎉 Sistema gerarchico pronto!');
    
    // Aspetta che cities.js abbia popolato allPlaces
    setTimeout(() => {
        filterPlaces();
        
        // Statistiche iniziali
        const statsEl = document.getElementById('stats');
        if (statsEl) {
            const text = window.currentLang === 'it'
                ? `📍 ${window.allPlaces.length} luoghi disponibili | 3 stati`
                : `📍 ${window.allPlaces.length} places available | 3 countries`;
            statsEl.textContent = text;
        }
    }, 1500);
});

console.log('✅ mappa.blade.php caricato completamente');
</script>

</body>
</html>