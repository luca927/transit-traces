<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transit Traces : Domiz Camp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@11ty/eleventy-plugin-i18n-translations@latest/i18n.js"></script>
    <style>
    .language-switcher { position: fixed; top: 20px; right: 20px; z-index: 1001; background: rgba(230,126,34,0.9); padding: 10px; border-radius: 25px; }
    .language-switcher button { background: none; border: none; color: white; font-size: 16px; margin: 0 5px; cursor: pointer; font-family: Georgia, serif; }
    .language-switcher button.active { font-weight: bold; text-decoration: underline; }
    </style>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Georgia', serif; 
            background: #f4e8d9; 
            color: #333; 
            line-height: 1.6;
            overflow-x: hidden;
        }
        .hero {
            height: 100vh;
            background: linear-gradient(rgba(230,126,34,0.8), rgba(230,126,34,0.8)),
                        url('https://images.unsplash.com/photo-1576050471413-7b3e4a2a7a9d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
        }
        .hero h1 {
            font-size: clamp(2.5rem, 8vw, 6rem);
            font-weight: 300;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        .hero p {
            font-size: clamp(1.1rem, 4vw, 1.8rem);
            max-width: 800px;
            margin-bottom: 3rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }
        .cta {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 1.2rem 3rem;
            border: 2px solid white;
            border-radius: 50px;
            font-size: 1.2rem;
            text-decoration: none;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        .cta:hover {
            background: white;
            color: #e67e22;
            transform: translateY(-3px);
        }
        .intro {
            max-width: 1000px;
            margin: 8rem auto;
            padding: 0 2rem;
        }
        .intro h2 {
            font-size: 3rem;
            color: #e67e22;
            margin-bottom: 2rem;
            text-align: center;
        }
        .intro p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            text-align: center;
        }
        .routes {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
            margin: 6rem 2rem;
        }
        .route-card {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
            border: 3px solid transparent;
        }
        .route-card:hover {
            transform: translateY(-10px);
            border-color: #e67e22;
        }
        .route-card h3 {
            color: #e67e22;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }
        .map-entry {
            text-align: center;
            margin: 6rem 0;
        }
        .map-btn {
            background: #e67e22;
            color: white;
            padding: 1.5rem 4rem;
            border: none;
            border-radius: 50px;
            font-size: 1.5rem;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.3s ease;
        }
        .map-btn:hover {
            background: #d35400;
            transform: scale(1.05);
        }
        .social-header a:hover {
             transform: scale(1.2) translateY(-3px);
             box-shadow: 0 8px 25px rgba(0,0,0,0.4) !important;
         }
        .social-header a:active {
             transform: scale(0.95);
        }

    </style>
</head>
<body>
<!-- Header Refugee Republic IDENTICO -->
<header style="position: fixed; top: 0; left: 0; right: 0; padding: 1rem 2rem; z-index: 2000; display: flex; justify-content: space-between; align-items: center;">

    <!-- Social Icons a SINISTRA -->
    <div style="display: flex; gap: 0.5rem;">
        <a href="https://facebook.com/transittraces" target="_blank" style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: rgba(255,255,255,0.2); border-radius: 4px; text-decoration: none; transition: all 0.3s ease;">
            <i class="fab fa-facebook-f" style="color: white; font-size: 0.9rem;"></i>
        </a>
        <a href="https://twitter.com/transittraces" target="_blank" style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: rgba(255,255,255,0.2); border-radius: 4px; text-decoration: none; transition: all 0.3s ease;">
            <i class="fab fa-twitter" style="color: white; font-size: 0.9rem;"></i>
        </a>
    </div>

    <!-- Lingue a DESTRA -->
    <div class="language-switcher" id="langBtn" style="display: flex; gap: 0.5rem; font-family: Arial; font-size: 0.85rem; font-weight: 500;">
        <a href="#" onclick="setLanguage('it')" style="color: white; text-decoration: none; padding: 0.3rem 0.8rem; border-radius: 4px; transition: all 0.3s ease; background: #1e40af;">ITALIANO</a>
        <a href="#" onclick="setLanguage('en')" style="color: #0e0c0b; text-decoration: none; padding: 0.3rem 0.8rem; border-radius: 4px; border: 1px solid #0e0c0b; transition: all 0.3s ease;">ENGLISH</a>
    </div>
</header>



    <!-- Hero Section stile Refugee Republic -->
    <section class="hero">
        <h1>Transit Traces</h1>
        <p>Tracce quotidiane nel campo profughi di Domiz, Iraq del Nord.<br>
        Disegni, video, fotografia e audio per conoscere Ahmed, Fatma e la vita oltre i poster umanitari.</p>
        <a href="#map" class="cta">Esplora Domiz Camp</a>
    </section>

    <!-- Introduzione -->
    <section class="intro">
        <h2>Benvenuti a Transit Traces</h2>
        <p>Un documentario interattivo sulla vita quotidiana nel campo profughi siriano di Domiz. 
        Con circa 64.000 rifugiati prevalentemente curdi siriani, Domiz è diventata una mini-società 
        con i suoi mercati, scuole improvvisate, attività imprenditoriali e sogni.</p>
    </section>

    <!-- 4 Rotte di esplorazione (stile Refugee Republic originale) -->
    <section class="routes">
        <div class="route-card">
            <h3>🛠️ Costruzione</h3>
            <p>Da tende di plastica a case di mattoni. Come i rifugiati trasformano Domiz.</p>
        </div>
        <div class="route-card">
            <h3>💡 Imprenditori</h3>
            <p>Ahmed (13) salta la scuola per il suo banco di uccelli. Fatma (16) sogna Youtube.</p>
        </div>
        <div class="route-card">
            <h3>🌱 Vita Quotidiana</h3>
            <p>Acqua, matrimoni, tuk tuk, preghiere. La routine oltre le immagini drammatiche.</p>
        </div>
        <div class="route-card">
            <h3>💰 Economia</h3>
            <p>Mercati informali, lavori precari, micro-imprenditori. L'economia del campo.</p>
        </div>
    </section>

    <!-- Ingresso Mappa Interattiva -->
    <section class="map-entry" id="map">
        <h2 style="text-align: center; color: #e67e22; font-size: 3rem; margin-bottom: 3rem;">
            Mappa Interattiva Domiz
        </h2>
        <button class="map-btn" onclick="window.location.href='/mappa'">Entra nella Mappa →</button>
    </section>

    <script>
        // Funzione per scorrere alla mappa
        document.querySelector('.cta').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('map').scrollIntoView({ behavior: 'smooth' });
        });

// Gestione selezione lingua
 let currentLang = 'it';

function setLanguage(lang) {
    currentLang = lang;
    const italianoBtn = document.querySelector('a[onclick="setLanguage(\'it\')"]');
    const englishBtn = document.querySelector('a[onclick="setLanguage(\'en\')"]');
    
    if (lang === 'it') {
        italianoBtn.style.background = '#1e40af';
        italianoBtn.style.color = 'white';
        italianoBtn.style.border = 'none';
        englishBtn.style.background = 'transparent';
        englishBtn.style.color = '#000000';
        englishBtn.style.border = '1px solid #000000';
    } else {
        englishBtn.style.background = '#1e40af';
        englishBtn.style.color = 'white';
        englishBtn.style.border = 'none';
        italianoBtn.style.background = 'transparent';
        italianoBtn.style.color = '#000000';
        italianoBtn.style.border = '1px solid #000000';
    }
    
    // ✅ TRADUCI TUTTI I TESTI (IL PROBLEMA ERA QUI!)
    if (lang === 'en') {
        document.querySelector('.hero h1').textContent = 'Transit Traces';
        document.querySelector('.hero p').innerHTML = 'Daily traces in Domiz refugee camp, Northern Iraq.<br>Drawings, video, photography and audio to know Ahmed, Fatma and life beyond humanitarian posters.';
        document.querySelector('.cta').textContent = 'Enter the Map';
        document.querySelector('.intro h2').textContent = 'Welcome to Transit Traces';
        document.querySelector('.intro p').innerHTML = 'An interactive documentary about daily life in the Syrian refugee camp of Domiz. With about 64,000 mostly Syrian Kurdish refugees, Domiz has become a mini-society with its markets, makeshift schools, entrepreneurial activities and dreams.';
        document.querySelector('.map-entry h2').textContent = 'Interactive Domiz Map';
        document.querySelector('.map-btn').textContent = 'Enter the Map →';
        
        // Route cards EN
        document.querySelectorAll('.route-card h3')[0].textContent = '🛠️ Construction';
        document.querySelectorAll('.route-card p')[0].textContent = 'From plastic tents to brick houses. How refugees transform Domiz.';
        document.querySelectorAll('.route-card h3')[1].textContent = '💡 Entrepreneurs';
        document.querySelectorAll('.route-card p')[1].textContent = 'Ahmed (13) skips school for his bird stall. Fatma (16) dreams of Youtube.';
        document.querySelectorAll('.route-card h3')[2].textContent = '🌱 Daily Life';
        document.querySelectorAll('.route-card p')[2].textContent = 'Water, weddings, tuk tuks, prayers. Routine beyond dramatic images.';
        document.querySelectorAll('.route-card h3')[3].textContent = '💰 Economy';
        document.querySelectorAll('.route-card p')[3].textContent = 'Informal markets, precarious jobs, micro-entrepreneurs. Camp economy.';
    } else {
        document.querySelector('.hero h1').textContent = 'Transit Traces';
        document.querySelector('.hero p').innerHTML = 'Tracce quotidiane nel campo profughi di Domiz, Iraq del Nord.<br>Disegni, video, fotografia e audio per conoscere Ahmed, Fatma e la vita oltre i poster umanitari.';
        document.querySelector('.cta').textContent = 'Esplora Domiz Camp';
        document.querySelector('.intro h2').textContent = 'Benvenuti a Transit Traces';
        document.querySelector('.intro p').innerHTML = 'Un documentario interattivo sulla vita quotidiana nel campo profughi siriano di Domiz. Con circa 64.000 rifugiati prevalentemente curdi siriani, Domiz è diventata una mini-società con i suoi mercati, scuole improvvisate, attività imprenditoriali e sogni.';
        document.querySelector('.map-entry h2').textContent = 'Mappa Interattiva Domiz';
        document.querySelector('.map-btn').textContent = 'Entra nella Mappa →';
        
        // Route cards IT
        document.querySelectorAll('.route-card h3')[0].textContent = '🛠️ Costruzione';
        document.querySelectorAll('.route-card p')[0].textContent = 'Da tende di plastica a case di mattoni. Come i rifugiati trasformano Domiz.';
        document.querySelectorAll('.route-card h3')[1].textContent = '💡 Imprenditori';
        document.querySelectorAll('.route-card p')[1].textContent = 'Ahmed (13) salta la scuola per il suo banco di uccelli. Fatma (16) sogna Youtube.';
        document.querySelectorAll('.route-card h3')[2].textContent = '🌱 Vita Quotidiana';
        document.querySelectorAll('.route-card p')[2].textContent = 'Acqua, matrimoni, tuk tuk, preghiere. La routine oltre le immagini drammatiche.';
        document.querySelectorAll('.route-card h3')[3].textContent = '💰 Economia';
        document.querySelectorAll('.route-card p')[3].textContent = 'Mercati informali, lavori precari, micro-imprenditori. L\'economia del campo.';
    }
}

// Init italiano
setLanguage('it');
    </script>
</body>
</html>