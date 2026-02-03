// =========================
// ICONS PERSONALIZZATE
// =========================

const tentIcon = L.divIcon({
    html: `
        <svg width="100%" height="100%" viewBox="0 0 36 28" xmlns="http://www.w3.org/2000/svg">
            <path d="M2 24L18 4L34 24H2Z" fill="#d9c7a3" stroke="#6e5b4b" stroke-width="2"/>
            <path d="M18 4V24" stroke="#6e5b4b" stroke-width="2"/>
        </svg>
    `,
    className: 'custom-marker',
    iconSize: [36, 36],
    iconAnchor: [18, 28],
    popupAnchor: [0, -28]
});

const stallIcon = L.divIcon({
    html: `
        <svg width="100%" height="100%" viewBox="0 0 40 32" xmlns="http://www.w3.org/2000/svg">
            <rect x="4" y="14" width="32" height="14" fill="#d9c7a3" stroke="#6e5b4b" stroke-width="2"/>
            <path d="M4 14L8 4H32L36 14H4Z" fill="#bfa98a" stroke="#6e5b4b" stroke-width="2"/>
        </svg>
    `,
    className: 'custom-marker',
    iconSize: [40, 40],
    iconAnchor: [20, 32],
    popupAnchor: [0, -32]
});

const spotIcon = L.divIcon({
    html: `
        <svg width="100%" height="100%" viewBox="0 0 28 28" xmlns="http://www.w3.org/2000/svg">
            <circle cx="14" cy="14" r="12" fill="#d9c7a3" stroke="#6e5b4b" stroke-width="2"/>
            <circle cx="14" cy="14" r="5" fill="#6e5b4b"/>
        </svg>
    `,
    className: 'custom-marker',
    iconSize: [28, 28],
    iconAnchor: [14, 28],
    popupAnchor: [0, -28]
});

// =========================
// FUNZIONI (DEFINISCI PRIMA DI USARE)
// =========================

function getIconByType(type) {
    switch(type) {
        case 'tent':
        case 'tenda':
        case 'campo':
            return tentIcon;
        case 'stall':
        case 'negozio':
        case 'struttura':
            return stallIcon;
        case 'spot':
        case 'punto':
        case 'città':
        default:
            return spotIcon;
    }
}

function createPopupContent(place) {
    let content = `
        <div style="min-width: 280px; max-width: 400px; font-family: Arial;">
            <h3 style="margin: 0 0 10px 0; color: #667eea; font-size: 1.2rem;">
                ${place.name}
            </h3>
    `;
    
    if (place.description) {
        content += `
            <p style="margin: 8px 0; color: #666; line-height: 1.5;">
                ${place.description}
            </p>
        `;
    }
    
    if (place.video) {
        content += `
            <video class="video-fade" 
                   style="width: 100%; margin: 10px 0; border-radius: 8px;" 
                   controls loop muted>
                <source src="${place.video}" type="video/mp4">
            </video>
        `;
    }
    
    if (place.audio) {
        content += `
            <audio controls style="width: 100%; margin: 10px 0;">
                <source src="${place.audio}" type="audio/mp3">
            </audio>
        `;
    }
    
    if (place.story) {
        content += `
            <div style="margin-top: 10px; padding: 12px; 
                        background: #f5f5f5; border-left: 4px solid #667eea; 
                        border-radius: 4px;">
                <p style="margin: 0; font-style: italic; color: #444; line-height: 1.6;">
                    ${place.story}
                </p>
            </div>
        `;
    }
    
    if (place.link) {
        content += `
            <a href="${place.link}" target="_blank" 
               style="display: inline-block; margin-top: 10px; 
                      padding: 8px 16px; background: #667eea; color: white; 
                      text-decoration: none; border-radius: 6px; font-size: 0.9rem;">
                📖 Leggi di più
            </a>
        `;
    }
    
    content += `</div>`;
    return content;
}

function addIllustrationMarker(lat, lng, place) {
    if (typeof window.placesLayer === 'undefined') {
        console.error('placesLayer non definito!');
        return;
    }

    const icon = getIconByType(place.type || 'spot');
    
    const marker = L.marker([lat, lng], { icon })
        .addTo(window.placesLayer)
        .bindPopup(createPopupContent(place), {
            maxWidth: 400,
            className: 'custom-popup'
        });
    
    marker.on('click', () => {
        console.log(`Cliccato su: ${place.name}`);
        if (window.map) {
            window.map.setView([lat, lng], Math.max(window.map.getZoom(), 12));
        }
    });
    
    return marker;
}

// =========================
// RENDI GLOBALI
// =========================

window.getIconByType = getIconByType;
window.createPopupContent = createPopupContent;
window.addIllustrationMarker = addIllustrationMarker;

console.log('✅ Layers.js caricato - funzioni esportate');