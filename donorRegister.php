<?php
require 'connection.php';

if(isset($_POST['name'])){

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone'];
$city = $_POST['city'];
$bg = $_POST['bg'];

// 🔐 HASH PASSWORD
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if email exists
$check = mysqli_query($conn, "SELECT * FROM donor WHERE email='$email'");
if(mysqli_num_rows($check) > 0){
    echo "❌ Email already registered";
    exit();
}

// Insert data
$sql = "INSERT INTO donor (name,email,password,phone,city,bg)
VALUES ('$name','$email','$hashed_password','$phone','$city','$bg')";

if(mysqli_query($conn,$sql)){
   header("Location: donor_login.php?success=Registration%20Successful");
    exit();
} else {
    echo "Error: ".mysqli_error($conn);
}

} else {
    echo "Form not submitted";
}
?>