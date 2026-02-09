// =========================
// COUNTRIES.JS - COMPLETO + CITIES
// =========================

(() => {
'use strict';

// =========================
// CONFIG DATI PAESI
// =========================

const countries = {
    bosnia: {
        name: 'Bosnia ed Erzegovina',
        name_en: 'Bosnia and Herzegovina',
        osmRelationId: '2528142',
        center: [43.9159, 17.6791],
        color: '#e74c3c',
        description: 'Un paese segnato dalla guerra, ora crocevia di storie di transito',
        cities: ['sarajevo', 'bihac'],
        approximateBounds: [[42.6, 15.7], [45.3, 19.6]]
    },
    bulgaria: {
        name: 'Bulgaria',
        osmRelationId: '186382',
        center: [42.7339, 25.4858],
        color: '#f39c12',
        description: 'Porta d\'ingresso dall\'Est, tappa cruciale del viaggio',
        cities: ['harmanli'],
        approximateBounds: [[41.3, 22.4], [44.2, 28.6]]
    },
    greece: {
        name: 'Grecia',
        osmRelationId: '192307',
        center: [39.0742, 21.8243],
        color: '#3498db',
        description: 'Primo approdo in Europa',
        cities: ['lesvos'],
        approximateBounds: [[34.9, 19.5], [41.7, 29.6]]
    }
};

// =========================
// STATO
// =========================

const state = {
    polygons: {},
    labels: {},
    cityMarkers: {}, // 🔹 marker delle città visibili
    activeCountry: null,
    loading: false,
    initialized: false,
    view: 'overview'
};

// =========================
// LOADING
// =========================

function showLoading() {
    if (document.getElementById('countries-loading')) return;

    const el = document.createElement('div');
    el.id = 'countries-loading';
    el.innerHTML = `
        <div style="font-size:42px">🌍</div>
        <div style="font-weight:600">Caricamento confini…</div>
    `;
    el.style.cssText = `
        position:fixed; inset:0; margin:auto;
        width:260px; height:140px;
        background:white; border-radius:18px;
        display:flex; flex-direction:column;
        align-items:center; justify-content:center;
        box-shadow:0 10px 40px rgba(0,0,0,.3);
        z-index:10000;
        font-family:system-ui;
    `;
    document.body.appendChild(el);
}

function hideLoading() {
    const el = document.getElementById('countries-loading');
    if (el) el.remove();
}

// =========================
// OSM BOUNDARY
// =========================

const osmCache = {};

async function loadBoundary(osmId, name, retry = 0) {
    // usa cache se disponibile
    if (osmCache[osmId]) return osmCache[osmId];

    try {
        const query = `[out:json][timeout:25];relation(${osmId});out geom;`;
        const res = await fetch(
            'https://overpass-api.de/api/interpreter',
            { method: 'POST', body: 'data=' + encodeURIComponent(query) }
        );

        if (res.status === 429 && retry < 3) {
            await new Promise(r => setTimeout(r, 3000));
            return loadBoundary(osmId, name, retry + 1);
        }

        if (!res.ok) throw new Error(res.status);

        const json = await res.json();
        const el = json.elements?.[0];
        if (!el) return null;

        const coords = extractPolygons(el);
        if (!coords.length) return null;

        const geojson = {
            type: 'Feature',
            geometry: {
                type: coords.length > 1 ? 'MultiPolygon' : 'Polygon',
                coordinates: coords.length > 1 ? coords : coords[0]
            },
            properties: { name }
        };

        osmCache[osmId] = geojson;
        return geojson;
    } catch (e) {
        console.warn(`OSM fallito per ${name}`);
        return null;
    }
}

function extractPolygons(el) {
    const polys = [];
    if (el.members) {
        el.members
            .filter(m => m.type === 'way' && m.geometry)
            .forEach(w => {
                const c = w.geometry.map(p => [p.lon, p.lat]);
                if (c.length > 2) polys.push([c]);
            });
    }
    return polys;
}

// =========================
// CREAZIONE POLIGONI
// =========================

function createPolygon(countryKey, country, geojson) {
    if (geojson) {
        const layer = L.geoJSON(geojson, { style: baseStyle(country.color) }).addTo(window.map);
        return { layer, bounds: layer.getBounds(), approx: false };
    }

    const [sw, ne] = country.approximateBounds;
    const rect = L.rectangle([sw, ne], baseStyle(country.color)).addTo(window.map);
    return { layer: rect, bounds: rect.getBounds(), approx: true };
}

function baseStyle(color) {
    return { color, fillColor: color, fillOpacity: 0.12, weight: 2.5, opacity: 0.7 };
}

// =========================
// EVENTI SU POLIGONI
// =========================

function bindEvents(countryKey, country, data) {
    const layer = data.layer;

    layer.on('mouseover', e => {
        e.target.setStyle({ fillOpacity: 0.3, weight: 4 });
        highlightLabel(countryKey, true);
    });

    layer.on('mouseout', e => {
        if (state.activeCountry !== countryKey) {
            e.target.setStyle(baseStyle(country.color));
            highlightLabel(countryKey, false);
        }
    });

    layer.on('click', () => Countries.enter(countryKey));
    layer.bindTooltip(country.name, { opacity: 0.95 });
}

// =========================
// LABEL PAESI
// =========================

function addCountryLabel(countryKey, country) {
    const marker = L.marker(country.center, { interactive: false, opacity: 0.85 }).addTo(window.map);
    marker.bindTooltip(
        `<div class="country-label">${country.name}</div>`,
        { permanent: true, direction: 'center', className: 'country-label-soft' }
    );
    state.labels[countryKey] = marker;
}

function highlightLabel(countryKey, on) {
    const m = state.labels[countryKey];
    if (!m) return;
    const el = m.getElement()?.querySelector('.country-label-soft');
    if (!el) return;
    el.style.transform = on ? 'scale(1.15)' : 'scale(1)';
}

// =========================
// CITTÀ
// =========================

function showCities(countryKey) {
    hideCities();

    const countryCities = getCitiesByCountry(countryKey);
    if (!countryCities?.length) return;

    state.cityMarkers[countryKey] = [];

    countryCities.forEach(city => {
        const marker = L.marker([city.lat, city.lng], { title: city.name }).addTo(map);

        marker.bindTooltip(
            `<div class="city-label">${city.icon} ${city.name}</div>`,
            { permanent: true, direction: 'top', className: 'city-label-soft' }
        );

        marker.on('click', () => goToCityPage(city.country, city.id));

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
// NAVIGAZIONE PAESI
// =========================

window.Countries = {
    enter(countryKey) {
        const data = state.polygons[countryKey];

        if (!data || !data.bounds || !data.bounds.isValid()) {
            console.warn('Bounds non validi per', countryKey, data);
            return;
        }

        state.activeCountry = countryKey;
        map.fitBounds(data.bounds, { padding: [40, 40] });
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
    map.setView([43, 25], 5); // vista overview iniziale
}

// =========================
// INIT
// =========================

async function initCountries() {
    if (!window.map || state.loading || state.initialized) {
        setTimeout(initCountries, 500);
        return;
    }

    state.loading = true;
    state.initialized = true;
    showLoading();

    for (const key of Object.keys(countries)) {
        const c = countries[key];
        const geo = await loadBoundary(c.osmRelationId, c.name);
        const data = createPolygon(key, c, geo);
        bindEvents(key, c, data);
        addCountryLabel(key, c);
        state.polygons[key] = data;
        await new Promise(r => setTimeout(r, 250));
    }

    hideLoading();
    state.loading = false;
    console.log('✅ Countries inizializzati');
}

// =========================
// EXPORT GLOBALI
// =========================

window.countries = countries;
window.initCountries = initCountries;

})();
