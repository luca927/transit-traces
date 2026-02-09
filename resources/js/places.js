// =========================
// CITIES.JS - Database Città
// =========================

const cities = [
    // BOSNIA ED ERZEGOVINA
    {
        id: 'sarajevo',
        name: 'Sarajevo',
        name_en: 'Sarajevo',
        country: 'bosnia',
        lat: 43.8564,
        lng: 18.4131,
        type: 'città',
        icon: '🏛️',
        description: 'Capitale della Bosnia, crocevia di culture e testimone di storia',
        description_en: 'Capital of Bosnia, crossroads of cultures and witness to history',
        
        // MEDIA
        video: '/assets/videos/sarajevo.mp4',
        audio: '/assets/audio/sarajevo.mp3',
        photo: 'https://picsum.photos/800/600?random=sarajevo',
        
        // STORIA
        story: `Sarajevo, la "Gerusalemme d'Europa", è stata per secoli un punto d'incontro tra Oriente e Occidente. 
                Durante la guerra degli anni '90, la città visse un assedio di 1.425 giorni, il più lungo nella storia moderna.
                Oggi, Sarajevo è un simbolo di rinascita e convivenza, ma rimane anche un punto di transito cruciale 
                per chi attraversa la rotta balcanica verso l'Europa.`,
        
        story_en: `Sarajevo, the "Jerusalem of Europe", has been a meeting point between East and West for centuries.
                   During the 1990s war, the city endured a 1,425-day siege, the longest in modern history.
                   Today, Sarajevo is a symbol of rebirth and coexistence, but also remains a crucial transit point
                   for those crossing the Balkan route to Europe.`,
        
        // DETTAGLI AGGIUNTIVI
        date: '22 Marzo 2024',
        duration: '3 giorni',
        highlights: [
            'Baščaršija (Vecchio Bazar)',
            'Ponte Latino',
            'Tunnel della Speranza',
            'Moschea di Gazi Husrev-bey'
        ]
    },
    
    {
        id: 'bihac',
        name: 'Bihać',
        name_en: 'Bihać',
        country: 'bosnia',
        lat: 44.8147,
        lng: 15.8692,
        type: 'campo',
        icon: '🏕️',
        description: 'Confine con la Croazia, ultima tappa prima dell\'UE',
        description_en: 'Border with Croatia, last stop before the EU',
        
        video: '/assets/videos/bihac.mp4',
        audio: '/assets/audio/bihac.mp3',
        photo: 'https://picsum.photos/800/600?random=bihac',
        
        story: `Bihać è diventata tristemente famosa come "porta d'Europa" lungo la rotta balcanica.
                Qui si concentrano migliaia di migranti che aspettano per mesi di attraversare il confine croato,
                affrontando il pericoloso "Game" - il tentativo di attraversare illegalmente la frontiera.
                I campi profughi attorno alla città sono sovraffollati e le condizioni sono spesso disumane.`,
        
        story_en: `Bihać has become infamous as the "gateway to Europe" along the Balkan route.
                   Thousands of migrants gather here, waiting for months to cross the Croatian border,
                   facing the dangerous "Game" - the attempt to cross the frontier illegally.
                   Refugee camps around the city are overcrowded and conditions are often inhumane.`,
        
        date: '25 Marzo 2024',
        duration: '5 giorni',
        highlights: [
            'Campo profughi di Lipa',
            'Cascate di Una',
            'Confine croato',
            'Foreste di confine'
        ]
    },
    
    // BULGARIA
    {
        id: 'harmanli',
        name: 'Harmanli',
        name_en: 'Harmanli',
        country: 'bulgaria',
        lat: 41.9317,
        lng: 25.9092,
        type: 'campo',
        icon: '⛺',
        description: 'Centro di accoglienza nel sud della Bulgaria',
        description_en: 'Reception center in southern Bulgaria',
        
        video: '/assets/videos/harmanli.mp4',
        audio: '/assets/audio/harmanli.mp3',
        photo: 'https://picsum.photos/800/600?random=harmanli',
        
        story: `Harmanli ospita uno dei più grandi centri di accoglienza per migranti della Bulgaria.
                Situato vicino al confine turco, questo centro è spesso il primo punto di arrivo in Europa
                per chi proviene dal Medio Oriente e dall'Asia.
                Le condizioni di vita sono difficili, con sovraffollamento cronico e risorse limitate.`,
        
        story_en: `Harmanli hosts one of Bulgaria's largest reception centers for migrants.
                   Located near the Turkish border, this center is often the first arrival point in Europe
                   for those coming from the Middle East and Asia.
                   Living conditions are harsh, with chronic overcrowding and limited resources.`,
        
        date: '10 Marzo 2024',
        duration: '2 giorni',
        highlights: [
            'Centro di accoglienza',
            'Mercato locale',
            'Comunità di transito',
            'Checkpoint di frontiera'
        ]
    },
    
    // GRECIA
    {
        id: 'lesvos',
        name: 'Lesvos',
        name_en: 'Lesvos',
        country: 'greece',
        lat: 39.0742,
        lng: 26.3233,
        type: 'natura',
        icon: '🏝️',
        description: 'Isola dell\'Egeo, primo approdo in Europa',
        description_en: 'Aegean island, first landing in Europe',
        
        video: '/assets/videos/lesvos.mp4',
        audio: '/assets/audio/lesvos.mp3',
        photo: 'https://picsum.photos/800/600?random=lesvos',
        
        story: `Lesvos è diventata simbolo della crisi migratoria europea. 
                Questa isola greca dell'Egeo, a pochi chilometri dalla Turchia, ha accolto centinaia di migliaia
                di rifugiati che attraversano il mare su gommoni pericolanti.
                Il campo di Moria, ora chiuso, era il più grande campo profughi d'Europa.
                Le spiagge di Lesvos hanno visto arrivare salvavita arancioni e sogni di libertà.`,
        
        story_en: `Lesvos has become a symbol of the European migration crisis.
                   This Greek Aegean island, just a few kilometers from Turkey, has welcomed hundreds of thousands
                   of refugees crossing the sea on precarious dinghies.
                   The Moria camp, now closed, was Europe's largest refugee camp.
                   The beaches of Lesvos have witnessed orange life jackets and dreams of freedom arriving.`,
        
        date: '5 Marzo 2024',
        duration: '4 giorni',
        highlights: [
            'Ex campo di Moria',
            'Spiagge di sbarco',
            'Porto di Mitilene',
            'Memoriali dei naufraghi'
        ]
    }
];

