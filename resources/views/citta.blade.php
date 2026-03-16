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

        /* GALLERIA FULLSCREEN */
        .gallery {
            position: fixed; inset: 0;
            background: #000;
        }

        /* SLIDE */
        .slide {
            position: absolute; inset: 0;
            display: flex; align-items: center; justify-content: center;
            opacity: 0;
            transition: opacity 0.6s ease;
            pointer-events: none;
        }

        .slide.active {
            opacity: 1;
            pointer-events: all;
        }

        /* FOTO */
        .slide-photo img {
            width: 100vw; height: 100vh;
            object-fit: cover;
        }

        .slide-photo-placeholder {
            width: 100vw; height: 100vh;
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
            width: 100vw; height: 100vh;
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

        /* OVERLAY */
        .slide-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(
                to top,
                rgba(0,0,0,0.8) 0%,
                transparent 40%,
                transparent 60%,
                rgba(0,0,0,0.4) 100%
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

        .slide-caption {
            margin-top: 0.8rem;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic; font-size: 1.1rem;
            color: rgba(245,240,232,0.6);
            max-width: 500px; line-height: 1.5;
        }

        /* COUNTER */
        .slide-counter {
            position: absolute;
            bottom: 5rem; right: 4rem;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1rem; letter-spacing: 0.1em;
            color: rgba(245,240,232,0.3);
            z-index: 10;
        }
        .slide-counter span { color: var(--paper); }

        .slide-type {
            position: absolute;
            top: 5rem; right: 4rem;
            font-size: 0.65rem; letter-spacing: 0.25em;
            text-transform: uppercase;
            color: rgba(245,240,232,0.3);
            z-index: 10;
        }

        /* FRECCE */
        .nav-arrow {
            position: fixed;
            top: 50%; transform: translateY(-50%);
            z-index: 100;
            background: none; border: none;
            cursor: pointer; padding: 1.5rem;
            opacity: 0.3; transition: opacity 0.3s;
        }
        .nav-arrow:hover { opacity: 1; }
        .nav-arrow.prev { left: 1rem; }
        .nav-arrow.next { right: 1rem; }
        .nav-arrow i { color: var(--paper); font-size: 1.5rem; }

        /* DOTS */
        .nav-dots {
            position: fixed;
            bottom: 2rem; left: 50%; transform: translateX(-50%);
            display: flex; gap: 8px; z-index: 100;
        }

        .dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: rgba(245,240,232,0.3);
            cursor: pointer; transition: all 0.3s;
            border: none; padding: 0;
        }

        .dot.active {
            background: var(--ochre);
            width: 20px; border-radius: 3px;
        }

        /* HEADER */
        .page-header {
            position: fixed; top: 0; left: 0; right: 0;
            padding: 1.5rem 3rem;
            z-index: 200;
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

        /* STORIA */
        .story-panel {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.97) 70%, transparent);
            padding: 6rem 4rem 3rem;
            transform: translateY(100%);
            transition: transform 0.5s cubic-bezier(0.19, 1, 0.22, 1);
            z-index: 150;
        }
        .story-panel.open { transform: translateY(0); }

        .story-panel p {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem; line-height: 1.8;
            font-weight: 300; max-width: 700px;
            color: var(--paper); white-space: pre-line;
        }

        .story-toggle {
            position: fixed;
            bottom: 2rem; left: 4rem;
            z-index: 200;
            background: none;
            border: 1px solid rgba(245,240,232,0.2);
            color: rgba(245,240,232,0.4);
            padding: 8px 16px; cursor: pointer;
            font-size: 0.7rem; letter-spacing: 0.15em;
            text-transform: uppercase; transition: all 0.3s;
            font-family: 'DM Sans', sans-serif;
        }
        .story-toggle:hover { border-color: var(--ochre); color: var(--ochre); }

        /* PREV/NEXT CITTÀ */
        .city-prev, .city-next {
            position: fixed; top: 50%;
            z-index: 200;
            font-size: 0.65rem; letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgba(245,240,232,0.3);
            text-decoration: none;
            transition: color 0.3s;
            writing-mode: vertical-rl;
        }
        .city-prev { left: 0.3rem; transform: translateY(-50%) rotate(180deg); }
        .city-next { right: 0.3rem; transform: translateY(-50%); }
        .city-prev:hover, .city-next:hover { color: var(--ochre); }
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

<div class="gallery" id="gallery"></div>

<button class="nav-arrow prev" onclick="changeSlide(-1)">
    <i class="fas fa-chevron-left"></i>
</button>
<button class="nav-arrow next" onclick="changeSlide(1)">
    <i class="fas fa-chevron-right"></i>
</button>

<div class="nav-dots" id="navDots"></div>

