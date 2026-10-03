<?php
require 'connection.php';
session_start();

if(isset($_POST['update']) && isset($_SESSION['hid'])){

    $id = $_SESSION['hid'];

    $name = $_POST['hospital_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "UPDATE hospitals 
            SET hospital_name='$name',
                email='$email',
                password='$password',
                phone='$phone',
                address='$address'
            WHERE hospital_id='$id'";

    if(mysqli_query($conn, $sql)){
        header("Location: ../hprofile.php?msg=Profile updated successfully");
    } else {
        header("Location: ../hprofile.php?error=Update failed");
    }
}
?>