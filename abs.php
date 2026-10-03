<?php
session_start();
require 'file/connection.php';

// detect role
$role = "guest";
if(isset($_SESSION['did'])) $role = "donor";
if(isset($_SESSION['rid'])) $role = "receiver";
if(isset($_SESSION['hid'])) $role = "hospital";

// fetch data
$sql = "SELECT hospitals.hospital_id, hospitals.hospital_name,
               hospitals.latitude, hospitals.longitude,
               blood_stock.blood_group, blood_stock.units
        FROM hospitals
        JOIN blood_stock ON hospitals.hospital_id = blood_stock.hospital_id";

$res = mysqli_query($conn, $sql);

$data = [];
while($row = mysqli_fetch_assoc($res)){
    $data[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Blood Map</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<style>
#map { height: 400px; }
</style>

</head>

<body class="bg-light">

<div class="container mt-4">

<h3 class="text-center text-danger">🩸 Blood System</h3>

<div id="map"></div>

<hr>

<?php if($role == "donor"){ ?>

<!-- 🧑 DONOR VIEW -->
<h4 class="text-danger">⚠ Blood Shortage</h4>

<table class="table table-bordered">
<tr><th>Blood</th><th>Units</th></tr>

<?php foreach($data as $d){
if($d['units'] <= 3){ ?>
<tr>
<td><?= $d['blood_group'] ?></td>
<td><?= $d['units'] ?></td>
</tr>
<?php }} ?>

</table>

<?php } elseif($role == "receiver"){ ?>

<!-- 🧑‍⚕ RECEIVER VIEW -->
<h4>Available Blood</h4>

<table class="table table-bordered">
<tr>
<th>Hospital</th>
<th>Blood</th>
<th>Units</th>
<th>Action</th>
</tr>

<?php foreach($data as $d){
if($d['units'] > 0){ ?>
<tr>
<td><?= $d['hospital_name'] ?></td>
<td><?= $d['blood_group'] ?></td>
<td><?= $d['units'] ?></td>

<td>
<a href="file/sendrequest.php?hid=<?= $d['hospital_id'] ?>&bg=<?= $d['blood_group'] ?>" 
class="btn btn-success btn-sm">
Request
</a>
</td>

</tr>
<?php }} ?>

</table>

<?php } elseif($role == "hospital"){ ?>

<!-- 🏥 HOSPITAL VIEW -->
<h4>Blood Requests</h4>

<?php
$hid = $_SESSION['hid'];
$q = mysqli_query($conn,"SELECT * FROM blood_request WHERE hospital_id='$hid'");
?>

<table class="table table-bordered">
<tr>
<th>ID</th>
<th>Blood</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($r=mysqli_fetch_assoc($q)){ ?>
<tr>
<td><?= $r['id'] ?></td>
<td><?= $r['blood_group'] ?></td>
<td><?= $r['status'] ?></td>

<td>
<?php if($r['status']=="Pending"){ ?>
<a href="file/accept.php?reqid=<?= $r['id'] ?>" class="btn btn-success btn-sm">Accept</a>
<a href="file/reject.php?reqid=<?= $r['id'] ?>" class="btn btn-danger btn-sm">Reject</a>
<?php } else { echo "-"; } ?>
</td>

</tr>
<?php } ?>

</table>

<?php } else { ?>

<p class="text-center text-muted">Login to see details</p>

<?php } ?>

</div>

<!-- MAP -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
var map = L.map('map').setView([20.5937, 78.9629], 5);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png')
.addTo(map);

var data = <?php echo json_encode($data); ?>;

data.forEach(d => {
    if(d.latitude && d.longitude){
        L.marker([d.latitude, d.longitude])
        .addTo(map)
        .bindPopup(
            "<b>"+d.hospital_name+"</b><br>"+
            d.blood_group+" ("+d.units+" units)"
        );
    }
});
</script>

</body>
</html>