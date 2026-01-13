<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transit Traces</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f4f1ea] text-slate-800 antialiased font-serif">

    <nav class="p-6 flex justify-between items-center border-b border-stone-300">
        <h1 class="text-xl font-bold tracking-widest uppercase italic">Project: Horizon</h1>
        <ul class="flex gap-6 text-sm uppercase tracking-tighter">
            <li class="hover:underline cursor-pointer">Mappa</li>
            <li class="hover:underline cursor-pointer">Storie</li>
            <li class="hover:underline cursor-pointer">Info</li>
        </ul>
    </nav>

    <main class="relative h-[80vh] flex items-center justify-center overflow-hidden">
        
        <div class="absolute -top-20 -left-20 w-96 h-96 bg-stone-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>

        <div class="relative z-10 text-center px-4">
            <span class="text-amber-700 font-mono text-sm uppercase tracking-[0.3em]">Benvenuti nel campo di Domiz</span>
            <h2 class="text-6xl md:text-8xl font-black mt-4 mb-6 leading-tight">
                CRONACHE DI <br> <span class="text-stone-500 underline decoration-1 underline-offset-8">UNA REPUBBLICA</span>
            </h2>
            <p class="max-w-xl mx-auto text-lg text-stone-600 leading-relaxed italic">
                "Oltre i confini tracciati sulla carta, esiste una vita fatta di attese, mercati e strade polverose."
            </p>
            
            <button class="mt-10 px-8 py-3 bg-stone-800 text-stone-100 hover:bg-stone-700 transition-all duration-300 uppercase tracking-widest text-xs font-bold">
                Inizia l'esplorazione
            </button>
        </div>

        <div class="absolute bottom-0 right-0 w-1/3 opacity-20 grayscale hover:grayscale-0 transition-all duration-700">
            <img src="https://via.placeholder.com/600x400/stone/white?text=Map+Detail" alt="Mappa decorativa">
        </div>
    </main>

</body>
</html>