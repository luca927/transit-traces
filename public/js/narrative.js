let allPlaces = [];
let currentLang = 'it';

// =========================
// CARICA LUOGHI DAL SERVER
// =========================

function loadPlaces() {
    const filter = document.getElementById('filter').value;
    const search = document.getElementById('search').value;
    //Assicurati che questo URL corrisponda alla tua rotta Laravel
   fetch('/api/places')
        .then(res => res.json())
        .then(data => {
            placesLayer.clearLayers(); // Puliamo i vecchi marker
            data.forEach(place => {
                // USA I NOMI DEL TUO DATABASE (lat/lng o latitude/longitude)
                if (place.lat && place.lng) {
                    const marker = L.marker([place.lat, place.lng]).addTo(placesLayer);
                    
                    marker.on('click', () => {
                        openStory(place); 
                    });
                }
            });
        });
}

// =========================
// FILTRO + MARKER
// =========================

function filterPlaces() {
    placesLayer.clearLayers();

    const search = document.getElementById('search').value.toLowerCase();
    const filter = document.getElementById('filter').value;

    const filtered = allPlaces.filter(place => {
        const matchesSearch =
            !search ||
            place.name.toLowerCase().includes(search) ||
            (place.description && place.description.toLowerCase().includes(search));

        const matchesFilter =
            !filter ||
            place.type === filter;

        return matchesSearch && matchesFilter;
    });

    filtered.forEach(place => {
        addIllustrationMarker(place.lat, place.lng, place);
    });

    // Zoom automatico sui risultati
    if (filtered.length > 0) {
        const group = L.featureGroup(
            filtered.map(p => L.marker([p.lat, p.lng]))
        );
        map.fitBounds(group.getBounds().pad(0.1));
    }

    const statsText = currentLang === 'it' 
        ? `📍 ${filtered.length}/${allPlaces.length} luoghi mostrati`
        : `📍 ${filtered.length}/${allPlaces.length} places shown`;
    
    document.getElementById('stats').textContent = statsText;
}

// =========================
// RICERCA CON ENTER
// =========================

document.getElementById('search').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        filterPlaces();
    }
});

// =========================
// LINGUA
// =========================

function setLanguage(lang) {
    currentLang = lang;

    const itBtn = document.getElementById('it-btn');
    const enBtn = document.getElementById('en-btn');

    if (lang === 'it') {
        itBtn.style.background = '#1e40af';
        itBtn.style.color = 'white';
        enBtn.style.background = 'transparent';
        enBtn.style.color = '#0e0c0b';
        enBtn.style.border = '1px solid #0e0c0b';
        
        document.getElementById('controls-title').textContent = '🗺️ Mappa Balcani';
        document.getElementById('search').placeholder = 'Cerca luoghi... (premi Invio)';
        document.querySelector('.controls button').innerHTML = '🔄 Aggiorna';
    } else {
        enBtn.style.background = '#1e40af';
        enBtn.style.color = 'white';
        itBtn.style.background = 'transparent';
        itBtn.style.color = '#0e0c0b';
        itBtn.style.border = '1px solid #0e0c0b';
        
        document.getElementById('controls-title').textContent = '🗺️ Balkans Map';
        document.getElementById('search').placeholder = 'Search places... (press Enter)';
        document.querySelector('.controls button').innerHTML = '🔄 Refresh';
    }
    
    filterPlaces();
}

function openStory(placeData) {
    const drawer = document.getElementById('story-drawer');
    const content = document.getElementById('drawer-content');

    // Usiamo una foto di backup se placeData.image non esiste
    const imageUrl = placeData.image ? placeData.image : '/images/default-placeholder.jpg';

    content.innerHTML = `
        <span style="color: #ff7e00; letter-spacing: 3px; font-size: 0.8rem; font-weight: bold; text-transform: uppercase;">
            ${placeData.type || 'Luogo'}
        </span>
        <h2>${placeData.name || 'Senza Nome'}</h2>
        
        <div class="image-container">
            <img src="${imageUrl}" class="story-image" onerror="this.style.display='none'">
        </div>
        
        <p>${placeData.description || 'Nessuna descrizione disponibile.'}</p>
    `;

    drawer.classList.add('open');
}

function closeStory() {
    const drawer = document.getElementById('story-drawer');
    drawer.classList.remove('open');
}

// =========================
// INIT
// =========================

setLanguage('it');
loadPlaces();

document.getElementById('filter').onchange = filterPlaces;