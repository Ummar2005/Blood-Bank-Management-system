<?php

$db_host = "YOUR_DATABASE_HOST";
$db_user = "YOUR_DATABASE_USERNAME";
$db_pass = "YOUR_DATABASE_PASSWORD";
$db_name = "YOUR_DATABASE_NAME";

$conn = mysqli_connect(
    $db_host,
    $db_user,
    $db_pass,
    $db_name
);

if (!$conn) {
    die("Database connection failed.");
}

?>