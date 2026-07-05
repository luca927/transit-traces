<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Migrart — Mappa</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=Bebas+Neue&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --ochre: #3b2dfa;
            --paper: #f5f0e8;
            --ink: #1a1410;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body, html {
            width: 100%; height: 100%;
            overflow: hidden;
            background: #fff;
            font-family: 'DM Sans', sans-serif;
        }

        /* CONTENITORE MAPPA */
        .map-wrap {
            position: fixed; inset: 0;
            width: 100vw; height: 100vh;
        }

        /* IMMAGINE MAPPA */
        .map-img {
            width: 100%; height: 100%;
            object-fit: cover;
            object-position: center center; /* default */
            object-position: left center;   /* ancora a sinistra */
            display: block;
            user-select: none;
            -webkit-user-drag: none;
        }

        /* SVG OVERLAY — linea tragitto */
        .map-svg {
            position: absolute; inset: 0;
            width: 100%; height: 100%;
            pointer-events: none;
            overflow: visible;
        }

        .route-line {
            fill: none;
            stroke: var(--ochre);
            stroke-width: 2.5;
            stroke-linecap: round;
            stroke-linejoin: round;
            opacity: 0;
            stroke-dasharray: 6 8;
            transition: opacity 0.6s ease;
        }

        /* la linea appare quando la mappa è "attiva" (hover o dopo il disegno iniziale) */
        .map-wrap.route-visible ~ .map-svg .route-line,
        .map-svg.route-visible .route-line {
            opacity: 0.85;
        }

        /* effetto "formica in marcia" - il tratteggio scorre lungo il percorso */
        .route-line.flowing {
            animation: flowDash 25s linear infinite;
        }

        @keyframes flowDash {
            to { stroke-dashoffset: -1000; }
        }

        /* disegno iniziale della linea (si traccia da sola al caricamento) */
        .route-line.drawing {
            stroke-dasharray: var(--path-length, 3000);
            stroke-dashoffset: var(--path-length, 3000);
            opacity: 0.85;
            animation: drawRoute 3.5s ease forwards;
        }

        @keyframes drawRoute {
            to { stroke-dashoffset: 0; }
        }

        .route-line-hit {
            fill: none;
            stroke: transparent;
            stroke-width: 30;
            cursor: pointer;
            pointer-events: all;
        }

        .route-line-hit:hover ~ .route-line,
        .route-line-hit:hover {
            filter: drop-shadow(0 0 6px rgba(59,45,250,0.6));
        }

        /* PUNTI CITTÀ */
        .city-dot {
            position: absolute;
            transform: translate(-50%, -50%);
            cursor: pointer;
            z-index: 10;
        }

        .city-dot-inner {
            width: 10px; height: 10px;
            background: var(--ochre);
            border: 2px solid rgba(255,255,255,0.8);
            border-radius: 50%;
            box-shadow: 0 0 8px rgba(194,106,42,0.4);
            transition: all 0.3s ease;
            animation: dotPulse 2.8s ease-in-out infinite;
        }

        @keyframes dotPulse {
            0%, 100% { box-shadow: 0 0 8px rgba(59,45,250,0.4); }
            50% { box-shadow: 0 0 14px rgba(59,45,250,0.75); }
        }

        .city-dot:hover .city-dot-inner {
            width: 14px; height: 14px;
            background: var(--ochre);
            box-shadow: 0 0 16px rgba(194,106,42,0.7);
        }

        /* TOOLTIP CITTÀ */
        .city-tooltip {
            position: absolute;
            bottom: 20px; left: 50%;
            transform: translateX(-50%);
            background: rgba(26,20,16,0.9);
            color: var(--paper);
            padding: 6px 12px;
            font-size: 0.7rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
            font-family: 'DM Sans', sans-serif;
        }

        .city-dot:hover .city-tooltip { opacity: 1; }

        /* HEADER */
        header {
            position: fixed; top: 0; right: 0;
            padding: 1.2rem 2rem;
            z-index: 5000;
            display: flex; gap: 1.5rem; align-items: center;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            border-bottom-left-radius: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.3rem; letter-spacing: 0.1em;
            color: var(--ink); text-decoration: none;
        }
        .logo span { color: var(--ochre); }

        .lang-btn {
            padding: 6px 14px;
            border-radius: 20px;
            border: 1.5px solid #ddd;
            cursor: pointer; font-weight: 600;
            font-size: 0.75rem;
            transition: 0.3s; text-transform: uppercase;
            background: white; color: #333;
            font-family: 'DM Sans', sans-serif;
        }
        .lang-btn.active {
            background: var(--ochre);
            color: white;
            border-color: var(--ochre);
        }

        /* BACK BUTTON */
        .back-btn {
            position: fixed; bottom: 2rem; left: 2rem;
            z-index: 5000;
            display: flex; align-items: center; gap: 0.6rem;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            color: var(--ink); text-decoration: none;
            font-size: 0.7rem; letter-spacing: 0.15em;
            text-transform: uppercase;
            padding: 10px 18px;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s;
            font-family: 'DM Sans', sans-serif;
        }
        .back-btn:hover { background: var(--ochre); color: white; }

        /* AUDIO */
        #ambient-audio { display: none; }
    </style>
