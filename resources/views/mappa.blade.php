<!DOCTYPE html>
<html>
<head>
    <title>Transit Traces 🏕️ Domiz Camp</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/map.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        #map { height: 100vh; width: 100%; }
        .controls {
            position: fixed; top: 10px; left: 10px; 
            background: white; padding: 20px; border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3); z-index: 1000; 
            font-family: Arial; width: 320px; max-width: 320px;
            box-sizing: border-box;
        }

#map { 
    height: 100vh; 
    width: 100%; 
    background-color: #2977c4; /* colore di sfondo mentre carica */
}

/* Rimuovi il padding interno di Leaflet */
.leaflet-container {
    background: transparent;
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

.custom-marker {
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
}

/* Assicura che l'SVG occupi tutto lo spazio del marker */
.custom-marker svg {
    width: 100%;
    height: 100%;
}

/* Opzionale: aggiungi una transizione fluida quando appaiono */
.video-fade {
    opacity: 0;
    transition: opacity 0.5s ease-in;
}

.video-fade.loaded {
    opacity: 1;
}

/* Stile del Drawer Laterale */
.story-drawer {
    position: fixed;
    top: 0;
    right: -100%; /* Inizia fuori dallo schermo */
    width: 450px;
    max-width: 90vw;
    height: 100vh;
    background: #0e0c0b; /* Nero profondo */
    z-index: 3000;
    transition: right 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: -10px 0 30px rgba(0,0,0,0.5);
    color: #e2d9d0;
    overflow-y: auto;
}

.story-drawer.open {
    right: 0; /* Scivola dentro */
}

.drawer-header {
    padding: 20px;
    display: flex;
    justify-content: flex-end;
}

.close-drawer {
    background: none;
    border: none;
    color: #ff7e00;
    font-size: 1.5rem;
    cursor: pointer;
}

.drawer-body {
    padding: 0 40px 40px 40px;
}

.drawer-body h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2.5rem;
    color: white;
    margin-bottom: 20px;
}

.drawer-body p {
    line-height: 1.8;
    font-size: 1.1rem;
    color: #ccc;
}

.story-image {
    width: 100%;
    margin: 25px 0;
    border-radius: 5px;
    filter: sepia(0.2) contrast(1.1);
}

/* ===== TIMELINE BUTTON - BASSO SCHERMO ===== */
.timeline-control {
    position: absolute !important;
    bottom: 20px !important;
    left: 50% !important;
    transform: translateX(-50%) !important;
    width: 120px !important;
    height: 45px !important;
    z-index: 1800 !important;
    background: linear-gradient(135deg, #e67e22, #d35400);
    border-radius: 25px;
    box-shadow: 0 6px 25px rgba(230,126,34,0.4);
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex !important;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
    font-size: 14px;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
}

.timeline-control:hover {
    transform: translateX(-50%) translateY(-3px) scale(1.05);
    box-shadow: 0 8px 30px rgba(230,126,34,0.6);
}

/* Popup TIMELINE APERTO */
.timeline-popup {
    position: absolute !important;
    bottom: 80px !important;
    left: 50% !important;
    transform: translateX(-50%) !important;
    width: 400px !important;
    max-height: 350px !important;
    z-index: 1900 !important;
    background: white;
    border-radius: 15px;
    box-shadow: 0 15px 50px rgba(0,0,0,0.4);
    padding: 20px;
    opacity: 0;
    visibility: hidden;
    transform: translateX(-50%) translateY(20px);
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    overflow-y: auto;
    border: 3px solid #e67e22;
}

.timeline-popup.active {
    opacity: 1 !important;
    visibility: visible !important;
    transform: translateX(-50%) translateY(0px) !important;
}

/* ===== NASCONDERE TIMELINE ORIGINALE ===== */
.timeline {
    display: none !important; /* ← Timeline originale sparisce */
}

/* FIX SCROLL DOPPIO nel popup */
.timeline-popup {
    overflow: hidden !important; /* Container senza scroll */
}

#realTimelineContent {
    overflow-y: auto !important;
    overflow-x: hidden !important;
    height: 280px !important; /* Altezza fissa */
    padding-right: 10px; /* Spazio scrollbar */
}

