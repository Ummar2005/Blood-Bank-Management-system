    <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require 'file/connection.php';
// ✅ Check login
if(!isset($_SESSION['hid'])){
    
    header("location:login.php");
    exit();
}

$hid = $_SESSION['hid'];

// ✅ INSERT BLOOD INFO
if(isset($_POST['add'])){
    $bg = $_POST['bg'];

    $sql_insert = "INSERT INTO bloodinfo (hid, bg) VALUES ('$hid', '$bg')";
    mysqli_query($conn, $sql_insert);
    
}

// ✅ FETCH BLOOD INFO FOR THIS HOSPITAL
$sql = "SELECT * FROM bloodinfo WHERE hid='$hid'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<?php $title="Bloodbank | Blood Info"; ?>
<?php require 'head.php'; ?>

<body>

<?php require 'header.php'; ?>

<div class="container cont">

<h3>Add Blood Group Available In Your Hospital</h3>

<form action="file/add_stock.php" method="post">
    <select name="blood_group">
        <option value="A+">A+</option>
        <option value="B+">B+</option>
        <option value="O+">O+</option>
        <option value="AB+">AB+</option>
        <option value="A-">A-</option>
        <option value="B-">B-</option>
        <option value="O-">O-</option>
        <option value="AB-">AB-</option>
    </select>

    <input type="number" name="units" placeholder="Units" required>

    <button type="submit">Add</button>
</form>

<hr>

<h3>Blood Bank</h3>

<table class="table table-bordered">
<tr>
<th>#</th>
<th>Blood Group</th>
</tr>

<?php
$counter = 0;

if($result && mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
?>
<tr>
<td><?php echo ++$counter; ?></td>
<td><?php echo $row['bg']; ?></td>
</tr>
<?php
    }
}else{
    echo "<tr><td colspan='2'>No data found</td></tr>";
}
?>

</table>

</div>

<?php require 'footer.php'; ?>

</body>
</html>