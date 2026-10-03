<?php
session_start();
require 'connection.php';

if(isset($_POST['blood_group']) && isset($_POST['units']))
{
    $bg = $_POST['blood_group'];
    $units = (int)$_POST['units'];

    $check = mysqli_query($conn,    
        "SELECT * FROM blood_stock WHERE blood_group='$bg'");

    if(mysqli_num_rows($check) > 0)
    {
        mysqli_query($conn,
        "UPDATE blood_stock
         SET units = units + $units
         WHERE blood_group='$bg'");
    }
    else
    {
        mysqli_query($conn,
        "INSERT INTO blood_stock(blood_group,units)
         VALUES('$bg','$units')");
    }

    echo "
    <script>
        alert('Donate Successfully!');
        window.location='../donor_dashboard.php';
    </script>
    ";
}
?>