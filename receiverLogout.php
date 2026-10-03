<?php

session_start();

// Clear receiver session variables
unset($_SESSION['rid']);
unset($_SESSION['rname']);
unset($_SESSION['remail']);

// Destroy the session
session_destroy();

// Redirect to receiver login page
header("Location: receiverLogin.php");
exit();

?>