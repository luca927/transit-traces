// places.js - Database dei tuoi luoghi
const places = [
    {
        id: 1,
        name: "Sarajevo",
        coords: [1200, 1500], // coordinate pixel sulla tua immagine
        category: "città",
        description: "La capitale della Bosnia",
        video: "/assets/videos/sarajevo.mp4",
        audio: "/assets/audio/sarajevo.mp3",
        story: "Qui inizia il viaggio attraverso i Balcani...",
        icon: "🏛️"
    },
    {
        id: 2,
        name: "Fiume Drina",
        coords: [800, 1200],
        category: "natura",
        description: "Il confine naturale",
        video: "/assets/videos/drina.mp4",
        audio: "/assets/audio/fiume.mp3",
        story: "Il fiume che divide due mondi...",
        icon: "🌊"
    },
    {
        id: 3,
        name: "Campo profughi",
        coords: [600, 900],
        category: "campo",
        description: "Rifugio temporaneo",
        video: "/assets/videos/campo.mp4",
        story: "Migliaia di persone trovano qui riparo...",
        icon: "🏕️"
    }
    // Aggiungi altri luoghi...
];