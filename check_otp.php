<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

require_once "connection.php";


/*
|--------------------------------------------------------------------------
| Check whether OTP was generated
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_email'])) {
    header("Location: receiverLogin.php?error=OTP%20expired");
    exit();
}


$email = $_SESSION['otp_email'];


/*
|--------------------------------------------------------------------------
| Verify OTP
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $entered_otp = trim($_POST['otp'] ?? '');

    if ($entered_otp == "") {
        $error = "Please enter the OTP.";
    }

    /*
    |--------------------------------------------------------------------------
    | Check OTP expiry - 5 minutes
    |--------------------------------------------------------------------------
    */

    elseif (
        isset($_SESSION['otp_time']) &&
        (time() - $_SESSION['otp_time']) > 300
    ) {

        unset($_SESSION['otp']);
        unset($_SESSION['otp_email']);
        unset($_SESSION['otp_time']);

        $error = "OTP has expired. Please login again.";
    }

    /*
    |--------------------------------------------------------------------------
    | Compare OTP
    |--------------------------------------------------------------------------
    */

    elseif ((string)$entered_otp !== (string)$_SESSION['otp']) {

        $error = "Invalid OTP. Please try again.";
    }

    /*
    |--------------------------------------------------------------------------
    | OTP correct
    |--------------------------------------------------------------------------
    */

    else {

        /*
        | Get receiver details
        */

        $stmt = mysqli_prepare(
            $conn,
            "SELECT id, name, email
             FROM receivers
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

        if (mysqli_num_rows($result) == 0) {
            die("Receiver account not found.");
        }

        $row = mysqli_fetch_assoc($result);


        /*
        |--------------------------------------------------------------------------
        | LOGIN SUCCESS
        |--------------------------------------------------------------------------
        */

        $_SESSION['rid'] = $row['id'];
        $_SESSION['rname'] = $row['name'];
        $_SESSION['remail'] = $row['email'];


        /*
        |--------------------------------------------------------------------------
        | Clear OTP session
        |--------------------------------------------------------------------------
        */

        unset($_SESSION['otp']);
        unset($_SESSION['otp_email']);
        unset($_SESSION['otp_time']);


        /*
        |--------------------------------------------------------------------------
        | Redirect to receiver dashboard
        |--------------------------------------------------------------------------
        */

        header("Location: ../receiver_dashboard.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verify OTP</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>


<body class="bg-light">


<div class="container">

    <div class="row justify-content-center mt-5">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-body p-4">

                    <h3 class="text-center mb-3">
                        🔐 Verify OTP
                    </h3>

                    <p class="text-center text-muted">

                        OTP sent to:

                        <br>

                        <b>
                            <?= htmlspecialchars($email) ?>
                        </b>

                    </p>


                    <?php if (isset($error)): ?>

                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>

                    <?php endif; ?>


                    <form method="POST">


                        <div class="mb-3">

                            <label class="form-label">
                                Enter OTP
                            </label>

                            <input
                                type="text"
                                name="otp"
                                class="form-control text-center"
                                placeholder="Enter 6-digit OTP"
                                maxlength="6"
                                required
                                autofocus
                            >

                        </div>


                        <button
                            type="submit"
                            class="btn btn-danger w-100"
                        >

                            Verify OTP

                        </button>


                    </form>


                </div>

            </div>

        </div>

    </div>

</div>


</body>

</html>