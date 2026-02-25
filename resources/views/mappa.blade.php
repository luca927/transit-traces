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

<!-- MAPPA -->
<div id="map"></div>

<!-- AUDIO AMBIENTALE -->
<audio id="ambient-audio" src="{{ ('audio/ambient.mp3') }}" loop></audio>

<script src="{{ asset('js/layers.js') }}"></script>
<script src="{{ asset('js/cities.js') }}"></script>
<script src="{{ asset('js/countries.js') }}"></script>

<!-- SCRIPTS - ORDINE IMPORTANTE -->
<script>

        // Mappa le coordinate geografiche reali → pixel dell'SVG
        // Calibra questi valori guardando l'immagine!
    function geoToPixel(lat, lng) {
    const latMin = 51.2,  latMax = 34.5;
    const lngMin = 10.5,  lngMax = 32.8;

    const svgW = 1754, svgH = 1240;

    const x = ((lng - lngMin) / (lngMax - lngMin)) * svgW;
    const y = ((lat - latMax) / (latMin - latMax)) * svgH;

    return [y, x];
}

    window.geoToPixel = geoToPixel;
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

        // DOPO
        const svgWidth = 1754;
        const svgHeight = 1240;

        const map = L.map('map', {
            crs: L.CRS.Simple,       // coordinate piatte, niente sfericità
            zoomControl: false,
            minZoom: -2,
            maxZoom: 4,
            tap: false
        });
        window.map = map;

        // Bounds dell'SVG in coordinate "pixel"
        const bounds = [[0, 0], [svgHeight, svgWidth]];

        // Carica l'SVG come layer immagine di sfondo
        L.imageOverlay("{{ asset('images/MAP.svg') }}", bounds).addTo(map);

        // Fit della mappa ai bounds dell'immagine
        map.fitBounds(bounds);

        // Zoom control
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        // Layer group per i marker delle città
        window.placesLayer = L.layerGroup().addTo(map);

        console.log('✅ Mappa inizializzata');

         // Audio ambientale
        const audio = document.getElementById('ambient-audio');
            document.addEventListener('click', () => {
                audio.volume = 0.3;
                audio.play().catch(e => console.warn('Audio bloccato:', e));
            }, { once: true });

        // Auto-init senza splash
        window.mapEntered = true;

       map.on('click', e => {
            const px = `[${e.latlng.lat.toFixed(1)}, ${e.latlng.lng.toFixed(1)}]`;
            console.log(`📍 Pixel SVG: y=${e.latlng.lat.toFixed(1)}, x=${e.latlng.lng.toFixed(1)}`);
            navigator.clipboard.writeText(px);
            console.log("✅ Coordinate pixel copiate!");
        });

        window.dispatchEvent(new Event('mapReady')); // ← fuori dal click

    }); // ← chiude il load

    window.addEventListener('mapReady', () => {
        if (window.mergeCitiesIntoPlaces) {
            window.mergeCitiesIntoPlaces();
        }

        setTimeout(() => {
            window.allPlaces.forEach(city => {
                window.addIllustrationMarker(city.lat, city.lng, city);
            });
            console.log('✅ Marker creati:', window.allPlaces.length);
        }, 300);
    });

    function setLanguage(lang) {
        window.currentLang = lang;

        const itBtn = document.getElementById('it-btn');
        const enBtn = document.getElementById('en-btn');

        if (lang === 'it') {
            itBtn.classList.add('active');
            enBtn.classList.remove('active');
        } else {
            enBtn.classList.add('active');
            itBtn.classList.remove('active');
        }

    }

    

    // RENDI GLOBALE
    window.setLanguage = setLanguage;

    // INIZIALIZZAZIONE FINALE

    window.addEventListener('mapReady', () => {
    console.log('🎉 Sistema gerarchico pronto!');
});
            

    console.log('✅ mappa.blade.php caricato completamente');
</script>

</body>
</html>