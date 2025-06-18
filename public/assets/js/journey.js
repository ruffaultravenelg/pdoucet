const map = L.map('map').setView([48.8566, 2.3522], 13); // Paris par défaut

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

let marker;
let label

function fromLoLa(latitude, longitude) {
    label = '';
    placeMarker(latitude, longitude);   
}

function fromAddress(address) {
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
                alert("Adresse introuvable.");
            }
        })
        .catch(error => {
            alert("Erreur lors de la recherche : " + error);
        });
}

function placeMarker(lat, lon) {
    if (marker) map.removeLayer(marker);

    marker = L.marker([lat, lon]).addTo(map);

    if (label) marker.bindPopup(label).openPopup();

    map.setView([lat, lon], 15);
}


function updateMap(journey){

    const address = journey.getAttribute('data-address');
    const longitude = journey.getAttribute('data-lo');
    const latitude = journey.getAttribute('data-la');

    if (longitude && latitude) {
        fromLoLa(latitude, longitude);
    } else if (address) {
        fromAddress(address);
    }

}

document.addEventListener('DOMContentLoaded', () => {

    // Get journeys
    const journeys = document.querySelectorAll('.journey');

    // Set update event for each journey
    for (const journey of journeys) {
        journey.addEventListener('click', () => {
            updateMap(journey);
            document.getElementById('map').scrollIntoView({ behavior: 'smooth' });
        });
    }

    // Select first map
    updateMap(journeys[0]);

});