/* Scrollbar personalizzata */
#realTimelineContent::-webkit-scrollbar {
    width: 6px;
}

#realTimelineContent::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

#realTimelineContent::-webkit-scrollbar-thumb {
    background: #e67e22;
    border-radius: 3px;
}

#realTimelineContent::-webkit-scrollbar-thumb:hover {
    background: #d35400;
}


/* Layer Control SOPRA tutto (ma sotto popup) */
.leaflet-control-layers { z-index: 1700 !important; }
.leaflet-control-zoom { z-index: 1600 !important; }


/* Video player modale */
.video-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.9);
    z-index: 9999;
    justify-content: center;
    align-items: center;
}

.video-modal.active {
    display: flex;
}

.video-container {
    position: relative;
    max-width: 90%;
    min-width: 300px;
    max-height: 90%;
}

.video-container video {
    width: 100%;
    height: auto;
    border-radius: 10px;
}

.close-video {
    position: absolute;
    top: -40px;
    right: 0;
    background: white;
    color: #333;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1.2rem;
}

.journey-btn {
    flex: 1 1 45%;
    background: #667eea;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 1rem;
}
.journey-btn.audio {
    background: #48bb78;
}

/* Story Modal */
.story-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.95);
    z-index: 10000;
    overflow-y: auto;
}

.story-modal.active {
    display: flex;
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.5s ease;
}

.story-container {
    max-width: 900px;
    width: 90%;
    background: white;
    border-radius: 20px;
    overflow: hidden;
    position: relative;
}

.close-story {
    position: absolute;
    top: 20px;
    right: 20px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    font-size: 1.5rem;
    cursor: pointer;
    z-index: 10;
    transition: all 0.3s ease;
}

.close-story:hover {
    background: #ff4444;
    transform: rotate(90deg);
}

.story-content {
    padding: 3rem;
}

.story-content h1 {
    font-size: 2.5rem;
    margin: 0 0 1rem 0;
    color: #333;
}

.story-description {
    font-size: 1.2rem;
    color: #666;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.story-content video,
.story-content img {
    width: 100%;
    border-radius: 15px;
    margin: 2rem 0;
}

.story-chapters {
    margin: 2rem 0;
}

.chapter {
    display: flex;
    gap: 1.5rem;
    padding: 1.5rem;
    margin: 1rem 0;
    border-left: 4px solid #667eea;
    background: #f8f9fa;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.chapter:hover {
    background: #e8eaf6;
    transform: translateX(10px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
}

.chapter-number {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: bold;
    flex-shrink: 0;
}

.chapter-info h3 {
    margin: 0 0 0.5rem 0;
    color: #333;
}

.chapter-info p {
    margin: 0;
    color: #666;
    line-height: 1.5;
}

.start-story-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 1.5rem 3rem;
    border-radius: 50px;
    font-size: 1.2rem;
    font-weight: bold;
    cursor: pointer;
    width: 100%;
    margin-top: 2rem;
    transition: all 0.3s ease;
}

.start-story-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
}

/* Narrative Popup */
.narrative-popup .leaflet-popup-content-wrapper {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 1rem;
}

.narrative-content {
    min-width: 300px;
}

.narrative-content h3 {
    margin: 0 0 1rem 0;
    font-size: 1.5rem;
}

.narrative-content p {
    margin: 0 0 1.5rem 0;
    line-height: 1.6;
}

.narrative-content button {
    background: white;
    color: #667eea;
    border: none;
    padding: 0.8rem 2rem;
    border-radius: 25px;
    font-weight: bold;
    cursor: pointer;
    width: 100%;
    transition: all 0.3s ease;
}

.narrative-content button:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.splash-screen {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    z-index: 99999;
    align-items: center;
    justify-content: center;
}

.splash-screen.active {
    display: flex;
}

.splash-content {
    text-align: center;
    color: white;
    max-width: 800px;
    padding: 2rem;
}

.splash-title {
    font-size: 4rem;
    margin: 0 0 1rem 0;
    font-weight: bold;
    animation: slideDown 1s ease;
}

.splash-subtitle {
    font-size: 1.5rem;
    margin: 0 0 2rem 0;
    opacity: 0.9;
    animation: slideDown 1s ease 0.2s backwards;
}

