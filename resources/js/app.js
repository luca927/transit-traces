import './bootstrap';
import Alpine from 'alpinejs';

// Importa Leaflet
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

// Rendi L globale — FONDAMENTALE per layers.js, cities.js, countries.js
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