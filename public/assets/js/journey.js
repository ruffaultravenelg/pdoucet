const map = L.map('map', {
    scrollWheelZoom: false,
});

const mapContainer = document.getElementById('map');
const map_loader = document.getElementById('map_loader');
const map_not_found = document.getElementById('map_not_found');

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

let marker;
let label

function fromLoLa(latitude, longitude) {
    map_not_found.hidden = true;
    label = '';
    placeMarker(latitude, longitude);   
}

function fromAddress(address) {
    map_not_found.hidden = true;
    showLoader();
    const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(address)}&format=json`;
    fetch(url, { headers: {'User-Agent': 'pdoucet/1.0'}})
    .then(response => response.json())
    .then(data => {
        if (data.length > 0) {
            const lat = parseFloat(data[0].lat);
            const lon = parseFloat(data[0].lon);
            const displayName = data[0].display_name;
            const country = data[0].address?.country || '';
            label = `<strong>${displayName}</strong><br>${country}`
            placeMarker(lat, lon);
        } else {
            placeError();
        }
    })
    .catch(placeError);
}

function showLoader(){
    mapContainer.hidden = true;
    map_loader.hidden = false;
}

function hideLoader(){
    mapContainer.hidden = false;
    map_loader.hidden = true;
}

function placeError(){
    hideLoader();
    console.error("Erreur lors de la recherche de l'adresse.");
    mapContainer.hidden = true;
    map_not_found.hidden = false;
}

function placeMarker(lat, lon) {
    hideLoader();
    if (marker) map.removeLayer(marker);
    
    marker = L.marker([lat, lon]).addTo(map);
    
    if (label) marker.bindPopup(label).openPopup();
    
    map.setView([lat, lon], 5);
}

function updateMap(journey){
    
    const address = journey.getAttribute('data-address');
    const longitude = journey.getAttribute('data-lo');
    const latitude = journey.getAttribute('data-la');
    
    if (longitude && latitude) {
        fromLoLa(latitude, longitude);
    } else if (address) {
        fromAddress(address);
    } else {
        placeError();
    }
    
}

document.addEventListener('DOMContentLoaded', () => {
    
    // Get journeys
    const journeys = document.querySelectorAll('.journey');
    if (journeys.length === 0) {
        mapContainer.style.display = 'none';
        map_loader.style.display = 'none';
        map_not_found.style.display = 'none';
        return;
    }
    
    // Set update event for each journey
    for (const journey of journeys) {
        journey.addEventListener('click', () => {
            updateMap(journey);
            mapContainer.scrollIntoView({ behavior: 'smooth' });
        });
    }
    
    // Select first map
    updateMap(journeys[0]);
    
});

map.on('focus', function() {
    map.scrollWheelZoom.enable();
});

map.on('blur', function() {
    map.scrollWheelZoom.disable();
});
