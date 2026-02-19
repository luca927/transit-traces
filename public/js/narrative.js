var allPlaces = [];
var currentLang = 'it';

function loadPlaces() {
    fetch('/api/places')
    .then(response => {
        // Controlla se la risposta è OK e se è di tipo JSON
        const contentType = response.headers.get("content-type");
        if (!response.ok || !contentType || !contentType.includes("application/json")) {
            throw new TypeError("L'API non ha restituito JSON valido (Errore 500 o Rotta mancante)");
        }
        return response.json();
    })
    .then(places => {
        window.allPlaces = (places && places.length > 0) ? places : (window.cities || []);
        console.log('✅ Places caricati da API:', window.allPlaces.length);
        if (typeof filterPlaces === 'function') filterPlaces();
    })
    .catch(err => {
        console.warn('⚠️ Fallback attivato:', err.message);
        
        // Forza l'uso dei dati locali definiti in places.js
        if (window.cities) {
            window.allPlaces = [...window.cities];
            console.log('✅ Dati locali caricati con successo (4 città)');
            if (typeof filterPlaces === 'function') filterPlaces();
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

    // Filtra i luoghi
    const filtered = allPlaces.filter(place => {
        const matchesSearch =
            !search ||
            (place.name && place.name.toLowerCase().includes(search)) ||
            (place.description && place.description.toLowerCase().includes(search));

        const matchesFilter = !filter || place.type === filter;

        // Verifica che lat/lng siano numeri validi
        const validCoords = typeof place.lat === 'number' && typeof place.lng === 'number';

        return matchesSearch && matchesFilter && validCoords;
    });

    // Aggiungi marker
    const markers = [];
    filtered.forEach(place => {
        if (typeof window.addIllustrationMarker !== 'undefined') {
            const marker = window.addIllustrationMarker(place.lat, place.lng, place);
            if (marker) markers.push(marker);
        }
    });

    // Aggiorna la vista della mappa solo se ci sono marker validi
    if (markers.length > 0 && typeof window.map !== 'undefined') {
        const group = L.featureGroup(markers);
        const bounds = group.getBounds();
        if (bounds.isValid()) {
            window.map.fitBounds(bounds.pad(0.1));
        } else {
            console.warn('⚠️ Bounds non validi, mappa centrata sul default');
            window.map.setView([43.8564, 18.4131], 7);
        }
    }

    // Aggiorna contatore
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