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
        <div class="lang-header">
            <a href="#" onclick="setLanguage('it'); return false;" id="it-btn" 
               style="background: #1e40af;">ITALIANO</a>
            <a href="#" onclick="setLanguage('en'); return false;" id="en-btn" 
               style="color: #0e0c0b; border: 1px solid #0e0c0b;">ENGLISH</a>
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

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([36.805, 43.105], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        var markersLayer = L.layerGroup().addTo(map);
        var allPlaces = [];
        let currentLang = 'it';

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

        function filterPlaces() {
            var search = document.getElementById('search').value.toLowerCase();
            var filter = document.getElementById('filter').value;
            markersLayer.clearLayers();
            
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
                var offset = index * 0.0003;
                var marker = L.marker([
                    parseFloat(place.latitude) + offset, 
                    parseFloat(place.longitude) + offset
                ]).addTo(markersLayer);
                
                marker.bindPopup(`
                    <div style="width: 300px; font-family: Arial; line-height: 1.4;">
                        <h3 style="color: #e67e22; margin: 0 0 15px 0; font-size: 18px; border-bottom: 2px solid #e67e22;">
                            🏕️ ${place.name}
                        </h3>
                        <video poster="https://via.placeholder.com/300x180/FF8C00/white?text=${place.name}" 
                               controls preload="metadata" style="width: 100%; border-radius: 8px; margin-bottom: 12px;">
                            ${place.id == 1 ? '<source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4" type="video/mp4">' : ''}
                            ${place.id == 2 ? '<source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4" type="video/mp4">' : ''}
                            ${place.id == 3 ? '<source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4" type="video/mp4">' : ''}
                            ${place.id == 4 ? '<source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerJoyrides.mp4" type="video/mp4">' : ''}
                            ${place.id == 5 ? '<source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/SampleVideo_1280x720_1mb.mp4" type="video/mp4">' : ''}
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