// =========================
// FUNZIONI HELPER
// =========================

function getCitiesByCountry(countryKey) {
    return cities.filter(city => city.country === countryKey);
}

function getCityById(cityId) {
    return cities.find(city => city.id === cityId);
}

function getCityByName(cityName) {
    return cities.find(city => 
        city.name.toLowerCase() === cityName.toLowerCase() ||
        city.name_en.toLowerCase() === cityName.toLowerCase()
    );
}

// =========================
// POPOLA CITIES NEL DATABASE allPlaces
// =========================

function mergeCitiesIntoPlaces() {
    if (!window.allPlaces) {
        window.allPlaces = [];
    }

    // Aggiungi le città al database places
    cities.forEach(city => {
        // Controlla se la città esiste già
        const exists = window.allPlaces.some(place => 
            place.id === city.id || 
            (place.name.toLowerCase() === city.name.toLowerCase() && 
             place.lat === city.lat && 
             place.lng === city.lng)
        );

        if (!exists) {
            window.allPlaces.push(city);
        }
    });

    console.log('✅ Città integrate in allPlaces:', window.allPlaces.length, 'luoghi totali');
}

// =========================
// CREA POPUP CITTÀ CON LINK PAGINA
// =========================

function createCityPopupWithLink(city) {
    const lang = window.currentLang || 'it';
    const desc = lang === 'it' ? city.description : city.description_en;
    const storyText = lang === 'it' ? city.story : city.story_en;
    const exploreText = lang === 'it' ? '📖 Esplora la storia completa' : '📖 Explore full story';
    
    let content = `
        <div style="min-width: 320px; max-width: 450px; font-family: 'Segoe UI', sans-serif;">
            <h3 style="margin: 0 0 8px 0; color: #667eea; font-size: 1.4rem; font-weight: 600;">
                ${city.icon} ${city.name}
            </h3>
            <p style="margin: 5px 0 12px 0; color: #999; font-size: 0.9rem;">
                📅 ${city.date || 'Data da definire'}
            </p>
    `;
    
    // Foto
    if (city.photo) {
        content += `
            <img src="${city.photo}" 
                 alt="${city.name}"
                 style="width: 100%; height: 220px; object-fit: cover; 
                        margin: 12px 0; border-radius: 10px; 
                        box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
        `;
    }
    
    // Descrizione breve
    content += `
        <p style="color: #555; line-height: 1.6; margin: 12px 0;">
            ${desc}
        </p>
    `;
    
    // Storia (estratto)
    if (storyText) {
        const excerpt = storyText.substring(0, 150) + '...';
        content += `
            <div style="margin-top: 15px; padding: 15px; 
                        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); 
                        border-left: 4px solid #667eea; 
                        border-radius: 8px;">
                <p style="margin: 0; font-style: italic; color: #444; 
                          line-height: 1.7; font-size: 0.9rem;">
                    ${excerpt}
                </p>
            </div>
        `;
    }
    
    // Bottone per pagina dedicata
    content += `
        <button onclick="goToCityPage('${city.country}', '${city.id}')" 
                style="width: 100%; margin-top: 15px; padding: 12px; 
                       background: linear-gradient(135deg, #667eea, #764ba2); 
                       color: white; border: none; border-radius: 8px; 
                       font-weight: bold; cursor: pointer; font-size: 1rem;
                       transition: all 0.3s;">
            ${exploreText} →
        </button>
    `;
    
    content += `</div>`;
    return content;
}

