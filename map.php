<?php
require('file/connection.php');

$sql = "SELECT hospital_name, city, latitude, longitude FROM hospitals";
$result = mysqli_query($conn, $sql);

$mapData = [];

while($row = mysqli_fetch_assoc($result)){
    if(!empty($row['latitude']) && !empty($row['longitude'])){
        $mapData[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Nearby Hospitals</title>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<style>
body {
    font-family: Arial;
    background: #f4f6f9;
}
#map {
    height: 500px;
    border-radius: 10px;
}
h2 {
    text-align: center;
    margin: 20px;
}
</style>

</head>

<body>

<h2>📍 Nearby Hospitals</h2>

<div class="container">
<div id="map"></div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
var map = L.map('map').setView([12.9716, 77.5946], 10);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

var hospitals = <?php echo json_encode($mapData); ?>;

// Auto zoom
var bounds = [];

hospitals.forEach(function(h){
    var marker = L.marker([h.latitude, h.longitude]).addTo(map);

    marker.bindPopup(
        "<b>" + h.hospital_name + "</b><br>" +
        "City: " + h.city
    );

    bounds.push([h.latitude, h.longitude]);
});

// Fit all markers
if(bounds.length > 0){
    map.fitBounds(bounds);
}
</script>

</body>
</html>