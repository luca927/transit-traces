// DEFINISCI IL PERCORSO DEL VIAGGIO

var journeyRoute = [
    {
        lat: 41.3275, 
        lng: 19.8187, 
        name: "Partenza - Tirana",
        date: "15 Marzo 2024",
        video: "/assets/videos/tirana.mp4",
        audio: "/assets/audio/tirana.mp3",
        story: "Il viaggio inizia dalla capitale albanese, Tirana. Migliaia di persone si preparano ad attraversare i Balcani verso l'Europa occidentale.",
        type: "spot"
    },
    {
        lat: 42.4304, 
        lng: 19.2594, 
        name: "Podgorica - Montenegro",
        date: "18 Marzo 2024",
        video: "/assets/videos/montenegro.mp4",
        story: "Attraversando il Montenegro, il viaggio diventa più difficile. Le montagne e i controlli di frontiera rappresentano le prime vere sfide.",
        type: "spot"
    },
    {
        lat: 43.8564, 
        lng: 18.4131, 
        name: "Sarajevo - Bosnia",
        date: "22 Marzo 2024",
        video: "/assets/videos/sarajevo.mp4",
        audio: "/assets/audio/sarajevo.mp3",
        story: "Sarajevo, una città che conosce bene il dolore della guerra e della migrazione. Qui molti trovano rifugio temporaneo.",
        type: "spot"
    },
    {
        lat: 44.8154, 
        lng: 15.8708, 
        name: "Campo di Bihać",
        date: "25 Marzo 2024",
        video: "/assets/videos/bihac.mp4",
        story: "Il campo profughi di Bihać vicino al confine croato. Migliaia di migranti aspettano qui per settimane, a volte mesi, prima di tentare l'attraversamento.",
        type: "tent"
    },
    {
        lat: 45.8150, 
        lng: 15.9819, 
        name: "Confine Croazia",
        date: "1 Aprile 2024",
        video: "/assets/videos/croazia.mp4",
        story: "Il confine con la Croazia è uno dei più pericolosi. Molti raccontano di respingimenti violenti e abusi da parte delle autorità.",
        type: "spot"
    }
];

// VARIABILI GLOBALI ANIMAZIONE

let animationInterval = null;
let isAnimating = false;

// ANIMAZIONE DEL PERCORSO (con controllo pausa)


function animateJourney() {
    if (typeof window.map === 'undefined') {
        alert('Mappa non ancora caricata!');
        return;
    }

    // Se già in animazione, fermala
    if (isAnimating) {
        stopAnimation();
        return;
    }

    isAnimating = true;
    updatePlayButton(true); // Aggiorna il bottone

    let currentStep = 0;
    
    const movingIcon = L.divIcon({
        html: `
            <div style="width: 20px; height: 20px; background: #ff4444; 
                        border: 3px solid white; border-radius: 50%; 
                        box-shadow: 0 0 10px rgba(255,68,68,0.5);
                        animation: pulse 1.5s infinite;">
            </div>
            <style>
                @keyframes pulse {
                    0%, 100% { transform: scale(1); }
                    50% { transform: scale(1.3); }
                }
            </style>
        `,
        className: 'animated-marker',
        iconSize: [20, 20],
        iconAnchor: [10, 10]
    });
    
    // Salva il marker per poterlo rimuovere dopo
    window.movingMarker = L.marker(
        [journeyRoute[0].lat, journeyRoute[0].lng], 
        { icon: movingIcon }
    ).addTo(window.map);
    
    function moveToNext() {
        if (!isAnimating) return; // Controlla se è stato fermato
        
        if (currentStep >= journeyRoute.length) {
            currentStep = 0;
        }
        
        const point = journeyRoute[currentStep];
        
        window.movingMarker.setLatLng([point.lat, point.lng]);
        window.map.setView([point.lat, point.lng], 10, {
            animate: true,
            duration: 2
        });
        
        setTimeout(() => {
            if (!isAnimating) return; // Controlla di nuovo
            
            window.movingMarker.bindPopup(createJourneyPopup(point)).openPopup();
            updateTimelineActive(currentStep);
        }, 2000);
        
        currentStep++;
        animationInterval = setTimeout(moveToNext, 6000);
    }
    
    moveToNext();
}

// =========================
// FERMA ANIMAZIONE
// =========================

