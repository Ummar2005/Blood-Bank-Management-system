<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

require_once __DIR__ . "/connection.php";

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request.");
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    die("Username and password are required.");
}

/*
    Check admin account
*/
$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM admin WHERE username = ? LIMIT 1"
);

if (!$stmt) {
    die("SQL Prepare Error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $username);

if (!mysqli_stmt_execute($stmt)) {
    die("SQL Execute Error: " . mysqli_stmt_error($stmt));
}

$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("SQL Result Error: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) === 0) {

    echo "<h3>Invalid Admin Username</h3>";
    echo "<a href='../admin_login.php'>Go Back</a>";
    exit();

}

$row = mysqli_fetch_assoc($result);

/*
    Support both:
    1. Hashed passwords
    2. Existing plain-text passwords
*/

$stored_password = $row['password'];

$password_correct = false;

/* Hashed password */
if (password_verify($password, $stored_password)) {
    $password_correct = true;
}

/* Existing plain-text password */
if ($password === $stored_password) {
    $password_correct = true;
}

if ($password_correct) {

    $_SESSION['admin'] = $username;

    header("Location: ../admin_dashboard.php");
    exit();

} else {

    echo "<h3>Invalid Admin Password</h3>";
    echo "<a href='../admin_login.php'>Go Back</a>";
    exit();

}

?>