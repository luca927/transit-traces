// =========================
// COUNTRIES.JS - Versione SVG
// =========================

(() => {
'use strict';

// =========================
// DATI PAESI
// =========================

const countries = {
    bosnia: {
        name: 'Bosnia ed Erzegovina',
        name_en: 'Bosnia and Herzegovina',
        color: '#e74c3c',
        description: 'Un paese segnato dalla guerra, ora crocevia di storie di transito',
        cities: ['sarajevo', 'bihac'],
    },
    bulgaria: {
        name: 'Bulgaria',
        name_en: 'Bulgaria',
        color: '#f39c12',
        description: 'Porta d\'ingresso dall\'Est, tappa cruciale del viaggio',
        cities: ['harmanli'],
    },
    greece: {
        name: 'Grecia',
        name_en: 'Greece',
        color: '#3498db',
        description: 'Primo approdo in Europa',
        cities: ['lesvos'],
    }
};

// =========================
// STATO
// =========================

const state = {
    activeCountry: null,
    cityMarkers: {},
};

// =========================
// CITTÀ
// =========================

function showCities(countryKey) {
    hideCities();

    const countryCities = getCitiesByCountry(countryKey);
    if (!countryCities?.length) return;

    state.cityMarkers[countryKey] = [];

    countryCities.forEach(city => {
        const coords = window.geoToPixel(city.lat, city.lng);

        const marker = L.marker(coords, { title: city.name }).addTo(window.map);

        marker.bindTooltip(
            `<div class="city-label">${city.icon} ${city.name}</div>`,
            { permanent: true, direction: 'top', className: 'city-label-soft' }
        );

        marker.on('click', () => window.goToCityPage(city.country, city.id));

        state.cityMarkers[countryKey].push(marker);
    });
}

function hideCities() {
    Object.values(state.cityMarkers).forEach(markers => {
        markers.forEach(m => m.remove());
    });
    state.cityMarkers = {};
}

// =========================
// NAVIGAZIONE
// =========================

window.Countries = {
    enter(countryKey) {
        state.activeCountry = countryKey;
        showBackButton();
        showCities(countryKey);
    },

    back() {
        hideCities();
        state.activeCountry = null;
        hideBackButton();
    }
};

// =========================
// BACK BUTTON
// =========================

function showBackButton() {
    if (document.getElementById('back-btn')) return;

    const b = document.createElement('button');
    b.id = 'back-btn';
    b.textContent = '← Torna alla mappa';
    b.style.cssText = `
        position:fixed; top:20px; left:20px; z-index:5000;
        padding:10px 18px; border-radius:22px; border:none;
        background:white; font-weight:600;
        box-shadow:0 4px 14px rgba(0,0,0,.2);
        cursor:pointer;
    `;
    b.onclick = backToOverview;
    document.body.appendChild(b);
}

function hideBackButton() {
    const b = document.getElementById('back-btn');
    if (b) b.remove();
}

function backToOverview() {
    Countries.back();
    window.map.fitBounds([[0, 0], [1240, 1754]]);
}

// =========================
// INIT
// =========================

async function initCountries() {
    console.log('✅ Countries SVG — nessun OSM da caricare');
}

// =========================
// EXPORT GLOBALI
// =========================

window.countries = countries;
window.initCountries = initCountries;

})();