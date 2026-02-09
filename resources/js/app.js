import './bootstrap';
import Alpine from 'alpinejs';

// Importa Leaflet
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import 'leaflet-polylinedecorator';
// Dopo le altre import
import './storytelling.js';
import './heatmap.js';

// Rendi L globale
window.L = L;

// Fix icone Leaflet
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
    iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
});

window.Alpine = Alpine;
Alpine.start();

// CARICAMENTO SEQUENZIALE
document.addEventListener('DOMContentLoaded', async function() {
    // Aspetta che il div #map esista
    const mapElement = document.getElementById('map');
    if (!mapElement) {
        console.error('Elemento #map non trovato!');
        return;
    }
    
    // 2. Poi layers.js
    await import('./layers.js');
    console.log('✅ Layers.js caricato');

    // 4. Places.js → USA le funzioni di layers.js per aggiungere luoghi
    await import('./places.js');
    
    // 5. Poi routes.js
    await import('./routes.js');
    console.log('✅ Routes.js caricato');
    
    // 6. Infine narrative.js
    await import('./narrative.js');
    console.log('✅ Narrative.js caricato');
    
    // Evento personalizzato per dire che tutto è pronto
    window.dispatchEvent(new Event('mapReady'));
});