// =========================
// NAVIGA ALLA PAGINA CITTÀ
// =========================

function goToCityPage(country, cityId) {
    const city = getCityById(cityId);
    
    if (!city) {
        console.error('Città non trovata:', cityId);
        return;
    }

    console.log(`🗺️ Navigazione a: ${city.name}, ${country}`);
    
    // In produzione, questo sarà un vero redirect
    // window.location.href = `/city/${country}/${cityId}`;
    
    // Per ora, mostra un drawer con i dettagli completi
    openCityDrawer(city);
}

// =========================
// DRAWER DETTAGLIO CITTÀ
// =========================

function openCityDrawer(city) {
    const lang = window.currentLang || 'it';
    const storyText = lang === 'it' ? city.story : city.story_en;
    
    let drawer = document.getElementById('city-detail-drawer');
    
    if (!drawer) {
        drawer = document.createElement('div');
        drawer.id = 'city-detail-drawer';
        drawer.style.cssText = `
            position: fixed;
            top: 0;
            right: -100%;
            width: 600px;
            max-width: 90vw;
            height: 100vh;
            background: white;
            z-index: 6000;
            transition: right 0.7s cubic-bezier(0.19, 1, 0.22, 1);
            box-shadow: -10px 0 40px rgba(0,0,0,0.3);
            overflow-y: auto;
        `;
        document.body.appendChild(drawer);
    }
    
    drawer.innerHTML = `
        <div style="padding: 40px;">
            <button onclick="closeCityDrawer()" 
                    style="float: right; background: none; border: none; 
                           font-size: 2rem; color: #e74c3c; cursor: pointer;">
                ×
            </button>
            
            <h1 style="font-size: 2.5rem; color: #2c3e50; margin-bottom: 10px;">
                ${city.icon} ${city.name}
            </h1>
            
            <p style="color: #999; font-size: 1rem; margin-bottom: 30px;">
                📅 ${city.date || 'Data da definire'} | ⏱️ ${city.duration || 'Durata da definire'}
            </p>
            
            ${city.photo ? `
                <img src="${city.photo}" 
                     style="width: 100%; height: 300px; object-fit: cover; 
                            border-radius: 12px; margin-bottom: 30px;
                            box-shadow: 0 8px 20px rgba(0,0,0,0.15);">
            ` : ''}
            
            ${city.video ? `
                <video controls style="width: 100%; border-radius: 12px; margin-bottom: 30px;">
                    <source src="${city.video}" type="video/mp4">
                </video>
            ` : ''}
            
            ${city.audio ? `
                <audio controls style="width: 100%; margin-bottom: 30px;">
                    <source src="${city.audio}" type="audio/mp3">
                </audio>
            ` : ''}
            
            <div style="background: #f8f9fa; padding: 25px; border-radius: 12px; 
                        border-left: 5px solid #667eea; margin-bottom: 30px;">
                <p style="line-height: 1.8; color: #333; font-size: 1.05rem; margin: 0;">
                    ${storyText}
                </p>
            </div>
            
            ${city.highlights && city.highlights.length > 0 ? `
                <h3 style="color: #2c3e50; margin-bottom: 15px;">
                    ✨ ${lang === 'it' ? 'Punti di interesse' : 'Highlights'}
                </h3>
                <ul style="list-style: none; padding: 0;">
                    ${city.highlights.map(h => `
                        <li style="padding: 10px; background: #f8f9fa; margin-bottom: 8px; 
                                   border-radius: 6px; border-left: 3px solid #3498db;">
                            📍 ${h}
                        </li>
                    `).join('')}
                </ul>
            ` : ''}
        </div>
    `;
    
    // Apri il drawer
    setTimeout(() => {
        drawer.style.right = '0';
    }, 100);
}

function closeCityDrawer() {
    const drawer = document.getElementById('city-detail-drawer');
    if (drawer) {
        drawer.style.right = '-100%';
    }
}

// =========================
// ESPORTA GLOBALI
// =========================

window.cities = cities;
window.getCitiesByCountry = getCitiesByCountry;
window.getCityById = getCityById;
window.getCityByName = getCityByName;
window.mergeCitiesIntoPlaces = mergeCitiesIntoPlaces;
window.createCityPopupWithLink = createCityPopupWithLink;
window.goToCityPage = goToCityPage;
window.openCityDrawer = openCityDrawer;
window.closeCityDrawer = closeCityDrawer;

// =========================
// AUTO-INIZIALIZZAZIONE
// =========================

window.addEventListener('mapReady', () => {
    console.log('🏙️ Cities.js: Integro città nel database...');
    mergeCitiesIntoPlaces();
});

console.log('✅ Cities.js caricato - 4 città definite');