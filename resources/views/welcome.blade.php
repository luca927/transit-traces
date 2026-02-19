<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transit Traces : Domiz Camp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,900;1,900&family=Inter:wght@300;400;700&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body { 
            background-color: #0d0b0a; 
            color: #e2d9d0; 
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        header {
            position: fixed; top: 0; left: 0; right: 0; 
            padding: 2rem; z-index: 2000; 
            display: flex; justify-content: space-between; align-items: center;
            background: linear-gradient(to bottom, rgba(0,0,0,0.7), transparent);
        }

        .language-switcher a {
            color: white; text-decoration: none; padding: 0.6rem 1.2rem;
            font-size: 0.8rem; border: 1px solid rgba(255,255,255,0.3);
            transition: 0.3s; font-weight: bold; letter-spacing: 1px;
        }

        .hero {
            height: 100vh;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            text-align: center;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(13,11,10,1)), 
                        url('https://images.unsplash.com/photo-1473679408190-0693dd22fe6a?q=80&w=2000');
            background-size: cover; background-position: center;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3.5rem, 12vw, 8rem);
            font-weight: 900; line-height: 0.8; margin-bottom: 2rem; color: #fff;
        }

        .btn-orange {
            background-color: #ff7e00; color: white; padding: 20px 50px;
            border: none; border-radius: 5px; font-weight: 700;
            font-size: 1rem; letter-spacing: 2px; text-transform: uppercase;
            text-decoration: none; cursor: pointer; transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-orange:hover {
            background-color: #e66a00; transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 126, 0, 0.4);
        }

        .card-container {
            display: flex; width: 100%; height: 85vh; 
            background: #000; overflow: hidden; border-top: 1px solid rgba(255,255,255,0.1);
        }

        .card-item {
            flex: 1; position: relative; display: flex;
            flex-direction: column; justify-content: flex-end;
            padding: 50px; transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            border-right: 1px solid rgba(255,255,255,0.1);
        }

        .card-item:hover { flex: 1.6; }

        .card-bg {
            position: absolute; inset: 0; background-size: cover; background-position: center;
            filter: brightness(0.4) contrast(1.2); transition: 1s; z-index: 0;
        }

        .card-item:hover .card-bg { filter: brightness(0.7) contrast(1); transform: scale(1.05); }

        .card-info { position: relative; z-index: 2; }
        .card-tag { color: #c4a47c; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 4px; display: block; margin-bottom: 10px;}
        .card-title-text { font-family: 'Playfair Display', serif; font-size: 2.8rem; line-height: 1; margin-bottom: 15px; }

        .intro { padding: 120px 20px; text-align: center; max-width: 900px; margin: 0 auto; }
        .intro h2 { font-family: 'Playfair Display'; font-size: 3.5rem; margin-bottom: 30px; }
        .intro p { font-size: 1.4rem; line-height: 1.8; color: #aaa; }
    </style>
</head>
<body>

<header>
    <div style="display: flex; gap: 15px;">
        <a href="https://facebook.com/transittraces" target="_blank" style="color: white; opacity: 0.7;"><i class="fab fa-facebook-f"></i></a>
        <a href="https://twitter.com/transittraces" target="_blank" style="color: white; opacity: 0.7;"><i class="fab fa-twitter"></i></a>
    </div>
    <div class="language-switcher">
        <a href="#" id="btn-it" onclick="setLanguage('it'); return false;">ITALIANO</a>
        <a href="#" id="btn-en" onclick="setLanguage('en'); return false;">ENGLISH</a>
    </div>
</header>

<section class="hero">
    <h1 id="hero-title">Transit<br>Traces</h1>
    <p id="hero-desc" style="max-width: 600px; margin-bottom: 3rem; font-size: 1.2rem; color: #ccc;">
        Tracce quotidiane nel campo profughi di Domiz, Iraq del Nord.
    </p>
    <a href="#map" class="btn-orange" id="hero-cta">Esplora il Sito</a>
</section>

<section class="intro">
    <h2 id="intro-title">Benvenuti</h2>
    <p id="intro-text">Un documentario interattivo sulla vita quotidiana nel campo profughi siriano di Domiz. Con circa 64.000 rifugiati, Domiz è diventata una mini-società.</p>
</section>

<section class="card-container">
    <div class="card-item">
        <div class="card-bg" style="background-image: url('https://www.architetturaecosostenibile.it/images/stories/2014/ikea-rifugio-b.jpg');"></div>
        <div class="card-info">
            <span class="card-tag" id="tag-1">Percorso 01</span>
            <h3 class="card-title-text" id="title-1">Costruzione</h3>
            <p id="desc-1">Da tende di plastica a case di mattoni.</p>
        </div>
    </div>
    <div class="card-item">
        <div class="card-bg" style="background-image: url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=1000');"></div>
        <div class="card-info">
            <span class="card-tag" id="tag-2">Percorso 02</span>
            <h3 class="card-title-text" id="title-2">Imprenditori</h3>
            <p id="desc-2">Le storie di Ahmed e Fatma.</p>
        </div>
    </div>
    <div class="card-item">
        <div class="card-bg" style="background-image: url('https://images.unsplash.com/photo-1526649661456-89c7ed4d00b8?q=80&w=1000');"></div>
        <div class="card-info">
            <span class="card-tag" id="tag-3">Percorso 03</span>
            <h3 class="card-title-text" id="title-3">Vita Quotidiana</h3>
            <p id="desc-3">La routine oltre l'emergenza.</p>
        </div>
    </div>
</section>

<section id="map" style="padding: 150px 20px; text-align: center; background: #0d0b0a;">
    <h2 id="map-title" style="font-family: 'Playfair Display'; font-size: 3.5rem; margin-bottom: 50px;">Entra nella Mappa</h2>
    <button class="btn-orange" id="map-btn" onclick="window.location.href='/mappa'">
        ESPLORA IL DOCUMENTARIO
    </button>
</section>

<script>
    document.querySelector('a[href="#map"]').addEventListener('click', function(e) {
    e.preventDefault();
    
    const target = document.getElementById('map');
    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset;
    const startPosition = window.pageYOffset;
    const distance = targetPosition - startPosition;
    const duration = 2500; // millisecondi — aumenta per rallentare ancora di più
    let start = null;

    function easeInOutQuad(t) {
        return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
    }

    function step(timestamp) {
        if (!start) start = timestamp;
        const progress = Math.min((timestamp - start) / duration, 1);
        window.scrollTo(0, startPosition + distance * easeInOutQuad(progress));
        if (progress < 1) requestAnimationFrame(step);
    }

    requestAnimationFrame(step);
});

    function setLanguage(lang) {
        const itBtn = document.getElementById('btn-it');
        const enBtn = document.getElementById('btn-en');

        if (lang === 'it') {
            itBtn.style.background = '#ff7e00'; itBtn.style.border = 'none';
            enBtn.style.background = 'transparent'; enBtn.style.border = '1px solid white';
            
            document.getElementById('hero-desc').innerHTML = 'Tracce quotidiane nel campo profughi di Domiz, Iraq del Nord.';
            document.getElementById('hero-cta').textContent = 'Esplora il Sito';
            document.getElementById('intro-title').textContent = 'Benvenuti';
            document.getElementById('intro-text').textContent = 'Un documentario interattivo sulla vita quotidiana nel campo profughi siriano di Domiz. Con circa 64.000 rifugiati, Domiz è diventata una mini-società.';
            document.getElementById('map-title').textContent = 'Entra nella Mappa';
            document.getElementById('map-btn').textContent = 'ESPLORA IL DOCUMENTARIO';
            document.getElementById('tag-1').textContent = 'Percorso 01';
            document.getElementById('tag-2').textContent = 'Percorso 02';
            document.getElementById('tag-3').textContent = 'Percorso 03';
            document.getElementById('title-1').textContent = 'Costruzione';
            document.getElementById('title-2').textContent = 'Imprenditori';
            document.getElementById('title-3').textContent = 'Vita Quotidiana';
            document.getElementById('desc-1').textContent = 'Da tende di plastica a case di mattoni.';
            document.getElementById('desc-2').textContent = 'Le storie di Ahmed e Fatma.';
            document.getElementById('desc-3').textContent = 'La routine oltre l\'emergenza.';
        } else {
            enBtn.style.background = '#ff7e00'; enBtn.style.border = 'none';
            itBtn.style.background = 'transparent'; itBtn.style.border = '1px solid white';

            document.getElementById('hero-desc').innerHTML = 'Daily traces in Domiz refugee camp, Northern Iraq.';
            document.getElementById('hero-cta').textContent = 'Explore the Site';
            document.getElementById('intro-title').textContent = 'Welcome';
            document.getElementById('intro-text').textContent = 'An interactive documentary about daily life in the Syrian refugee camp of Domiz. With about 64,000 refugees, Domiz has become a mini-society.';
            document.getElementById('map-title').textContent = 'Enter the Map';
            document.getElementById('map-btn').textContent = 'EXPLORE THE DOCUMENTARY';
            document.getElementById('tag-1').textContent = 'Route 01';
            document.getElementById('tag-2').textContent = 'Route 02';
            document.getElementById('tag-3').textContent = 'Route 03';
            document.getElementById('title-1').textContent = 'Construction';
            document.getElementById('title-2').textContent = 'Entrepreneurs';
            document.getElementById('title-3').textContent = 'Daily Life';
            document.getElementById('desc-1').textContent = 'From plastic tents to brick houses.';
            document.getElementById('desc-2').textContent = 'The stories of Ahmed and Fatma.';
            document.getElementById('desc-3').textContent = 'Routine beyond emergency.';
        }
    }

    setLanguage('it');
</script>
</body>
</html>