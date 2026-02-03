var allPlaces = [];
var currentLang = 'it';

function loadPlaces() {
    fetch('/api/places')
        .then(r => r.json())
        .then(places => {
            allPlaces = places;
            filterPlaces();
        })
        .catch(err => {
            console.error('Errore:', err);
            const stats = document.getElementById('stats');
            if (stats) {
                stats.textContent = '❌ Errore caricamento';
            }
        });
}

function filterPlaces() {
    // Controlla che placesLayer esista
    if (typeof window.placesLayer === 'undefined') {
        console.error('❌ placesLayer non ancora definito!');
        return;
    }

    window.placesLayer.clearLayers();

    const searchEl = document.getElementById('search');
    const filterEl = document.getElementById('filter');
    
    const search = searchEl ? searchEl.value.toLowerCase() : '';
    const filter = filterEl ? filterEl.value : '';

    const filtered = allPlaces.filter(place => {
        const matchesSearch =
            !search ||
            place.name.toLowerCase().includes(search) ||
            (place.description && place.description.toLowerCase().includes(search));

        const matchesFilter = !filter || place.type === filter;

        return matchesSearch && matchesFilter;
    });

    filtered.forEach(place => {
        if (typeof window.addIllustrationMarker !== 'undefined') {
            window.addIllustrationMarker(place.lat, place.lng, place);
        }
    });

    if (filtered.length > 0 && typeof window.map !== 'undefined') {
        const group = L.featureGroup(
            filtered.map(p => L.marker([p.lat, p.lng]))
        );
        window.map.fitBounds(group.getBounds().pad(0.1));
    }

    const statsEl = document.getElementById('stats');
    if (statsEl) {
        const statsText = currentLang === 'it' 
            ? `📍 ${filtered.length}/${allPlaces.length} luoghi mostrati`
            : `📍 ${filtered.length}/${allPlaces.length} places shown`;
        statsEl.textContent = statsText;
    }
}

function setLanguage(lang) {
    currentLang = lang;

    const itBtn = document.getElementById('it-btn');
    const enBtn = document.getElementById('en-btn');
    const title = document.getElementById('controls-title');
    const search = document.getElementById('search');
    const button = document.querySelector('.controls button');

    if (lang === 'it') {
        if (itBtn) {
            itBtn.style.background = '#1e40af';
            itBtn.style.color = 'white';
        }
        if (enBtn) {
            enBtn.style.background = 'transparent';
            enBtn.style.color = '#0e0c0b';
            enBtn.style.border = '1px solid #0e0c0b';
        }
        if (title) title.textContent = '🗺️ Mappa Balcani';
        if (search) search.placeholder = 'Cerca luoghi...';
        if (button) button.innerHTML = '🔄 Aggiorna';
    } else {
        if (enBtn) {
            enBtn.style.background = '#1e40af';
            enBtn.style.color = 'white';
        }
        if (itBtn) {
            itBtn.style.background = 'transparent';
            itBtn.style.color = '#0e0c0b';
            itBtn.style.border = '1px solid #0e0c0b';
        }
        if (title) title.textContent = '🗺️ Balkans Map';
        if (search) search.placeholder = 'Search places...';
        if (button) button.innerHTML = '🔄 Refresh';
    }
    
    filterPlaces();
}

// Rendi globali
window.loadPlaces = loadPlaces;
window.filterPlaces = filterPlaces;
window.setLanguage = setLanguage;

// ASPETTA L'EVENTO mapReady
window.addEventListener('mapReady', () => {
    console.log('🎉 Mappa pronta, inizializzo narrative.js');
    
    setLanguage('it');
    loadPlaces();
    
    const searchEl = document.getElementById('search');
    const filterEl = document.getElementById('filter');
    
    if (searchEl) searchEl.onkeyup = filterPlaces;
    if (filterEl) filterEl.onchange = filterPlaces;
});