</head>
<body>

<!-- HEADER -->
<header>
    <a href="/" class="logo"><span>Migr</span>art</a>
    <div>
        <button id="it-btn" class="lang-btn active" onclick="setLanguage('it')">IT</button>
        <button id="en-btn" class="lang-btn" onclick="setLanguage('en')">EN</button>
    </div>
</header>

<!-- BACK -->
<a href="/" class="back-btn">
    <i class="fas fa-arrow-left"></i>
    <span id="back-text">Home</span>
</a>

<!-- MAPPA -->
<div class="map-wrap" id="mapWrap">
    <img 
        src="{{ asset('images/map2.svg') }}" 
        class="map-img" 
        id="mapImg"
        alt="Mappa Migrart"
        draggable="false"
    >
</div>

<svg class="map-svg" id="mapSvg">
</svg>

<!-- AUDIO -->
<audio id="ambient-audio" src="{{ asset('audio/ambient.mp3') }}" loop></audio>

<script>
    // =========================
    // CITTÀ con coordinate in percentuale
    // calcolate da pixel: x% = px_x/1754*100, y% = px_y/1240*100
    // =========================
    const cities = [
    { id: 'trieste', name: 'Trieste', country: 'italy', x: 19.4, y: 11.6 },
    { id: 'bihac', name: 'Bihać', country: 'bosnia', x: 26.4, y: 20.7 },
    { id: 'srebrenica', name: 'Srebrenica', country: 'bosnia', x: 35.7, y: 26.7 },
    { id: 'dimitrovgrad', name: 'Dimitrovgrad', country: 'serbia', x: 42.5, y: 26.8 },
    { id: 'harmanli', name: 'Harmanli', country: 'bulgaria', x: 59.4, y: 47.3 },
    { id: 'idomeni', name: 'Idomeni', country: 'greece', x: 46.1, y: 59.5 },
    { id: 'istanbul', name: 'Istanbul', country: 'turkey', x: 66.8, y: 57.2 },
    { id: 'lesvos', name: 'Lesvos', country: 'greece', x: 57.2, y: 73.1 },
    { id: 'izmir', name: 'Izmir', country: 'turkey', x: 60.5, y: 78.0 },
    // Sarajevo non è disegnata come pin separato su questa mappa
    { id: 'sarajevo', name: 'Sarajevo', country: 'bosnia', x: null, y: null },
];

    // Ordine del tragitto (segue lo zig-zag disegnato: Turchia -> Grecia -> Bulgaria -> Serbia -> Bosnia -> Italia)
    const routeOrder = ['istanbul', 'izmir', 'lesvos', 'idomeni', 'harmanli', 'dimitrovgrad', 'srebrenica', 'bihac', 'trieste'];

    // =========================
    // CREA PUNTI CITTÀ
    // =========================
    const mapWrap = document.getElementById('mapWrap');

    cities.forEach(city => {
        if (city.x === null) return; // salta città senza coordinate

        const dot = document.createElement('div');
        dot.className = 'city-dot';
        dot.style.left = city.x + '%';
        dot.style.top = city.y + '%';
        dot.title = city.name;

        dot.innerHTML = `
            <div class="city-dot-inner"></div>
            <div class="city-tooltip">${city.name}</div>
        `;

        dot.addEventListener('click', () => {
            window.location.href = `/citta/${city.id}`;
        });

        mapWrap.appendChild(dot);
    });

    // =========================
    // LINEA TRAGITTO SVG — curva morbida stile "Refugee Republic"
    // =========================
    const svg = document.getElementById('mapSvg');
    const mapImg = document.getElementById('mapImg');

    const routeCities = routeOrder
        .map(id => cities.find(c => c.id === id))
        .filter(c => c && c.x !== null);

    // Crea gli elementi path (non più polyline: il path ci serve per le curve)
    const hitLine = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    hitLine.setAttribute('class', 'route-line-hit');

    const visLine = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    visLine.setAttribute('class', 'route-line drawing flowing');

    svg.appendChild(hitLine);
    svg.appendChild(visLine);

    // --- Converte una serie di punti in una curva morbida (Catmull-Rom -> Bezier) ---
    function smoothPath(points) {
        if (points.length < 2) return '';
        let d = `M ${points[0].x},${points[0].y}`;

        for (let i = 0; i < points.length - 1; i++) {
            const p0 = points[i - 1] || points[i];
            const p1 = points[i];
            const p2 = points[i + 1];
            const p3 = points[i + 2] || p2;

            // tensione della curva: 6 = morbida, valori più bassi = più "tirata"
            const cp1x = p1.x + (p2.x - p0.x) / 6;
            const cp1y = p1.y + (p2.y - p0.y) / 6;
            const cp2x = p2.x - (p3.x - p1.x) / 6;
            const cp2y = p2.y - (p3.y - p1.y) / 6;

            d += ` C ${cp1x},${cp1y} ${cp2x},${cp2y} ${p2.x},${p2.y}`;
        }
        return d;
    }

    // Trova la città più vicina a un punto lungo il tragitto (per il click)
    function nearestCityOnClick(e) {
        const rect = svg.getBoundingClientRect();
        const mx = (e.clientX - rect.left) / rect.width * 100;
        const my = (e.clientY - rect.top) / rect.height * 100;
        let minDist = Infinity, closest = null;
        routeCities.forEach(c => {
            const dist = Math.sqrt((c.x - mx) ** 2 + (c.y - my) ** 2);
            if (dist < minDist) { minDist = dist; closest = c; }
        });
        return closest;
    }

    hitLine.addEventListener('click', e => {
        const closest = nearestCityOnClick(e);
        if (closest) window.location.href = `/citta/${closest.id}`;
    });

    // Aggiorna posizione punti in base alle dimensioni reali dell'immagine
    function updateSvg() {
        const rect = mapImg.getBoundingClientRect();
        svg.setAttribute('viewBox', `0 0 ${rect.width} ${rect.height}`);

        const pts = routeCities.map(c => ({
            x: c.x / 100 * rect.width,
            y: c.y / 100 * rect.height
        }));

        const d = smoothPath(pts);
        hitLine.setAttribute('d', d);
        visLine.setAttribute('d', d);

        // Imposta la lunghezza reale del percorso per l'animazione "si disegna da sola"
        const length = visLine.getTotalLength();
        visLine.style.setProperty('--path-length', length);
    }

    mapImg.addEventListener('load', updateSvg);
    window.addEventListener('resize', updateSvg);
    updateSvg();

    // =========================
    // TEMP: TROVA COORDINATE % CLICCANDO SULLA MAPPA
    // Usalo per trovare x/y di Dimitrovgrad e Sarajevo, poi rimuovi il blocco
    // =========================
    mapImg.addEventListener('click', (e) => {
        const rect = mapImg.getBoundingClientRect();
        const xPct = ((e.clientX - rect.left) / rect.width * 100).toFixed(1);
        const yPct = ((e.clientY - rect.top) / rect.height * 100).toFixed(1);
        const coordStr = `x: ${xPct}, y: ${yPct}`;
        console.log('📍 Coordinate copiate:', coordStr);
        navigator.clipboard.writeText(coordStr);
    });

        // =========================
        // AUDIO
        // =========================
        const audio = document.getElementById('ambient-audio');
        document.addEventListener('click', () => {
            audio.volume = 0.3;
            audio.play().catch(e => console.warn('Audio bloccato:', e));
        }, { once: true });

    // =========================
    // LINGUA
    // =========================
    function setLanguage(lang) {
        window.currentLang = lang;
        document.getElementById('it-btn').classList.toggle('active', lang === 'it');
        document.getElementById('en-btn').classList.toggle('active', lang === 'en');
        document.getElementById('back-text').textContent = lang === 'it' ? 'Home' : 'Home';
    }

    window.setLanguage = setLanguage;
    setLanguage('it');

    console.log('✅ Mappa Migrart caricata');
</script>

</body>
</html>