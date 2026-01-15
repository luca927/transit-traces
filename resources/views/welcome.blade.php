<!DOCTYPE html>
<html>
<head>
    <title>Refugee Republic Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>#map { height: 100vh; width: 100%; }</style>
</head>
<body>
    <div id="map"></div>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([36.805, 43.105], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        
        // MARKERS DEFAULT BLU (visibili sempre)
        L.marker([36.8, 43.1]).addTo(map).bindPopup('Domiz Entrance');
        L.marker([36.81, 43.11]).addTo(map).bindPopup('Ahmed Stall');
        
        // Prova API
        fetch('/places')
            .then(r => r.json())
            .then(places => {
                console.log('API:', places); // F12 → Console
                places.forEach(place => {
                    L.marker([place.latitude, place.longitude])
                        .addTo(map)
                        .bindPopup(place.name);
                });
            })
            .catch(e => console.error('API errore:', e));
    </script>
</body>
</html>
