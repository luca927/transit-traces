// =========================
// SISTEMA DI STORYTELLING
// =========================

const stories = [
    {
        id: 1,
        title: "Il confine invisibile",
        description: "La rotta balcanica non è solo una linea su una mappa, è un viaggio di speranza e sofferenza",
        coordinates: [43.8564, 18.4131],
        zoom: 8,
        media: {
            type: 'video',
            url: '/assets/videos/intro.mp4',
            poster: '/assets/images/intro-poster.jpg'
        },
        audio: '/assets/audio/ambient-border.mp3',
        chapters: [
            {
                name: "Partenza",
                text: "Migliaia lasciano le loro case ogni anno...",
                coordinates: [41.3275, 19.8187]
            },
            {
                name: "Il viaggio",
                text: "Attraverso montagne e confini chiusi...",
                coordinates: [43.8564, 18.4131]
            }
        ]
    }
];

// Modal storytelling
function openStory(storyId) {
    const story = stories.find(s => s.id === storyId);
    if (!story) return;

    const modal = document.createElement('div');
    modal.id = 'story-modal';
    modal.className = 'story-modal active';
    modal.innerHTML = `
        <div class="story-container">
            <button class="close-story" onclick="closeStory()">✕</button>
            
            <div class="story-content">
                <h1>${story.title}</h1>
                <p class="story-description">${story.description}</p>
                
                ${story.media.type === 'video' ? `
                    <video autoplay loop muted playsinline>
                        <source src="${story.media.url}" type="video/mp4">
                    </video>
                ` : `
                    <img src="${story.media.url}" alt="${story.title}">
                `}
                
                <div class="story-chapters">
                    ${story.chapters.map((chapter, index) => `
                        <div class="chapter" onclick="goToChapter(${storyId}, ${index})">
                            <div class="chapter-number">${index + 1}</div>
                            <div class="chapter-info">
                                <h3>${chapter.name}</h3>
                                <p>${chapter.text}</p>
                            </div>
                        </div>
                    `).join('')}
                </div>
                
                <button onclick="startStory(${storyId})" class="start-story-btn">
                    📖 Inizia la storia
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
}

function closeStory() {
    const modal = document.getElementById('story-modal');
    if (modal) modal.remove();
}

function startStory(storyId) {
    closeStory();
    const story = stories.find(s => s.id === storyId);
    
    // Centra sulla prima location
    if (story && window.map) {
        window.map.setView(story.coordinates, story.zoom);
    }
    
    // Avvia narrazione guidata
    narrateChapters(story.chapters);
}

function narrateChapters(chapters) {
    let currentChapter = 0;
    
    function showNextChapter() {
        if (currentChapter >= chapters.length) return;
        
        const chapter = chapters[currentChapter];
        
        // Mostra popup narrativo
        const narrativePopup = L.popup({
            closeButton: false,
            className: 'narrative-popup'
        })
        .setLatLng(chapter.coordinates)
        .setContent(`
            <div class="narrative-content">
                <h3>${chapter.name}</h3>
                <p>${chapter.text}</p>
                <button onclick="nextChapter()">Continua →</button>
            </div>
        `)
        .openOn(window.map);
        
        window.map.setView(chapter.coordinates, 12, {
            animate: true,
            duration: 2
        });
        
        currentChapter++;
    }
    
    window.nextChapter = showNextChapter;
    showNextChapter();
}

window.openStory = openStory;
window.closeStory = closeStory;
window.startStory = startStory;