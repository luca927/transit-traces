// places.js - Database dei tuoi luoghi
const places = [
    {
        id: 1,
        name: "Domiz",
        coords: [1200, 1500], // coordinate pixel sulla tua immagine
        type: "città",
        description: "La capitale della Bosnia",
        video: "/assets/videos/sarajevo.mp4",
        audio: "/assets/audio/sarajevo.mp3",
        story: "Centro del campo profughi di Domiz, dove molti bosniaci cercarono rifugio durante la guerra...",
        icon: "🏛️"
    },
    {
        id: 3,
        name: "Ankara",
        coords: [800, 1200],
        type: "natura",
        description: "Il confine naturale",
        video: "/assets/videos/drina.mp4",
        audio: "/assets/audio/fiume.mp3",
        story: "città di confine tra Bosnia e Serbia, attraversata dal fiume Drina...",
        icon: "🌊"
    },
    {
        id: 4,
        name: "Tirana",
        coords: [600, 900],
        type: "campo",
        description: "Rifugio temporaneo",
        video: "/assets/videos/campo.mp4",
        story: "Campo profughi in Albania, dove molti bosniaci cercarono rifugio durante la guerra...",
        icon: "🏕️"
    },
    {
        id: 5,
        name: "Sarajevo",
        coords: [1000, 1300],
        type: "città",
        description: "La città assediata",
        video: "/assets/videos/sarajevo.mp4",
        audio: "/assets/audio/sarajevo.mp3",
        story: "Sarajevo, la capitale della Bosnia, fu assediata per quasi quattro anni durante la guerra, diventando un simbolo di resistenza e sofferenza...",
        icon: "🏙️"
    },
    {
        id: 6,
        name: "Bihac",
        coords: [1100, 1400],
        type: "città",
        description: "Città del nord della Bosnia",
        video: "/assets/videos/bihac.mp4",
        audio: "/assets/audio/bihac.mp3",
        story: "Bihac, una città del nord della Bosnia, fu uno dei primi luoghi a resistere all'assalto serbo durante la guerra...",
        icon: "🏘️"
    }
];