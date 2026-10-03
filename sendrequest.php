<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

require_once "connection.php";

// Check receiver login
if (!isset($_SESSION['rid'])) {
    die("Please login as receiver first.");
}

$rid = (int)$_SESSION['rid'];

// Check URL values
if (!isset($_GET['hid']) || !isset($_GET['bg'])) {
    die("Hospital ID or Blood Group is missing.");
}

$hid = (int)$_GET['hid'];
$bg  = trim($_GET['bg']);


// Check if request already exists
$stmt = mysqli_prepare(
    $conn,
    "SELECT reqid
     FROM bloodrequest
     WHERE hid = ?
     AND rid = ?
     AND bg = ?
     AND status = 'Pending'
     LIMIT 1"
);

if (!$stmt) {
    die("SQL Prepare Error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "iis", $hid, $rid, $bg);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("SQL Result Error: " . mysqli_error($conn));
}


// Already requested
if (mysqli_num_rows($result) > 0) {

    header("Location: ../receiver_dashboard.php?msg=already");
    exit();

}


// Insert new request
$stmt2 = mysqli_prepare(
    $conn,
    "INSERT INTO bloodrequest
    (hid, rid, bg, status)
    VALUES (?, ?, ?, 'Pending')"
);

if (!$stmt2) {
    die("SQL Prepare Error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt2, "iis", $hid, $rid, $bg);


if (mysqli_stmt_execute($stmt2)) {

    // Request successfully sent
    header("Location: ../receiver_dashboard.php?msg=sent");
    exit();

} else {

    die("Request Error: " . mysqli_stmt_error($stmt2));

}

?>