import './bootstrap';
import Alpine from 'alpinejs';

// Importa Leaflet
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import 'leaflet-polylinedecorator';

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
    
    // 1. Carica map.js per primo
    await import('./map.js');
    console.log('✅ Map.js caricato');
    
    // 2. Poi layers.js
    await import('./layers.js');
    console.log('✅ Layers.js caricato');
    
    // 3. Poi routes.js
    await import('./routes.js');
    console.log('✅ Routes.js caricato');
    
    // 4. Infine narrative.js
    await import('./narrative.js');
    console.log('✅ Narrative.js caricato');
    
    // Evento personalizzato per dire che tutto è pronto
    window.dispatchEvent(new Event('mapReady'));
});