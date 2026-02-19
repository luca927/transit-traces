import 'leaflet.heat';

function showHeatmap() {
    if (!window.map || !allPlaces) return;
    
    const heatData = allPlaces.map(place => [
        place.lat,
        place.lng,
        place.visits || Math.random() // Intensità
    ]);
    
    const heat = L.heatLayer(heatData, {
        radius: 25,
        blur: 35,
        maxZoom: 10,
        gradient: {
            0.0: 'blue',
            0.5: 'yellow',
            1.0: 'red'
        }
    }).addTo(window.map);
    
    window.heatmapLayer = heat;
}

function toggleHeatmap() {
    if (window.heatmapLayer) {
        window.map.removeLayer(window.heatmapLayer);
        window.heatmapLayer = null;
    } else {
        showHeatmap();
    }
}

window.toggleHeatmap = toggleHeatmap;