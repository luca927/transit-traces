<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Migrart — Città</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=Bebas+Neue&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --ink: #1a1410;
            --paper: #f5f0e8;
            --ochre: #c26a2a;
            --muted: #8a7d6e;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #000;
            color: var(--paper);
            font-family: 'DM Sans', sans-serif;
            overflow: hidden;
            height: 100vh;
            width: 100vw;
        }

        /* STRIP ORIZZONTALE */
        .gallery-strip {
            position: fixed; inset: 0;
            overflow: hidden;
        }

        .slides-track {
            display: flex;
            height: 100%;
            transition: transform 0.55s cubic-bezier(0.77, 0, 0.175, 1);
            will-change: transform;
        }

        /* SLIDE */
        .slide {
            flex: 0 0 100vw;
            width: 100vw;
            height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* FOTO */
        .slide img {
            width: 100%; height: 100%;
            object-fit: cover;
            display: block;
        }

        .slide-photo-placeholder {
            width: 100%; height: 100%;
            background: linear-gradient(135deg, #1a1410, #0d0b08);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 1rem;
        }
        .slide-photo-placeholder i { font-size: 3rem; color: rgba(194,106,42,0.3); }
        .slide-photo-placeholder p {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic; font-size: 1.1rem;
            color: rgba(245,240,232,0.2);
        }

        /* VIDEO */
        .slide-video-placeholder {
            width: 100%; height: 100%;
            background: #0d0b08;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 1.5rem;
        }
        .play-circle {
            width: 80px; height: 80px;
            border: 1px solid rgba(194,106,42,0.4);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
        }
        .play-circle i { color: var(--ochre); font-size: 1.5rem; margin-left: 5px; }

        .slide-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(
                to top,
                rgba(0,0,0,0.8) 0%,
                rgba(0,0,0,0.5) 18%,
                transparent 45%,
                transparent 60%,
                rgba(0,0,0,0.35) 100%
            );
            pointer-events: none;
        }

        /* INFO */
        .slide-info {
            position: absolute;
            bottom: 5rem; left: 4rem;
            z-index: 10;
        }
        .slide-city-name {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(3rem, 8vw, 6rem);
            line-height: 0.85; color: var(--paper);
            text-shadow: 0 2px 20px rgba(0,0,0,0.5);
        }
        .slide-country {
            font-size: 0.7rem; letter-spacing: 0.3em;
            text-transform: uppercase; color: var(--ochre);
            margin-bottom: 0.5rem; display: block;
        }

        .slide-type {
            position: absolute;
            top: 5rem; right: 4rem;
            font-size: 0.65rem; letter-spacing: 0.25em;
            text-transform: uppercase;
            color: rgba(245,240,232,0.3);
            z-index: 10;
        }

        /* FRECCE — sottili, appaiono solo quando necessario */
        .nav-arrow {
            position: fixed;
            top: 50%; transform: translateY(-50%);
            z-index: 100;
            background: none; border: none;
            cursor: pointer; padding: 1rem;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }
        .nav-arrow.visible {
            opacity: 0.35;
            pointer-events: all;
        }
        .nav-arrow:hover { opacity: 1 !important; }
        .nav-arrow.prev { left: 1.2rem; }
        .nav-arrow.next { right: 1.2rem; }
        .nav-arrow i { color: var(--paper); font-size: 1.1rem; }

        /* PROGRESS BAR */
        .progress-track {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            height: 2px;
            background: rgba(245,240,232,0.08);
            z-index: 199;
        }
        .progress-bar {
            position: fixed;
            bottom: 0; left: 0;
            height: 2px;
            background: var(--ochre);
            transition: width 0.55s cubic-bezier(0.77, 0, 0.175, 1);
            z-index: 200;
        }

        /* CONTATORE */
        .slide-counter {
            position: fixed;
            bottom: 1.5rem; right: 3rem;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 0.9rem; letter-spacing: 0.08em;
            color: rgba(245,240,232,0.25);
            z-index: 200;
        }
        .slide-counter span { color: rgba(245,240,232,0.55); }

        /* HEADER */
        .page-header {
            position: fixed; top: 0; left: 0; right: 0;
            padding: 1.5rem 3rem;
            z-index: 300;
            display: flex; justify-content: space-between; align-items: center;
            background: linear-gradient(to bottom, rgba(0,0,0,0.6), transparent);
        }
        .logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.4rem; letter-spacing: 0.1em;
            color: var(--paper); text-decoration: none;
        }
        .logo span { color: var(--ochre); }

        .back-btn {
            display: flex; align-items: center; gap: 0.6rem;
            color: var(--paper); text-decoration: none;
            font-size: 0.75rem; letter-spacing: 0.15em;
            text-transform: uppercase; opacity: 0.5;
            transition: opacity 0.3s;
        }
        .back-btn:hover { opacity: 1; }

        /* NAVIGAZIONE CITTÀ — in basso, appare solo su prima/ultima slide */
        .city-nav-btn {
            position: fixed;
            bottom: 4.5rem;
            z-index: 300;
            display: flex; align-items: center; gap: 0.8rem;
            color: rgba(245,240,232,0.5);
            text-decoration: none;
            font-size: 0.65rem; letter-spacing: 0.2em;
            text-transform: uppercase;
            transition: color 0.3s, opacity 0.4s;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
        }
        .city-nav-btn.visible {
            opacity: 1;
            pointer-events: all;
        }
        .city-nav-btn:hover { color: var(--paper); }
        .city-nav-btn i { font-size: 0.6rem; }
        .city-nav-btn .city-label {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.1rem; letter-spacing: 0.1em;
            color: inherit;
        }
        .city-nav-btn.prev-city { left: 4rem; bottom: 1.8rem; }
        .city-nav-btn.next-city { right: 4rem; bottom: 4.5rem; }
    </style>
