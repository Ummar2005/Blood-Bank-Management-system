<?php
if(isset($_POST['register'])){
    require 'connection.php';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $bg = $_POST['bg'];

    $check = mysqli_query($conn, "SELECT remail FROM receivers WHERE remail='$email'");

    if(mysqli_num_rows($check) > 0){
        header("location:../register.php?error=Email already exists");
    } else {
        $sql = "INSERT INTO receivers (rname, remail, rpassword, rphone, rcity, bg)
                VALUES ('$name','$email','$password','$phone','$city','$bg')";
        
        if(mysqli_query($conn, $sql)){
            header("location:../login.php?msg=Registered successfully");
        } else {
            header("location:../register.php?error=Registration failed");
        }
    }
}
?>