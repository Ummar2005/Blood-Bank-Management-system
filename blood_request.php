<?php
session_start();
require 'file/connection.php';

$hid = $_SESSION['hid'];

$sql = "SELECT * FROM blood_request WHERE hid='$hid'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Blood Requests</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

<h3>Blood Requests</h3>

<table class="table table-bordered">
<tr>
<th>ID</th>
<th>Blood</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?= $row['hid'] ?></td>
<td><?= $row['blood_group'] ?></td>
<td><?= $row['status'] ?></td>

<td>
<?php if($row['status']=="Pending"){ ?>
<a href="file/accept.php?reqid=<?= $row['hid'] ?>" class="btn btn-success">Accept</a>
<a href="file/reject.php?reqid=<?= $row['hid'] ?>" class="btn btn-danger">Reject</a>
<?php } else { echo "-"; } ?>
</td>

</tr>
<?php } ?>

</table>

</div>

</body>
</html>