.splash-description {
    font-size: 1.2rem;
    margin: 2rem 0;
    line-height: 1.8;
    animation: fadeIn 1s ease 0.4s backwards;
}

.enter-btn {
    background: white;
    color: #667eea;
    border: none;
    padding: 1.5rem 4rem;
    border-radius: 50px;
    font-size: 1.3rem;
    font-weight: bold;
    cursor: pointer;
    margin: 2rem 0;
    transition: all 0.3s ease;
    animation: fadeIn 1s ease 0.6s backwards;
}

.enter-btn:hover {
    transform: translateY(-5px) scale(1.05);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
}

.splash-stories {
    margin-top: 3rem;
    animation: fadeIn 1s ease 0.8s backwards;
}

.splash-stories h3 {
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
}

.story-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-top: 1rem;
}

.story-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.story-card:hover {
    transform: translateY(-10px);
    background: rgba(255, 255, 255, 0.2);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.story-card img {
    width: 100%;
    border-radius: 10px;
    margin-bottom: 1rem;
}

.story-card h4 {
    margin: 0.5rem 0;
    font-size: 1.2rem;
}

.story-card p {
    margin: 0;
    opacity: 0.8;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

</style>

</head>
<body>

    <!-- Splash Screen -->
<div id="splash-screen" class="splash-screen active">
    <div class="splash-content">
        <h1 class="splash-title">Transit Traces</h1>
        <p class="splash-subtitle">La Rotta Balcanica</p>
        
        <div class="splash-description">
            <p>Un viaggio interattivo attraverso le storie di chi attraversa i Balcani 
               in cerca di una vita migliore.</p>
        </div>
        
        <button onclick="enterMap()" class="enter-btn">
            🗺️ Esplora la Mappa
        </button>
        
        <div class="splash-stories">
            <h3>Storie disponibili:</h3>
            <div class="story-cards">
                <div class="story-card" onclick="openStory(1)">
                    <img src="/assets/images/story1.jpg" alt="Storia 1">
                    <h4>Il confine invisibile</h4>
                    <p>La rotta balcanica</p>
                </div>
            </div>
        </div>
    </div>
</div>


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
    <h3 id="controls-title">🗺️ Mappa Balcani</h3>
    <input type="text" id="search" placeholder="Cerca luoghi...">
    <select id="filter">
        <option value="">Tutti i luoghi</option>
        <option value="spot">🔴 Punti di interesse</option>
        <option value="tent">⛺ Campi</option>
        <option value="stall">🏪 Strutture</option>
    </select>
    <button onclick="loadPlaces()">🔄 Aggiorna</button>
    <button onclick="toggleHeatmap()" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
    🔥 Heatmap Percorsi
    </button>
    
    <!-- BOTTONE PLAY/PAUSA CON ID -->
    <button id="play-journey-btn" onclick="animateJourney()" 
            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        ▶️ Play Viaggio
    </button>
    
    <div class="stats" id="stats">Caricamento...</div>
</div>
    <div id="map"></div>
    <!-- audio mappa -->
    <audio id="ambient-audio" src="/audio/ambient.mp3" loop></audio>

<div id="story-drawer" class="story-drawer">
    <div class="drawer-header">
        <button class="close-drawer" onclick="closeStory()"><i class="fas fa-times"></i></button>
    </div>
    <div id="drawer-content" class="drawer-body">
        </div>
</div>
<!-- Timeline laterale -->
<div class="timeline">
    <h3>🗓️ Timeline del Viaggio</h3>
    <div id="timeline-content"></div>
</div>

<!-- Video modale -->
<div class="video-modal" id="video-modal">
    <div class="video-container">
        <button class="close-video" onclick="closeFullVideo()">✕ Chiudi</button>
        <video id="full-video" controls autoplay>
            <source src="" type="video/mp4">
        </video>
    </div>
</div>
<div class="timeline-container"></div>


<script>
function enterMap() {
    const splash = document.getElementById('splash-screen');
    splash.classList.remove('active');
    
    // Avvia audio ambientale
    const audio = document.getElementById('ambient-audio');
    if (audio) {
        audio.muted = false;
        audio.play();
    }
}
</script>
</body>
</html>