</head>
<body>

<header class="page-header">
    <a href="/" class="logo"><span>Migr</span>art</a>
    <a href="/mappa" class="back-btn">
        <i class="fas fa-arrow-left"></i>
        Mappa
    </a>
</header>

<!-- NAVIGAZIONE CITTÀ IN BASSO -->
<a href="#" class="city-nav-btn prev-city" id="cityPrev">
    <i class="fas fa-chevron-left"></i>
    <span class="city-label" id="cityPrevName"></span>
</a>
<a href="#" class="city-nav-btn next-city" id="cityNext">
    <span class="city-label" id="cityNextName"></span>
    <i class="fas fa-chevron-right"></i>
</a>

<div class="gallery-strip">
    <div class="slides-track" id="slidesTrack"></div>
</div>

<button class="nav-arrow prev" id="arrowPrev" onclick="changeSlide(-1)">
    <i class="fas fa-chevron-left"></i>
</button>
<button class="nav-arrow next" id="arrowNext" onclick="changeSlide(1)">
    <i class="fas fa-chevron-right"></i>
</button>

<div class="progress-track"></div>
<div class="progress-bar" id="progressBar"></div>

<div class="slide-counter">
    <span id="counterCurrent">1</span> / <span id="counterTotal">1</span>
</div>

<script>
    const citiesData = {
        istanbul: {
            name: 'Istanbul', country: 'Turchia',
            media: [
                { type: 'photo', src: '' },
                { type: 'photo', src: '' },
            ]
        },
        izmir: {
            name: 'Izmir', country: 'Turchia',
            media: [
                { type: 'photo', src: '' },
            ]
        },
        lesvos: {
            name: 'Lesvos', country: 'Grecia',
            media: [
                { type: 'photo', src: '' },
                { type: 'photo', src: '' },
                { type: 'video', src: '' },
            ]
        },
        idomeni: {
            name: 'Idomeni', country: 'Grecia',
            media: [
                { type: 'photo', src: '/images/interno5.png' },
                { type: 'photo', src: '/images/interno6.png' },
                { type: 'video', src: '' },
            ]
        },
        dimitrovgrad: {
            name: 'Dimitrovgrad', country: 'Serbia',
            media: [
                { type: 'photo', src: '' },
            ]
        },
        harmanli: {
            name: 'Harmanli', country: 'Bulgaria',
            media: [
                { type: 'photo', src: '' },
                { type: 'video', src: '' },
            ]
        },
        srebrenica: {
            name: 'Srebrenica', country: 'Bosnia ed Erzegovina',
            media: [
                { type: 'photo', src: '' },
                { type: 'photo', src: '' },
                { type: 'video', src: '' },
            ]
        },
        bihac: {
            name: 'Bihać', country: 'Bosnia ed Erzegovina',
            media: [
                { type: 'photo', src: '' },
                { type: 'photo', src: '' },
                { type: 'video', src: '' },
            ]
        },
        sarajevo: {
            name: 'Sarajevo', country: 'Bosnia ed Erzegovina',
            media: [
                { type: 'photo', src: '' },
                { type: 'photo', src: '' },
                { type: 'video', src: '' },
            ]
        },
        trieste: {
            name: 'Trieste', country: 'Italia',
            media: [
                { type: 'photo', src: '' },
                { type: 'photo', src: '' },
            ]
        },
    };

    const routeOrder = ['trieste', 'sarajevo', 'bihac', 'srebrenica', 'harmanli', 'dimitrovgrad', 'idomeni', 'lesvos', 'izmir', 'istanbul'];

    const cityId = "{{ $cityId }}";
    const city = citiesData[cityId];
    let currentSlide = 0;

    if (city) {
        document.title = `Migrart — ${city.name}`;

        const track = document.getElementById('slidesTrack');
        const total = city.media.length;
        document.getElementById('counterTotal').textContent = total;

        city.media.forEach((item, i) => {
            const slide = document.createElement('div');
            slide.className = 'slide';

            const overlay = `<div class="slide-overlay"></div>`;
            const info = `
                <div class="slide-info">
                    <span class="slide-country">${city.country}</span>
                    <h1 class="slide-city-name">${city.name}</h1>
                </div>
                <div class="slide-type">${item.type === 'photo' ? 'Foto' : 'Video'}</div>
            `;

            if (item.type === 'photo') {
                if (item.src) {
                    slide.innerHTML = `<img src="${item.src}" alt="${city.name}">${overlay}${info}`;
                } else {
                    slide.innerHTML = `
                        <div class="slide-photo-placeholder">
                            <i class="fas fa-image"></i>
                            <p>Foto — da inserire</p>
                        </div>${overlay}${info}`;
                }
            } else if (item.type === 'video') {
                if (item.src) {
                    slide.innerHTML = `
                        <video controls style="width:100%;height:100%;object-fit:contain;background:#000;">
                            <source src="${item.src}" type="video/mp4">
                        </video>${info}`;
                } else {
                    slide.innerHTML = `
                        <div class="slide-video-placeholder">
                            <div class="play-circle"><i class="fas fa-play"></i></div>
                            <p style="font-family:'Cormorant Garamond',serif;font-style:italic;color:rgba(245,240,232,0.3);">
                                Video — da inserire
                            </p>
                        </div>${info}`;
                }
            }

            track.appendChild(slide);
        });

        // Navigazione città prev/next
        const idx = routeOrder.indexOf(cityId);
        const hasPrev = idx > 0;
        const hasNext = idx < routeOrder.length - 1;

        if (hasPrev) {
            const prevId = routeOrder[idx - 1];
            document.getElementById('cityPrevName').textContent = citiesData[prevId]?.name || prevId;
            document.getElementById('cityPrev').href = `/citta/${prevId}`;
        }
        if (hasNext) {
            const nextId = routeOrder[idx + 1];
            document.getElementById('cityNextName').textContent = citiesData[nextId]?.name || nextId;
            document.getElementById('cityNext').href = `/citta/${nextId}`;
        }

        window._hasPrev = hasPrev;
        window._hasNext = hasNext;

        updateUI();
    }

    function updateUI() {
        const total = city.media.length;
        document.getElementById('slidesTrack').style.transform = `translateX(${-currentSlide * 100}vw)`;
        document.getElementById('counterCurrent').textContent = currentSlide + 1;
        document.getElementById('progressBar').style.width = `${((currentSlide + 1) / total) * 100}%`;

        document.getElementById('arrowPrev').classList.toggle('visible', currentSlide > 0);
        document.getElementById('arrowNext').classList.toggle('visible', currentSlide < total - 1);

        // Città precedente — visibile solo sulla prima slide, solo se esiste
        document.getElementById('cityPrev').classList.toggle('visible', currentSlide === 0 && window._hasPrev);
        // Città successiva — visibile solo sull'ultima slide, solo se esiste
        document.getElementById('cityNext').classList.toggle('visible', currentSlide === total - 1 && window._hasNext);
    }

    function goToSlide(index) {
        const total = city.media.length;
        if (index < 0 || index >= total) return;
        const currentVideo = document.querySelectorAll('.slide')[currentSlide]?.querySelector('video');
        if (currentVideo) currentVideo.pause();
        currentSlide = index;
        updateUI();
    }

    function changeSlide(dir) {
        goToSlide(currentSlide + dir);
    }

    // Keyboard
    document.addEventListener('keydown', e => {
        if (e.key === 'ArrowRight' || e.key === 'ArrowDown') changeSlide(1);
        if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') changeSlide(-1);
        if (e.key === 'Escape') window.location.href = '/mappa';
    });

    // Touch swipe
    let touchStartX = 0;
    document.addEventListener('touchstart', e => { touchStartX = e.touches[0].clientX; });
    document.addEventListener('touchend', e => {
        const diff = touchStartX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) changeSlide(diff > 0 ? 1 : -1);
    });

    // Scroll
    let scrollTimeout;
    document.addEventListener('wheel', e => {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => { changeSlide(e.deltaY > 0 ? 1 : -1); }, 60);
    }, { passive: true });
</script>
</body>
</html>