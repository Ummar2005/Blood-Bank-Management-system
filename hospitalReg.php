<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

require_once "connection.php";

$msg = "";
$msg_type = "info";


/*
|--------------------------------------------------------------------------
| Registration
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {

    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $phone    = trim($_POST['phone'] ?? '');
    $city     = trim($_POST['city'] ?? '');
    $lat      = trim($_POST['latitude'] ?? '');
    $lng      = trim($_POST['longitude'] ?? '');


    /*
    |--------------------------------------------------------------------------
    | Basic validation
    |--------------------------------------------------------------------------
    */

    if (
        $name === '' ||
        $email === '' ||
        $password === '' ||
        $phone === '' ||
        $city === '' ||
        $lat === '' ||
        $lng === ''
    ) {

        $msg = "❌ Please fill all required fields.";
        $msg_type = "danger";

    }

    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $msg = "❌ Please enter a valid email address.";
        $msg_type = "danger";

    }

    elseif (!is_numeric($lat) || !is_numeric($lng)) {

        $msg = "❌ Latitude and Longitude must be numbers.";
        $msg_type = "danger";

    }

    else {

        /*
        |--------------------------------------------------------------------------
        | Check whether email already exists
        |--------------------------------------------------------------------------
        */

        $check = mysqli_prepare(
            $conn,
            "SELECT hospital_id
             FROM hospitals
             WHERE email = ?
             LIMIT 1"
        );

        if (!$check) {

            die("SQL Prepare Error: " . mysqli_error($conn));

        }


        mysqli_stmt_bind_param(
            $check,
            "s",
            $email
        );


        if (!mysqli_stmt_execute($check)) {

            die("SQL Execute Error: " . mysqli_stmt_error($check));

        }


        $result = mysqli_stmt_get_result($check);


        if (!$result) {

            die("SQL Result Error: " . mysqli_error($conn));

        }


        /*
        |--------------------------------------------------------------------------
        | Email already exists
        |--------------------------------------------------------------------------
        */

        if (mysqli_num_rows($result) > 0) {

            $msg = "❌ Email already registered.";
            $msg_type = "danger";

        }

        else {

            /*
            |--------------------------------------------------------------------------
            | Hash password
            |--------------------------------------------------------------------------
            */

            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );


            /*
            |--------------------------------------------------------------------------
            | Insert hospital
            |--------------------------------------------------------------------------
            |
            | address and bg are omitted because they allow NULL.
            |
            */

            $insert = mysqli_prepare(
                $conn,
                "INSERT INTO hospitals
                (
                    hospital_name,
                    email,
                    password,
                    latitude,
                    longitude,
                    phone,
                    city
                )
                VALUES (?, ?, ?, ?, ?, ?, ?)"
            );


            if (!$insert) {

                die("SQL Insert Prepare Error: " . mysqli_error($conn));

            }


            mysqli_stmt_bind_param(
                $insert,
                "sssdsss",
                $name,
                $email,
                $hashed_password,
                $lat,
                $lng,
                $phone,
                $city
            );


            if (mysqli_stmt_execute($insert)) {

                $msg = "✅ Hospital registration successful! You can login now.";
                $msg_type = "success";

            }

            else {

                $msg = "❌ Registration Error: " . mysqli_stmt_error($insert);
                $msg_type = "danger";

            }


            mysqli_stmt_close($insert);

        }


        mysqli_stmt_close($check);

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Hospital Registration</title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <style>

        body {
            min-height: 100vh;
            background: linear-gradient(
                to right,
                #ff512f,
                #dd2476
            );
        }

        .card {
            border-radius: 15px;
        }

        .title {
            font-weight: 600;
        }

    </style>

</head>


<body>


<div class="container py-5">


    <div class="row justify-content-center">


        <div class="col-md-6 col-lg-5">


            <div class="card p-4 shadow-lg">


                <!-- Heading -->

                <h3 class="text-center title mb-4">
                    🏥 Hospital Registration
                </h3>


                <!-- Message -->

                <?php if ($msg !== ""): ?>

                    <div class="alert alert-<?= htmlspecialchars($msg_type) ?>">

                        <?= htmlspecialchars($msg) ?>

                    </div>

                <?php endif; ?>


                <!-- Registration Form -->

                <form method="POST">


                    <!-- Hospital Name -->

                    <div class="mb-3">

                        <label class="form-label">
                            Hospital Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Enter Hospital Name"
                            value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                            required
                        >

                    </div>


                    <!-- Email -->

                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Enter Email"
                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                            required
                        >

                    </div>


                    <!-- Password -->

                    <div class="mb-3">

                        <label class="form-label">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Create Password"
                            required
                        >

                    </div>


                    <!-- Phone -->

                    <div class="mb-3">

                        <label class="form-label">
                            Phone Number
                        </label>

                        <input
                            type="text"
                            name="phone"
                            class="form-control"
                            placeholder="Enter Phone Number"
                            value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                            required
                        >

                    </div>


                    <!-- City -->

                    <div class="mb-3">

                        <label class="form-label">
                            City
                        </label>

                        <input
                            type="text"
                            name="city"
                            class="form-control"
                            placeholder="Enter City"
                            value="<?= htmlspecialchars($_POST['city'] ?? '') ?>"
                            required
                        >

                    </div>


                    <!-- Latitude -->

                    <div class="mb-3">

                        <label class="form-label">
                            Latitude
                        </label>

                        <input
                            type="text"
                            name="latitude"
                            class="form-control"
                            placeholder="Example: 12.9716"
                            value="<?= htmlspecialchars($_POST['latitude'] ?? '') ?>"
                            required
                        >

                    </div>


                    <!-- Longitude -->

                    <div class="mb-3">

                        <label class="form-label">
                            Longitude
                        </label>

                        <input
                            type="text"
                            name="longitude"
                            class="form-control"
                            placeholder="Example: 77.5946"
                            value="<?= htmlspecialchars($_POST['longitude'] ?? '') ?>"
                            required
                        >

                    </div>


                    <!-- Register Button -->

                    <button
                        type="submit"
                        name="register"
                        class="btn btn-danger w-100"
                    >

                        Register Hospital

                    </button>


                </form>


                <!-- Login Link -->

                <div class="text-center mt-3">

                    <a
                        href="hospitalLogin.php"
                        class="text-decoration-none"
                    >
                        Already have an account? Login
                    </a>

                </div>


                <!-- Home Link -->

                <div class="text-center mt-2">

                    <a
                        href="../index.php"
                        class="text-decoration-none"
                    >
                        ⬅ Back to Home
                    </a>

                </div>


            </div>

        </div>

    </div>

</div>


</body>

</html>