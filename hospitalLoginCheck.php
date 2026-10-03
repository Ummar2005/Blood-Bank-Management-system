<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

require_once "connection.php";


/*
|--------------------------------------------------------------------------
| Check Login Request
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['login'])) {

    header("Location: hospitalLogin.php");
    exit();

}


/*
|--------------------------------------------------------------------------
| Get Login Details
|--------------------------------------------------------------------------
*/

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';


if ($email === '' || $password === '') {

    header("Location: hospitalLogin.php?error=Email%20and%20Password%20Required");
    exit();

}


/*
|--------------------------------------------------------------------------
| Find Hospital
|--------------------------------------------------------------------------
*/

$stmt = mysqli_prepare(
    $conn,
    "SELECT hospital_id, hospital_name, email, password
     FROM hospitals
     WHERE email = ?
     LIMIT 1"
);


if (!$stmt) {

    die("SQL Prepare Error: " . mysqli_error($conn));

}


mysqli_stmt_bind_param($stmt, "s", $email);


if (!mysqli_stmt_execute($stmt)) {

    die("SQL Execute Error: " . mysqli_stmt_error($stmt));

}


$result = mysqli_stmt_get_result($stmt);


if (!$result) {

    die("SQL Result Error: " . mysqli_error($conn));

}


/*
|--------------------------------------------------------------------------
| Check Hospital
|--------------------------------------------------------------------------
*/

if (mysqli_num_rows($result) === 0) {

    header("Location: hospitalLogin.php?error=Email%20Not%20Found");
    exit();

}


$row = mysqli_fetch_assoc($result);

$stored_password = $row['password'];

$login_success = false;


/*
|--------------------------------------------------------------------------
| Check Password
|--------------------------------------------------------------------------
*/

/*
 * First check secure hashed password.
 */

if (password_verify($password, $stored_password)) {

    $login_success = true;

}


/*
 * If old database contains plain-text password,
 * check it once and convert it to a secure hash.
 */

elseif ($password === $stored_password) {

    $login_success = true;


    /*
     * Convert old plain-text password to hash.
     */

    $new_hash = password_hash($password, PASSWORD_DEFAULT);


    $update = mysqli_prepare(
        $conn,
        "UPDATE hospitals
         SET password = ?
         WHERE hospital_id = ?"
    );


    if ($update) {

        mysqli_stmt_bind_param(
            $update,
            "si",
            $new_hash,
            $row['hospital_id']
        );

        mysqli_stmt_execute($update);

        mysqli_stmt_close($update);

    }

}


/*
|--------------------------------------------------------------------------
| Login Result
|--------------------------------------------------------------------------
*/

if ($login_success) {


    /*
     * Create hospital session
     */

    $_SESSION['hid'] = $row['hospital_id'];

    $_SESSION['hname'] = $row['hospital_name'];

    $_SESSION['hemail'] = $row['email'];


    /*
     * Go to dashboard
     */

    header("Location: ../hospital_dashboard.php");

    exit();

}


/*
|--------------------------------------------------------------------------
| Wrong Password
|--------------------------------------------------------------------------
*/

header("Location: hospitalLogin.php?error=Wrong%20Password");

exit();

?>