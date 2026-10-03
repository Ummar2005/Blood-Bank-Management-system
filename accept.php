<?php
session_start();
require 'connection.php';

if(isset($_GET['reqid'])){

    $reqid = $_GET['reqid'];

    // get request details
    $res = mysqli_query($conn, "SELECT * FROM blood_request WHERE hid='$reqid'");
    $row = mysqli_fetch_assoc($res);

    $hid = $row['hospital_id'];
    $bg  = $row['blood_group'];
    $_SESSION['msg'] = "Request Accepted!";

    // check stock
    $stock = mysqli_query($conn, "SELECT * FROM blood_stock 
                                 WHERE hospital_id='$hid' AND blood_group='$bg'");
    $s = mysqli_fetch_assoc($stock);

    if($s && $s['units'] > 0){

        // reduce stock
        mysqli_query($conn, "UPDATE blood_stock 
                             SET units = units - 1 
                             WHERE hospital_id='$hid' AND blood_group='$bg'");

        // update request
        mysqli_query($conn, "UPDATE blood_request 
                             SET status='Accepted' 
                             WHERE id='$reqid'");

        header("Location: ../blood_request.php?msg=Accepted");
    } else {
        echo "❌ No stock available";
    }
}
?>