function stopAnimation() {
    isAnimating = false;
    
    // Ferma il timeout
    if (animationInterval) {
        clearTimeout(animationInterval);
        animationInterval = null;
    }
    
    // Rimuovi il marker mobile
    if (window.movingMarker && window.map) {
        window.map.removeLayer(window.movingMarker);
        window.movingMarker = null;
    }
    
    updatePlayButton(false);
    console.log('⏸️ Animazione fermata');
}

// =========================
// AGGIORNA BOTTONE PLAY/PAUSA
// =========================

function updatePlayButton(playing) {
    const button = document.getElementById('play-journey-btn');
    if (button) {
        if (playing) {
            button.innerHTML = '⏸️ Pausa Viaggio';
            button.style.background = 'linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%)';
        } else {
            button.innerHTML = '▶️ Play Viaggio';
            button.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
        }
    }
}

// ... (resto del codice)

// =========================
// RENDI GLOBALI
// =========================

window.drawJourneyPath = drawJourneyPath;
window.animateJourney = animateJourney;
window.stopAnimation = stopAnimation;
window.populateTimeline = populateTimeline;
window.playFullVideo = playFullVideo;
window.closeFullVideo = closeFullVideo;
window.addLayerControls = addLayerControls;

// ... (resto del codice)

// =========================
// FUNZIONI (definite PRIMA di essere esportate)
// =========================

function createJourneyPopup(point) {
    let content = `
        <div style="min-width: 300px; font-family: Arial;">
            <h3 style="margin: 0 0 5px 0; color: #667eea;">
                ${point.name}
            </h3>
            <p style="margin: 5px 0; color: #999; font-size: 0.9rem;">
                📅 ${point.date}
            </p>
    `;
    
    if (point.video) {
        content += `
            <video style="width: 100%; margin: 10px 0; border-radius: 8px;" 
                   controls loop muted autoplay>
                <source src="${point.video}" type="video/mp4">
            </video>
        `;
    }
    
    if (point.audio) {
        content += `
            <audio controls style="width: 100%; margin: 10px 0;">
                <source src="${point.audio}" type="audio/mp3">
            </audio>
        `;
    }
    
    if (point.story) {
        content += `
            <p style="margin: 10px 0; font-style: italic; color: #555; line-height: 1.6;">
                ${point.story}
            </p>
        `;
    }
    
    if (point.video) {
        content += `
            <button onclick="playFullVideo('${point.video}')" 
                    style="background: #667eea; color: white; border: none; 
                           padding: 8px 16px; border-radius: 6px; cursor: pointer;
                           width: 100%; margin-top: 5px;">
                🎬 Guarda video completo
            </button>
        `;
    }
    
    content += `</div>`;
    return content;
}

function drawJourneyPath() {
    if (typeof window.map === 'undefined' || typeof L === 'undefined') {
        console.log('Mappa non ancora pronta, riprovo...');
        setTimeout(drawJourneyPath, 500);
        return;
    }

    const coords = journeyRoute.map(point => [point.lat, point.lng]);
    
    const polyline = L.polyline(coords, {
        color: '#667eea',
        weight: 4,
        opacity: 0.8,
        smoothFactor: 1,
        dashArray: '10, 10'
    }).addTo(window.map);
    
    if (typeof L.polylineDecorator !== 'undefined') {
        const decorator = L.polylineDecorator(polyline, {
            patterns: [
                {
                    offset: 25,
                    repeat: 100,
                    symbol: L.Symbol.arrowHead({
                        pixelSize: 12,
                        pathOptions: {
                            fillOpacity: 1,
                            weight: 0,
                            color: '#667eea'
                        }
                    })
                }
            ]
        }).addTo(window.map);
    }
    
    journeyRoute.forEach((point, index) => {
        const marker = L.marker([point.lat, point.lng], {
            icon: window.getIconByType ? window.getIconByType(point.type) : undefined
        }).addTo(window.map);
        
        marker.bindPopup(createJourneyPopup(point));
        
        const numberIcon = L.divIcon({
            html: `<div style="background: #667eea; color: white; width: 24px; height: 24px; 
                          border-radius: 50%; display: flex; align-items: center; 
                          justify-content: center; font-weight: bold; border: 2px solid white;
                          box-shadow: 0 2px 5px rgba(0,0,0,0.3);">
                        ${index + 1}
                   </div>`,
            className: '',
            iconSize: [24, 24],
            iconAnchor: [12, 12]
        });
        
        L.marker([point.lat, point.lng], { icon: numberIcon }).addTo(window.map);
    });
    
    console.log('✅ Percorso disegnato sulla mappa');
    return polyline;
}

