// Common Tile Layer (OpenStreetMap - no token required)
const tileLayer = (map) => {
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 18,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
};

// 1️⃣ Basic Map
var mymap = L.map("leaflet-map").setView([51.505, -0.09], 13);
tileLayer(mymap);

// 2️⃣ Marker Map
var markermap = L.map("leaflet-map-marker").setView([51.505, -0.09], 13);
tileLayer(markermap);

L.marker([51.5, -0.09]).addTo(markermap);
L.circle([51.508, -0.11], {
    color: "#34c38f",
    fillColor: "#34c38f",
    fillOpacity: 0.5,
    radius: 500
}).addTo(markermap);

L.polygon([
    [51.509, -0.08],
    [51.503, -0.06],
    [51.51, -0.047]
], {
    color: "#556ee6",
    fillColor: "#556ee6"
}).addTo(markermap);

// 3️⃣ Popup Map
var popupmap = L.map("leaflet-map-popup").setView([51.505, -0.09], 13);
tileLayer(popupmap);

L.marker([51.5, -0.09]).addTo(popupmap)
    .bindPopup("<b>Hello world!</b><br />I am a popup.")
    .openPopup();

L.circle([51.508, -0.11], {
    color: "#f46a6a",
    fillColor: "#f46a6a",
    fillOpacity: 0.5,
    radius: 500
}).addTo(popupmap).bindPopup("I am a circle.");

L.polygon([
    [51.509, -0.08],
    [51.503, -0.06],
    [51.51, -0.047]
], {
    color: "#556ee6",
    fillColor: "#556ee6"
}).addTo(popupmap).bindPopup("I am a polygon.");

// 4️⃣ Custom Icon Map
var customiconsmap = L.map("leaflet-map-custom-icons").setView([51.5, -0.09], 13);
tileLayer(customiconsmap);

var greenIcon = L.icon({
    iconUrl: "assets/images/logo.svg",
    iconSize: [45, 95],
    iconAnchor: [22, 94],
    popupAnchor: [-3, -76]
});

L.marker([51.5, -0.09], { icon: greenIcon }).addTo(customiconsmap);

// 5️⃣ Interactive Map
var interactivemap = L.map("leaflet-map-interactive-map").setView([37.8, -96], 4);
tileLayer(interactivemap);

function getColor(d) {
    return d > 1000 ? "#435fe3" :
           d > 500  ? "#556ee6" :
           d > 200  ? "#677de9" :
           d > 100  ? "#798ceb" :
           d > 50   ? "#8a9cee" :
           d > 20   ? "#9cabf0" :
           d > 10   ? "#aebaf3" :
                      "#c0c9f6";
}

function style(feature) {
    return {
        weight: 2,
        opacity: 1,
        color: "white",
        dashArray: "3",
        fillOpacity: 0.7,
        fillColor: getColor(feature.properties.density)
    };
}

L.geoJson(statesData, { style: style }).addTo(interactivemap);

// 6️⃣ Layer Group Control
var cities = L.layerGroup();

L.marker([39.61, -105.02]).bindPopup("Littleton").addTo(cities);
L.marker([39.74, -104.99]).bindPopup("Denver").addTo(cities);
L.marker([39.73, -104.8]).bindPopup("Aurora").addTo(cities);
L.marker([39.77, -105.23]).bindPopup("Golden").addTo(cities);

var layergroupcontrolmap = L.map("leaflet-map-group-control", {
    center: [39.73, -104.99],
    zoom: 10,
    layers: [cities]
});

tileLayer(layergroupcontrolmap);

L.control.layers(null, { Cities: cities }).addTo(layergroupcontrolmap);