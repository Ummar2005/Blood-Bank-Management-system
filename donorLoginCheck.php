<?php
session_start();
require 'connection.php';

if(isset($_POST['email']) && isset($_POST['password'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Get user by email
    $sql = "SELECT * FROM donor WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_assoc($result);

        // Verify password
        if(password_verify($password, $row['password'])){

            $_SESSION['did'] = $row['donor_id'];
            $_SESSION['dname'] = $row['name'];
            require __DIR__ . '/../config.php';
            header("Location: ../donor_dashboard.php");
            exit();
            

        } else {
            echo "❌ Wrong Password";
        }

    } else {
        echo "❌ Email not found";
    }

} else {
    echo "Form not submitted properly";
}
?>