function updateTimelineActive(index) {
    document.querySelectorAll('.timeline-item').forEach(el => 
        el.classList.remove('active')
    );
    
    const activeItem = document.getElementById(`timeline-${index}`);
    if (activeItem) {
        activeItem.classList.add('active');
        activeItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

function populateTimeline() {
    const container = document.getElementById('timeline-content');
    
    if (!container) {
        console.log('Timeline container non trovato');
        return;
    }
    
    container.innerHTML = '';
    
    journeyRoute.forEach((point, index) => {
        const item = document.createElement('div');
        item.className = 'timeline-item';
        item.id = `timeline-${index}`;
        item.innerHTML = `
            <h4>${point.name}</h4>
            <p>${point.date}</p>
        `;
        
        item.onclick = () => {
            document.querySelectorAll('.timeline-item').forEach(el => 
                el.classList.remove('active')
            );
            item.classList.add('active');
            
            if (typeof window.map !== 'undefined') {
                window.map.setView([point.lat, point.lng], 12);
            }
            
            const marker = L.marker([point.lat, point.lng])
                .addTo(window.map)
                .bindPopup(createJourneyPopup(point))
                .openPopup();
        };
        
        container.appendChild(item);
    });
}

function playFullVideo(videoUrl) {
    const modal = document.getElementById('video-modal');
    const video = document.getElementById('full-video');
    
    if (modal && video) {
        video.src = videoUrl;
        modal.classList.add('active');
        video.play();
    }
}

function closeFullVideo() {
    const modal = document.getElementById('video-modal');
    const video = document.getElementById('full-video');
    
    if (modal && video) {
        video.pause();
        modal.classList.remove('active');
        video.src = '';
    }
}

function addLayerControls() {
    if (typeof window.map === 'undefined' || typeof L === 'undefined') {
        setTimeout(addLayerControls, 500);
        return;
    }

    const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    });
    
    const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: '© Esri'
    });
    
    const topoLayer = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenTopoMap'
    });

    const baseLayers = {
        "🗺️ Mappa Standard": osmLayer,
        "🛰️ Satellite": satelliteLayer,
        "🌍 Terreno": topoLayer
    };
    
    const overlays = {};
    
    if (typeof window.placesLayer !== 'undefined') {
        overlays["📍 Luoghi"] = window.placesLayer;
    }
    if (typeof window.citiesLayer !== 'undefined') {
        overlays["🏙️ Città"] = window.citiesLayer;
    }
    
    L.control.layers(baseLayers, overlays).addTo(window.map);
}

// =========================
// RENDI GLOBALI
// =========================

window.drawJourneyPath = drawJourneyPath;
window.animateJourney = animateJourney;
window.populateTimeline = populateTimeline;
window.playFullVideo = playFullVideo;
window.closeFullVideo = closeFullVideo;
window.addLayerControls = addLayerControls;

// Chiudi video con ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeFullVideo();
    }
});

// =========================
// INIT quando mappa pronta
// =========================

window.addEventListener('mapReady', () => {
    console.log('🎉 Routes.js inizializzato');
    
    setTimeout(() => {
        drawJourneyPath();
        populateTimeline();
        addLayerControls();
    }, 500);
});

console.log('✅ Routes.js caricato - funzioni esportate');

// =========================
// RESET ANIMAZIONE
// =========================

function resetAnimation() {
    stopAnimation();
    
    // Torna alla vista iniziale
    if (window.map) {
        window.map.setView([43.8564, 18.4131], 7);
    }
    
    // Resetta timeline
    document.querySelectorAll('.timeline-item').forEach(el => 
        el.classList.remove('active')
    );
    
    console.log('🔄 Animazione resettata');
}

// Esporta
window.resetAnimation = resetAnimation;

// Variabile velocità (default 6000ms)
let animationSpeed = 6000;

function updateSpeed(value) {
    const speeds = {
        '1': { time: 10000, label: 'Lenta' },
        '2': { time: 6000, label: 'Normale' },
        '3': { time: 3000, label: 'Veloce' }
    };
    
    animationSpeed = speeds[value].time;
    document.getElementById('speed-value').textContent = speeds[value].label;
    
    console.log(`⚡ Velocità cambiata: ${speeds[value].label} (${animationSpeed}ms)`);
}

// Esporta
window.updateSpeed = updateSpeed;

// Usa animationSpeed invece di 6000 hardcoded
function moveToNext() {
    // ... codice esistente ...
    
    currentStep++;
    animationInterval = setTimeout(moveToNext, animationSpeed); // <-- USA QUESTA
}