<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

require_once "connection.php";


/*
|--------------------------------------------------------------------------
| Check Hospital Login
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['hid'])) {
    die("Please login as a hospital first.");
}


$hid = (int)$_SESSION['hid'];


/*
|--------------------------------------------------------------------------
| Check Form Submission
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request.");
}


/*
|--------------------------------------------------------------------------
| Get Form Data
|--------------------------------------------------------------------------
*/

$bg = trim($_POST['blood_group'] ?? '');
$units = isset($_POST['units']) ? (int)$_POST['units'] : 0;


/*
|--------------------------------------------------------------------------
| Validate Data
|--------------------------------------------------------------------------
*/

$allowed_blood_groups = [
    'A+',
    'A-',
    'B+',
    'B-',
    'O+',
    'O-',
    'AB+',
    'AB-'
];


if (!in_array($bg, $allowed_blood_groups, true)) {
    die("Invalid blood group.");
}


if ($units <= 0) {
    die("Units must be greater than 0.");
}


/*
|--------------------------------------------------------------------------
| Check Whether Stock Already Exists
|--------------------------------------------------------------------------
*/

$stmt = mysqli_prepare(
    $conn,
    "SELECT id
     FROM blood_stock
     WHERE hospital_id = ?
     AND blood_group = ?
     LIMIT 1"
);


if (!$stmt) {
    die("SQL Prepare Error: " . mysqli_error($conn));
}


mysqli_stmt_bind_param(
    $stmt,
    "is",
    $hid,
    $bg
);


if (!mysqli_stmt_execute($stmt)) {
    die("SQL Execute Error: " . mysqli_stmt_error($stmt));
}


$result = mysqli_stmt_get_result($stmt);


/*
|--------------------------------------------------------------------------
| Update Existing Stock
|--------------------------------------------------------------------------
*/

if (mysqli_num_rows($result) > 0) {

    $row = mysqli_fetch_assoc($result);

    $stock_id = (int)$row['id'];

    $update = mysqli_prepare(
        $conn,
        "UPDATE blood_stock
         SET units = units + ?
         WHERE id = ?"
    );


    if (!$update) {
        die("SQL Update Prepare Error: " . mysqli_error($conn));
    }


    mysqli_stmt_bind_param(
        $update,
        "ii",
        $units,
        $stock_id
    );


    if (!mysqli_stmt_execute($update)) {
        die("SQL Update Error: " . mysqli_stmt_error($update));
    }


    mysqli_stmt_close($update);

}


/*
|--------------------------------------------------------------------------
| Insert New Stock
|--------------------------------------------------------------------------
*/

else {

    $insert = mysqli_prepare(
        $conn,
        "INSERT INTO blood_stock
        (hospital_id, blood_group, units)
        VALUES (?, ?, ?)"
    );


    if (!$insert) {
        die("SQL Insert Prepare Error: " . mysqli_error($conn));
    }


    mysqli_stmt_bind_param(
        $insert,
        "isi",
        $hid,
        $bg,
        $units
    );


    if (!mysqli_stmt_execute($insert)) {
        die("SQL Insert Error: " . mysqli_stmt_error($insert));
    }


    mysqli_stmt_close($insert);
}


mysqli_stmt_close($stmt);


/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

header("Location: ../bloodinfo.php?msg=Stock%20Added");
exit();

?>