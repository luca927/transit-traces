<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Migrart — L'arte come incontro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=Bebas+Neue&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --ink: #1a1410;
            --paper: #f5f0e8;
            --ochre: #c26a2a;
            --warm: #e8ddd0;
            --muted: #8a7d6e;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: var(--ink);
            color: var(--paper);
            font-family: 'DM Sans', sans-serif;
            overflow-x: hidden;
            cursor: none;
        }

        /* CURSORE CUSTOM */
        .cursor {
            width: 12px; height: 12px;
            background: var(--ochre);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            transition: transform 0.15s ease;
            mix-blend-mode: difference;
        }
        .cursor-follow {
            width: 40px; height: 40px;
            border: 1px solid rgba(194,106,42,0.5);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9998;
            transition: all 0.3s ease;
        }

        /* HEADER */
        header {
            position: fixed; top: 0; left: 0; right: 0;
            padding: 2rem 3rem;
            z-index: 2000;
            display: flex; justify-content: space-between; align-items: center;
            mix-blend-mode: difference;
        }

        .logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.6rem;
            letter-spacing: 0.1em;
            color: var(--paper);
            text-decoration: none;
        }

        .logo span { color: var(--ochre); }

        .lang-btns { display: flex; gap: 0; }
        .lang-btn {
            background: none; border: none;
            color: var(--paper); opacity: 0.4;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.75rem; letter-spacing: 0.15em;
            text-transform: uppercase; cursor: none; padding: 6px 12px;
            transition: opacity 0.3s;
        }
        .lang-btn.active { opacity: 1; border-bottom: 1px solid var(--ochre); }

        /* =====================
           HERO
        ===================== */
        .hero {
            height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
            position: relative;
        }

        .hero-left {
            display: flex; flex-direction: column;
            justify-content: flex-end; padding: 6rem 4rem;
            position: relative; z-index: 2;
        }

        .hero-eyebrow {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.7rem; letter-spacing: 0.3em;
            text-transform: uppercase; color: var(--ochre);
            margin-bottom: 2rem;
            opacity: 0;
            animation: fadeUp 1s 0.3s forwards;
        }

        .hero-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(5rem, 10vw, 9rem);
            line-height: 0.85;
            letter-spacing: 0.02em;
            color: var(--paper);
            opacity: 0;
            animation: fadeUp 1s 0.5s forwards;
        }

        .hero-title em {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            color: var(--ochre);
            font-size: 0.65em;
            display: block;
            line-height: 1.2;
        }

        .hero-subtitle {
            margin-top: 2.5rem;
            font-size: 1rem; line-height: 1.7;
            color: var(--muted); max-width: 380px;
            opacity: 0;
            animation: fadeUp 1s 0.7s forwards;
        }

        .hero-right {
            position: relative; overflow: hidden;
        }

        .hero-img-placeholder {
            width: 100%; height: 100%;
            background: linear-gradient(135deg, #2a2018 0%, #1a1410 50%, #0d0b08 100%);
            display: flex; align-items: center; justify-content: center;
            position: relative;
        }

        .hero-img-placeholder::before {
            content: '';
            position: absolute; inset: 0;
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 40px,
                rgba(194,106,42,0.03) 40px,
                rgba(194,106,42,0.03) 41px
            );
        }

        .placeholder-label {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic; font-size: 1rem;
            color: rgba(194,106,42,0.3);
            letter-spacing: 0.1em;
            text-align: center; padding: 2rem;
        }

        /* Linea verticale decorativa */
        .hero-divider {
            position: absolute;
            left: 50%; top: 15%; bottom: 15%;
            width: 1px;
            background: linear-gradient(to bottom, transparent, var(--ochre), transparent);
            opacity: 0.3; z-index: 3;
        }

        /* Numero decorativo */
        .hero-number {
            position: absolute; bottom: 3rem; right: 3rem;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 8rem; line-height: 1;
            color: rgba(194,106,42,0.08);
            pointer-events: none; z-index: 1;
        }

        /* =====================
           INTRO TEXT
        ===================== */
        .intro-section {
            background: var(--paper);
            color: var(--ink);
            padding: 8rem 0;
            position: relative; overflow: hidden;
        }

        .intro-section::before {
            content: 'MIGRART';
            position: absolute; top: -2rem; left: -1rem;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 18rem; line-height: 1;
            color: rgba(26,20,16,0.04);
            pointer-events: none; white-space: nowrap;
        }

        .intro-inner {
            max-width: 780px; margin: 0 auto;
            padding: 0 3rem; position: relative; z-index: 2;
        }

        .section-label {
            font-size: 0.7rem; letter-spacing: 0.3em;
            text-transform: uppercase; color: var(--ochre);
            margin-bottom: 2rem; display: block;
        }

        .intro-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(1.8rem, 3vw, 2.6rem);
            line-height: 1.4; font-weight: 300;
            color: var(--ink);
        }

        .intro-text em { font-style: italic; color: var(--ochre); }

        /* =====================
           TEAM PHOTO
        ===================== */
        .team-section {
            background: var(--paper);
            padding: 0 0 8rem 0;
        }

        .team-photo-wrap {
            width: 100%; max-width: 1100px;
            margin: 0 auto; padding: 0 3rem;
        }

        .team-photo-placeholder {
            width: 100%; aspect-ratio: 16/7;
            background: linear-gradient(135deg, #e0d8cc, #c8bfb0);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            position: relative; overflow: hidden;
        }

        .team-photo-placeholder::after {
            content: '';
            position: absolute; inset: 0;
            background: repeating-linear-gradient(
                -45deg,
                transparent, transparent 20px,
                rgba(194,106,42,0.05) 20px,
                rgba(194,106,42,0.05) 21px
            );
        }

        .placeholder-icon {
            font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;
        }

        .placeholder-text {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic; font-size: 1.1rem;
            color: var(--muted); letter-spacing: 0.05em;
        }

        /* INPUT FILE NASCOSTO */
        .upload-overlay {
            position: absolute; inset: 0;
            display: flex; align-items: center; justify-content: center;
            flex-direction: column; gap: 1rem;
            background: rgba(194,106,42,0.1);
            opacity: 0; transition: opacity 0.3s;
            cursor: pointer; z-index: 5;
        }

        .team-photo-placeholder:hover .upload-overlay { opacity: 1; }

        .upload-overlay span {
            font-size: 0.75rem; letter-spacing: 0.2em;
            text-transform: uppercase; color: var(--ochre);
        }

        /* =====================
           CARDS (3 temi)
        ===================== */
        .cards-section {
            background: var(--ink);
            padding: 8rem 0;
        }

        .cards-header {
            padding: 0 3rem; margin-bottom: 4rem;
            display: flex; justify-content: space-between; align-items: flex-end;
        }

        .cards-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(3rem, 6vw, 5rem);
            line-height: 0.9; color: var(--paper);
        }

        .cards-title em {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic; color: var(--ochre);
            display: block;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr;
            gap: 2px; padding: 0 3rem;
        }

        .card {
            position: relative; overflow: hidden;
            aspect-ratio: 3/4;
            background: #1a1410;
        }

        .card:first-child { aspect-ratio: unset; }

        .card-bg {
            position: absolute; inset: 0;
            background-size: cover; background-position: center;
            filter: brightness(0.35) contrast(1.1);
            transition: filter 1s ease, transform 1.2s ease;
        }

        .card:hover .card-bg {
            filter: brightness(0.6) contrast(1);
            transform: scale(1.04);
        }

        .card-content {
            position: absolute; inset: 0;
            display: flex; flex-direction: column;
            justify-content: flex-end; padding: 2.5rem;
        }

        .card-num {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 5rem; line-height: 1;
            color: rgba(194,106,42,0.15);
            position: absolute; top: 1.5rem; right: 1.5rem;
        }

        .card-tag {
            font-size: 0.65rem; letter-spacing: 0.25em;
            text-transform: uppercase; color: var(--ochre);
            margin-bottom: 0.8rem; display: block;
        }

        .card-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem; line-height: 1.1;
            font-weight: 300; color: var(--paper);
            margin-bottom: 1rem;
        }

        .card-desc {
            font-size: 0.9rem; line-height: 1.6;
            color: rgba(245,240,232,0.6);
            max-width: 280px;
        }

        .card-line {
            width: 0; height: 1px;
            background: var(--ochre);
            margin-top: 1.5rem;
            transition: width 0.5s ease;
        }

        .card:hover .card-line { width: 40px; }

        /* =====================
           VIDEO SECTION
        ===================== */
        .video-section {
            background: var(--ink);
            padding: 2rem 3rem 8rem;
        }

        .video-label {
            font-size: 0.7rem; letter-spacing: 0.3em;
            text-transform: uppercase; color: var(--ochre);
            margin-bottom: 2rem; display: block;
        }

        .video-wrap {
            width: 100%; max-width: 1100px; margin: 0 auto;
            position: relative;
        }

        .video-placeholder {
            width: 100%; aspect-ratio: 16/9;
            background: #0d0b08;
            border: 1px solid rgba(194,106,42,0.2);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            position: relative; overflow: hidden;
            cursor: pointer;
        }

        .video-placeholder video {
            position: absolute; inset: 0;
            width: 100%; height: 100%;
            object-fit: cover; display: none;
        }

        .play-btn {
            width: 80px; height: 80px;
            border: 1px solid rgba(194,106,42,0.5);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.4s ease; margin-bottom: 1.5rem;
        }

        .play-btn i { color: var(--ochre); font-size: 1.5rem; margin-left: 4px; }
        .video-placeholder:hover .play-btn {
            background: var(--ochre); border-color: var(--ochre);
            transform: scale(1.1);
        }
        .video-placeholder:hover .play-btn i { color: white; }

        .video-placeholder-text {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic; font-size: 1.1rem;
            color: rgba(245,240,232,0.3);
        }

        /* =====================
           CTA MAPPA
        ===================== */
        .cta-section {
            background: var(--ochre);
            padding: 8rem 3rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center; gap: 4rem;
        }

        .cta-left h2 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(3.5rem, 7vw, 6rem);
            line-height: 0.85; color: var(--ink);
        }

        .cta-left h2 em {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic; display: block;
            color: rgba(26,20,16,0.5);
        }

        .cta-right {
            display: flex; flex-direction: column;
            align-items: flex-start; gap: 2rem;
        }

        .cta-desc {
            font-size: 1.1rem; line-height: 1.7;
            color: rgba(26,20,16,0.7); max-width: 420px;
        }

        .btn-map {
            display: inline-flex; align-items: center; gap: 1rem;
            background: var(--ink); color: var(--paper);
            padding: 18px 40px; text-decoration: none;
            font-size: 0.8rem; letter-spacing: 0.2em;
            text-transform: uppercase; font-weight: 500;
            transition: all 0.4s ease;
        }

        .btn-map:hover {
            background: var(--paper); color: var(--ink);
            gap: 1.5rem;
        }

        .btn-map i { font-size: 0.9rem; }

        /* =====================
           FOOTER
        ===================== */
        footer {
            background: #0d0b08;
            padding: 5rem 3rem 2rem;
        }

        .footer-top {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 4rem; padding-bottom: 4rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .footer-brand h2 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2rem; letter-spacing: 0.05em;
            margin-bottom: 1rem;
        }

        .footer-brand h2 span { color: var(--ochre); }

        .footer-brand p {
            font-size: 0.9rem; line-height: 1.7;
            color: var(--muted);
        }

        .footer-col h3 {
            font-size: 0.65rem; letter-spacing: 0.25em;
            text-transform: uppercase; color: var(--paper);
            margin-bottom: 1.5rem; font-weight: 500;
        }

        .footer-col a {
            display: block; color: var(--muted);
            text-decoration: none; font-size: 0.9rem;
            margin-bottom: 0.8rem; transition: color 0.3s;
        }

        .footer-col a:hover { color: var(--ochre); }

        .footer-bottom {
            padding-top: 2rem;
            display: flex; justify-content: space-between;
            align-items: center; flex-wrap: wrap; gap: 1rem;
        }

        .footer-bottom p { font-size: 0.8rem; color: rgba(138,125,110,0.5); }

        /* SOCIALS */
        .social-links { display: flex; gap: 1.5rem; }
        .social-links a {
            color: var(--muted); font-size: 0.9rem;
            transition: color 0.3s;
        }
        .social-links a:hover { color: var(--ochre); }

        /* =====================
           ANIMATIONS
        ===================== */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .reveal {
            opacity: 0; transform: translateY(40px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .hero { grid-template-columns: 1fr; }
            .hero-right { display: none; }
            .hero-divider { display: none; }
            .cards-grid { grid-template-columns: 1fr; }
            .card:first-child { aspect-ratio: 3/4; }
            .cta-section { grid-template-columns: 1fr; }
            .footer-top { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

<div class="cursor" id="cursor"></div>
<div class="cursor-follow" id="cursorFollow"></div>

<!-- HEADER -->
<header>
    <a href="/" class="logo"><span>Migr</span>art</a>
    <div class="lang-btns">
        <button class="lang-btn active" id="btn-it" onclick="setLanguage('it')">IT</button>
        <button class="lang-btn" id="btn-en" onclick="setLanguage('en')">EN</button>
    </div>
</header>

<!-- HERO -->
<section class="hero">
    <div class="hero-left">
        <p class="hero-eyebrow" id="hero-eyebrow">Progetto artistico · Rotta balcanica</p>
        <h1 class="hero-title">
            Migr<br>art
            <em id="hero-subtitle-title">L'arte come incontro</em>
        </h1>
        <p class="hero-subtitle" id="hero-desc">
            Un viaggio attraverso la rotta balcanica dove arte e migrazione si incontrano, 
            trasformando il percorso in un atto creativo collettivo.
        </p>
    </div>
    <div class="hero-right">
        <div class="hero-img-placeholder">
            <p class="placeholder-label" id="hero-img-label">Foto di copertina<br>da inserire</p>
        </div>
    </div>
    <div class="hero-divider"></div>
    <div class="hero-number">01</div>
</section>

<!-- INTRO -->
<section class="intro-section reveal">
    <div class="intro-inner">
        <span class="section-label" id="intro-label">Il Progetto</span>
        <p class="intro-text" id="intro-text">
            <em>Migrart</em> è un progetto artistico che accompagna i migranti lungo la rotta balcanica, 
            trasformando ogni tappa del viaggio in un'opera collettiva. 
            Arte, testimonianza e incontro come strumenti di umanità.
        </p>
    </div>
</section>

<!-- FOTO TEAM -->
<section class="team-section reveal">
    <div class="team-photo-wrap">
        <span class="section-label" style="color: var(--ochre); padding-bottom: 1.5rem; display: block;" id="team-label">Il Team</span>
        <div class="team-photo-placeholder" id="teamPhotoWrap">
            <div class="placeholder-icon">👥</div>
            <p class="placeholder-text" id="team-placeholder-text">Foto del team — da inserire</p>
            <div class="upload-overlay" onclick="document.getElementById('teamPhotoInput').click()">
                <i class="fas fa-upload" style="color: var(--ochre); font-size: 1.5rem;"></i>
                <span>Carica foto team</span>
            </div>
            <input type="file" id="teamPhotoInput" accept="image/*" style="display:none" onchange="loadTeamPhoto(this)">
            <img id="teamPhotoImg" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;display:none;" alt="Team Migrart">
        </div>
    </div>
</section>

<!-- CARDS 3 TEMI -->
<section class="cards-section">
    <div class="cards-header reveal">
        <h2 class="cards-title" id="cards-title">
            Il<br>Viaggio
            <em id="cards-subtitle">In tre atti</em>
        </h2>
        <div class="social-links">
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
        </div>
    </div>
    <div class="cards-grid">
        <div class="card reveal">
            <div class="card-bg" id="card-bg-1" style="background-image: url('https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=800');"></div>
            <div class="card-content">
                <span class="card-num">01</span>
                <span class="card-tag" id="card-tag-1">Partenza</span>
                <h3 class="card-title" id="card-title-1">Le Origini del Cammino</h3>
                <p class="card-desc" id="card-desc-1">Da Istanbul a Izmir, i primi passi di un viaggio che trasforma chi lo compie.</p>
                <div class="card-line"></div>
            </div>
        </div>
        <div class="card reveal">
            <div class="card-bg" id="card-bg-2" style="background-image: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800');"></div>
            <div class="card-content">
                <span class="card-num">02</span>
                <span class="card-tag" id="card-tag-2">Attraversamento</span>
                <h3 class="card-title" id="card-title-2">Tra Frontiere e Incontri</h3>
                <p class="card-desc" id="card-desc-2">Grecia, Bulgaria, Bosnia: l'arte nasce nei campi e nelle città di transito.</p>
                <div class="card-line"></div>
            </div>
        </div>
        <div class="card reveal">
            <div class="card-bg" id="card-bg-3" style="background-image: url('https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=800');"></div>
            <div class="card-content">
                <span class="card-num">03</span>
                <span class="card-tag" id="card-tag-3">Arrivo</span>
                <h3 class="card-title" id="card-title-3">La Meta e il Nuovo Inizio</h3>
                <p class="card-desc" id="card-desc-3">Trieste: la fine del percorso, l'inizio di una nuova storia.</p>
                <div class="card-line"></div>
            </div>
        </div>
    </div>
</section>

<!-- VIDEO -->
<section class="video-section">
    <div class="video-wrap">
        <span class="video-label" id="video-label">Video del Progetto</span>
        <div class="video-placeholder" id="videoWrap" onclick="playOrUploadVideo()">
            <video id="projectVideo" controls></video>
            <div id="videoPlaceholderContent" style="display:flex;flex-direction:column;align-items:center;">
                <div class="play-btn"><i class="fas fa-play"></i></div>
                <p class="video-placeholder-text" id="video-placeholder-text">Video introduttivo — da inserire</p>
                <p style="margin-top:1rem;font-size:0.7rem;letter-spacing:0.2em;text-transform:uppercase;color:rgba(194,106,42,0.4);" id="video-upload-hint">Clicca per caricare il video</p>
            </div>
            <input type="file" id="videoInput" accept="video/*" style="display:none" onchange="loadVideo(this)">
        </div>
    </div>
</section>

<!-- CTA MAPPA -->
<section class="cta-section reveal">
    <div class="cta-left">
        <h2 id="cta-title">
            Esplora<br>la Mappa
            <em id="cta-subtitle">Il tragitto completo</em>
        </h2>
    </div>
    <div class="cta-right">
        <p class="cta-desc" id="cta-desc">
            Segui il percorso di Migrart sulla rotta balcanica. 
            Clicca sulle tappe per scoprire le opere, le storie e gli incontri nati lungo il viaggio.
        </p>
        <a href="/mappa" class="btn-map" id="cta-btn">
            <span id="cta-btn-text">Entra nella Mappa</span>
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="footer-top">
        <div class="footer-brand">
            <h2><span>Migr</span>art</h2>
            <p id="footer-desc">Un progetto artistico che accompagna i migranti lungo la rotta balcanica, trasformando ogni tappa in un'opera collettiva.</p>
        </div>
        <div class="footer-col">
            <h3 id="footer-nav-title">Esplora</h3>
            <a href="/mappa" id="footer-link-map">La Mappa</a>
            <a href="/storie" id="footer-link-stories">Storie</a>
            <a href="/chi-siamo" id="footer-link-about">Chi Siamo</a>
            <a href="/contatti" id="footer-link-contact">Contatti</a>
        </div>
        <div class="footer-col">
            <h3 id="footer-follow-title">Seguici</h3>
            <a href="#"><i class="fab fa-instagram" style="margin-right:8px"></i>Instagram</a>
            <a href="#"><i class="fab fa-facebook-f" style="margin-right:8px"></i>Facebook</a>
            <a href="#"><i class="fab fa-twitter" style="margin-right:8px"></i>Twitter</a>
        </div>
        <div class="footer-col">
            <h3 id="footer-support-title">Supporta</h3>
            <a href="/supporta" id="footer-link-donate">Fai una donazione</a>
            <a href="/partner" id="footer-link-partner">Diventa partner</a>
        </div>
    </div>
    <div class="footer-bottom">
        <p id="footer-copy">© 2024 Migrart. Tutti i diritti riservati.</p>
        <nav style="display:flex;gap:2rem;">
            <a href="/privacy" style="color:rgba(138,125,110,0.5);text-decoration:none;font-size:0.8rem;" id="footer-privacy">Privacy</a>
            <a href="/termini" style="color:rgba(138,125,110,0.5);text-decoration:none;font-size:0.8rem;" id="footer-terms">Termini</a>
        </nav>
    </div>
</footer>

<script>
    // CURSORE CUSTOM
    const cursor = document.getElementById('cursor');
    const cursorFollow = document.getElementById('cursorFollow');
    let mouseX = 0, mouseY = 0, followX = 0, followY = 0;

    document.addEventListener('mousemove', e => {
        mouseX = e.clientX; mouseY = e.clientY;
        cursor.style.left = mouseX - 6 + 'px';
        cursor.style.top = mouseY - 6 + 'px';
    });

    function animateCursor() {
        followX += (mouseX - followX) * 0.1;
        followY += (mouseY - followY) * 0.1;
        cursorFollow.style.left = followX - 20 + 'px';
        cursorFollow.style.top = followY - 20 + 'px';
        requestAnimationFrame(animateCursor);
    }
    animateCursor();

    // SCROLL REVEAL
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver(entries => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => entry.target.classList.add('visible'), i * 100);
            }
        });
    }, { threshold: 0.1 });
    reveals.forEach(el => observer.observe(el));

    // CARICA FOTO TEAM
    function loadTeamPhoto(input) {
        if (!input.files[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById('teamPhotoImg');
            img.src = e.target.result;
            img.style.display = 'block';
            document.querySelector('.placeholder-icon').style.display = 'none';
            document.getElementById('team-placeholder-text').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }

    // CARICA/PLAY VIDEO
    function playOrUploadVideo() {
        const video = document.getElementById('projectVideo');
        if (video.src && video.src !== window.location.href) {
            // video già caricato, non fare nulla (i controls gestiscono il play)
            return;
        }
        document.getElementById('videoInput').click();
    }

    function loadVideo(input) {
        if (!input.files[0]) return;
        const url = URL.createObjectURL(input.files[0]);
        const video = document.getElementById('projectVideo');
        video.src = url;
        video.style.display = 'block';
        document.getElementById('videoPlaceholderContent').style.display = 'none';
        video.play();
    }

    // LINGUA
    const translations = {
        it: {
            'hero-eyebrow': 'Progetto artistico · Rotta balcanica',
            'hero-subtitle-title': "L'arte come incontro",
            'hero-desc': 'Un viaggio attraverso la rotta balcanica dove arte e migrazione si incontrano, trasformando il percorso in un atto creativo collettivo.',
            'intro-label': 'Il Progetto',
            'intro-text-html': '<em>Migrart</em> è un progetto artistico che accompagna i migranti lungo la rotta balcanica, trasformando ogni tappa del viaggio in un\'opera collettiva. Arte, testimonianza e incontro come strumenti di umanità.',
            'team-label': 'Il Team',
            'team-placeholder-text': 'Foto del team — da inserire',
            'cards-title-html': 'Il<br>Viaggio',
            'cards-subtitle': 'In tre atti',
            'card-tag-1': 'Partenza', 'card-title-1': 'Le Origini del Cammino', 'card-desc-1': 'Da Istanbul a Izmir, i primi passi di un viaggio che trasforma chi lo compie.',
            'card-tag-2': 'Attraversamento', 'card-title-2': 'Tra Frontiere e Incontri', 'card-desc-2': 'Grecia, Bulgaria, Bosnia: l\'arte nasce nei campi e nelle città di transito.',
            'card-tag-3': 'Arrivo', 'card-title-3': 'La Meta e il Nuovo Inizio', 'card-desc-3': 'Trieste: la fine del percorso, l\'inizio di una nuova storia.',
            'video-label': 'Video del Progetto',
            'video-placeholder-text': 'Video introduttivo — da inserire',
            'video-upload-hint': 'Clicca per caricare il video',
            'cta-title-html': 'Esplora<br>la Mappa',
            'cta-subtitle': 'Il tragitto completo',
            'cta-desc': 'Segui il percorso di Migrart sulla rotta balcanica. Clicca sulle tappe per scoprire le opere, le storie e gli incontri nati lungo il viaggio.',
            'cta-btn-text': 'Entra nella Mappa',
            'footer-desc': 'Un progetto artistico che accompagna i migranti lungo la rotta balcanica, trasformando ogni tappa in un\'opera collettiva.',
            'footer-nav-title': 'Esplora', 'footer-follow-title': 'Seguici', 'footer-support-title': 'Supporta',
            'footer-copy': '© 2024 Migrart. Tutti i diritti riservati.',
            'footer-privacy': 'Privacy', 'footer-terms': 'Termini',
        },
        en: {
            'hero-eyebrow': 'Artistic project · Balkan route',
            'hero-subtitle-title': 'Art as encounter',
            'hero-desc': 'A journey along the Balkan route where art and migration meet, transforming the path into a collective creative act.',
            'intro-label': 'The Project',
            'intro-text-html': '<em>Migrart</em> is an artistic project accompanying migrants along the Balkan route, transforming each stage of the journey into a collective work. Art, testimony and encounter as instruments of humanity.',
            'team-label': 'The Team',
            'team-placeholder-text': 'Team photo — to be added',
            'cards-title-html': 'The<br>Journey',
            'cards-subtitle': 'In three acts',
            'card-tag-1': 'Departure', 'card-title-1': 'The Origins of the Path', 'card-desc-1': 'From Istanbul to Izmir, the first steps of a journey that transforms those who take it.',
            'card-tag-2': 'Crossing', 'card-title-2': 'Between Borders and Encounters', 'card-desc-2': 'Greece, Bulgaria, Bosnia: art is born in the camps and transit cities.',
            'card-tag-3': 'Arrival', 'card-title-3': 'The Destination and New Beginning', 'card-desc-3': 'Trieste: the end of the journey, the beginning of a new story.',
            'video-label': 'Project Video',
            'video-placeholder-text': 'Introductory video — to be added',
            'video-upload-hint': 'Click to upload video',
            'cta-title-html': 'Explore<br>the Map',
            'cta-subtitle': 'The complete route',
            'cta-desc': 'Follow Migrart\'s journey along the Balkan route. Click on each stop to discover the artworks, stories and encounters born along the way.',
            'cta-btn-text': 'Enter the Map',
            'footer-desc': 'An artistic project accompanying migrants along the Balkan route, transforming each stage into a collective work.',
            'footer-nav-title': 'Explore', 'footer-follow-title': 'Follow us', 'footer-support-title': 'Support',
            'footer-copy': '© 2024 Migrart. All rights reserved.',
            'footer-privacy': 'Privacy', 'footer-terms': 'Terms',
        }
    };

    function setLanguage(lang) {
        const t = translations[lang];
        document.getElementById('btn-it').classList.toggle('active', lang === 'it');
        document.getElementById('btn-en').classList.toggle('active', lang === 'en');

        // Aggiorna testi
        for (const [id, val] of Object.entries(t)) {
            const el = document.getElementById(id);
            if (!el) continue;
            if (id.endsWith('-html')) {
                el.innerHTML = val;
            } else {
                el.textContent = val;
            }
        }

        // Casi speciali con innerHTML
        document.getElementById('intro-text').innerHTML = t['intro-text-html'];
        document.getElementById('cards-title').innerHTML = t['cards-title-html'] + `<em id="cards-subtitle">${t['cards-subtitle']}</em>`;
        document.getElementById('cta-title').innerHTML = t['cta-title-html'] + `<em id="cta-subtitle">${t['cta-subtitle']}</em>`;
    }

    setLanguage('it');
</script>
</body>
</html>