<button class="story-toggle" id="storyToggle" onclick="toggleStory()">
    <i class="fas fa-quote-left" style="margin-right:6px"></i>
    <span id="storyToggleText">Leggi la storia</span>
</button>

<div class="story-panel" id="storyPanel">
    <p id="storyText"></p>
</div>

<a href="#" class="city-prev" id="cityPrev" style="display:none"></a>
<a href="#" class="city-next" id="cityNext" style="display:none"></a>

<script>
    const citiesData = {
        istanbul: {
            name: 'Istanbul', country: 'Turchia', date: '',
            story: '',
            media: [
                { type: 'photo', src: '', caption: '' },
                { type: 'photo', src: '', caption: '' },
            ]
        },
        izmir: {
            name: 'Izmir', country: 'Turchia', date: '',
            story: '',
            media: [
                { type: 'photo', src: '', caption: '' },
            ]
        },
        lesvos: {
            name: 'Lesvos', country: 'Grecia', date: '5 Marzo 2024',
            story: `Lesvos è diventata simbolo della crisi migratoria europea. 
Questa isola greca dell'Egeo, a pochi chilometri dalla Turchia, ha accolto centinaia di migliaia di rifugiati che attraversano il mare su gommoni pericolanti.
Il campo di Moria, ora chiuso, era il più grande campo profughi d'Europa.`,
            media: [
                { type: 'photo', src: '', caption: 'Le spiagge di Lesvos' },
                { type: 'photo', src: '', caption: 'Il campo di Moria' },
                { type: 'video', src: '', caption: 'Video — Lesvos' },
            ]
        },
        idomeni: {
            name: 'Idomeni', country: 'Grecia', date: '',
            story: '',
            media: [
                { type: 'photo', src: '/images/interno5.png', caption: '' },
                { type: 'photo', src: '/images/interno6.png', caption: '' },
                { type: 'video', src: '', caption: 'Video — Idomeni' },
            ]
        },
        dimitrovgrad: {
            name: 'Dimitrovgrad', country: 'Serbia', date: '',
            story: '',
            media: [
                { type: 'photo', src: '', caption: '' },
            ]
        },
        harmanli: {
            name: 'Harmanli', country: 'Bulgaria', date: '10 Marzo 2024',
            story: `Harmanli ospita uno dei più grandi centri di accoglienza per migranti della Bulgaria.
Situato vicino al confine turco, questo centro è spesso il primo punto di arrivo in Europa per chi proviene dal Medio Oriente e dall'Asia.`,
            media: [
                { type: 'photo', src: '', caption: 'Centro di accoglienza' },
                { type: 'video', src: '', caption: 'Video — Harmanli' },
            ]
        },
        srebrenica: {
            name: 'Srebrenica', country: 'Bosnia ed Erzegovina', date: '',
            story: '',
            media: [
                { type: 'photo', src: '', caption: '' },
                { type: 'photo', src: '', caption: '' },
                { type: 'video', src: '', caption: '' },
            ]
        },
        bihac: {
            name: 'Bihać', country: 'Bosnia ed Erzegovina', date: '25 Marzo 2024',
            story: `Bihać è diventata tristemente famosa come "porta d'Europa" lungo la rotta balcanica.
Qui si concentrano migliaia di migranti che aspettano per mesi di attraversare il confine croato, affrontando il pericoloso "Game" — il tentativo di attraversare illegalmente la frontiera.`,
            media: [
                { type: 'photo', src: '', caption: 'Campo profughi di Lipa' },
                { type: 'photo', src: '', caption: 'Confine croato' },
                { type: 'video', src: '', caption: 'Video — Bihać' },
            ]
        },
        sarajevo: {
            name: 'Sarajevo', country: 'Bosnia ed Erzegovina', date: '22 Marzo 2024',
            story: `Sarajevo, la "Gerusalemme d'Europa", è stata per secoli un punto d'incontro tra Oriente e Occidente. 
Durante la guerra degli anni '90, la città visse un assedio di 1.425 giorni, il più lungo nella storia moderna.
Oggi, Sarajevo è un simbolo di rinascita e convivenza.`,
            media: [
                { type: 'photo', src: '', caption: 'Baščaršija' },
                { type: 'photo', src: '', caption: 'Ponte Latino' },
                { type: 'video', src: '', caption: 'Video — Sarajevo' },
            ]
        },
        trieste: {
            name: 'Trieste', country: 'Italia', date: '',
            story: '',
            media: [
                { type: 'photo', src: '', caption: '' },
                { type: 'photo', src: '', caption: '' },
            ]
        },
    };

    const routeOrder = ['istanbul', 'izmir', 'lesvos', 'idomeni', 'dimitrovgrad', 'harmanli', 'srebrenica', 'bihac', 'sarajevo', 'trieste'];

    const cityId = "{{ $cityId }}";
    const city = citiesData[cityId];
    let currentSlide = 0;
    let storyOpen = false;

    if (city) {
        document.title = `Migrart — ${city.name}`;

        // Storia
        if (city.story) {
            document.getElementById('storyText').textContent = city.story;
        } else {
            document.getElementById('storyToggle').style.display = 'none';
        }

        // Build slides
        const gallery = document.getElementById('gallery');
        const dots = document.getElementById('navDots');
        const total = city.media.length;

        city.media.forEach((item, i) => {
            const slide = document.createElement('div');
            slide.className = `slide slide-${item.type}${i === 0 ? ' active' : ''}`;

            const infoHTML = `
                <div class="slide-info">
                    <span class="slide-country">${city.country}</span>
                    <h1 class="slide-city-name">${city.name}</h1>
                    ${item.caption ? `<p class="slide-caption">${item.caption}</p>` : ''}
                </div>
                <div class="slide-counter"><span>${i + 1}</span> / ${total}</div>
                <div class="slide-type">${item.type === 'photo' ? 'Foto' : 'Video'}</div>
            `;

            if (item.type === 'photo') {
                if (item.src) {
                    slide.innerHTML = `
                        <img src="${item.src}" alt="${item.caption}" style="width:100vw;height:100vh;object-fit:cover;">
                        <div class="slide-overlay"></div>
                        ${infoHTML}
                    `;
                } else {
                    slide.innerHTML = `
                        <div class="slide-photo-placeholder">
                            <i class="fas fa-image"></i>
                            <p>${item.caption || 'Foto — da inserire'}</p>
                        </div>
                        <div class="slide-overlay"></div>
                        ${infoHTML}
                    `;
                }
            } else if (item.type === 'video') {
                if (item.src) {
                    slide.innerHTML = `
                        <video controls style="width:100vw;height:100vh;object-fit:contain;background:#000;">
                            <source src="${item.src}" type="video/mp4">
                        </video>
                        ${infoHTML}
                    `;
                } else {
                    slide.innerHTML = `
                        <div class="slide-video-placeholder">
                            <div class="play-circle"><i class="fas fa-play"></i></div>
                            <p style="font-family:'Cormorant Garamond',serif;font-style:italic;color:rgba(245,240,232,0.3);">
                                ${item.caption || 'Video — da inserire'}
                            </p>
                        </div>
                        ${infoHTML}
                    `;
                }
            }

            gallery.appendChild(slide);

            // Dot
            const dot = document.createElement('button');
            dot.className = `dot${i === 0 ? ' active' : ''}`;
            dot.onclick = () => goToSlide(i);
            dots.appendChild(dot);
        });

        // Navigazione città prev/next
        const idx = routeOrder.indexOf(cityId);
        if (idx > 0) {
            const prevId = routeOrder[idx - 1];
            const el = document.getElementById('cityPrev');
            el.href = `/citta/${prevId}`;
            el.textContent = citiesData[prevId]?.name || prevId;
            el.style.display = 'block';
        }
        if (idx < routeOrder.length - 1) {
            const nextId = routeOrder[idx + 1];
            const el = document.getElementById('cityNext');
            el.href = `/citta/${nextId}`;
            el.textContent = citiesData[nextId]?.name || nextId;
            el.style.display = 'block';
        }
    }

    function goToSlide(index) {
        const slides = document.querySelectorAll('.slide');
        const dotEls = document.querySelectorAll('.dot');
        if (index < 0 || index >= slides.length) return;

        const currentVideo = slides[currentSlide]?.querySelector('video');
        if (currentVideo) currentVideo.pause();

        slides[currentSlide].classList.remove('active');
        dotEls[currentSlide].classList.remove('active');
        currentSlide = index;
        slides[currentSlide].classList.add('active');
        dotEls[currentSlide].classList.add('active');
    }

    function changeSlide(dir) {
        const total = document.querySelectorAll('.slide').length;
        let next = currentSlide + dir;
        if (next < 0) next = total - 1;
        if (next >= total) next = 0;
        goToSlide(next);
    }

    function toggleStory() {
        storyOpen = !storyOpen;
        document.getElementById('storyPanel').classList.toggle('open', storyOpen);
        document.getElementById('storyToggleText').textContent = storyOpen ? 'Chiudi' : 'Leggi la storia';
    }

    // Keyboard
    document.addEventListener('keydown', e => {
        if (e.key === 'ArrowRight' || e.key === 'ArrowDown') changeSlide(1);
        if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') changeSlide(-1);
        if (e.key === 'Escape') { if (storyOpen) toggleStory(); else window.location.href = '/mappa'; }
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
        scrollTimeout = setTimeout(() => { changeSlide(e.deltaY > 0 ? 1 : -1); }, 50);
    });
</script>
</body>
</html>