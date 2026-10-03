<?php
session_start();
require 'connection.php';

if(isset($_POST['request'])){

    $rid = $_SESSION['rid'];
    $hid = $_POST['hid'];
    $bg  = $_POST['bg'];

    $sql = "INSERT INTO blood_request (rid, hid, bg)
            VALUES ('$rid','$hid','$bg')";

    if(mysqli_query($conn, $sql)){
        header("location:../sentrequest.php?msg=Request sent");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>