<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

require_once "connection.php";

$msg = "";

if (isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // -----------------------------
    // Check if email already exists
    // -----------------------------

    $stmt = mysqli_prepare(
        $conn,
        "SELECT id FROM receivers WHERE email = ? LIMIT 1"
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

    // -----------------------------
    // Email already exists
    // -----------------------------

    if (mysqli_num_rows($result) > 0) {

        $msg = "❌ Email already registered.";

    } else {

        // -----------------------------
        // Hash password
        // -----------------------------

        $hashed_password = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        // -----------------------------
        // Insert receiver
        // -----------------------------

        $insert = mysqli_prepare(
            $conn,
            "INSERT INTO receivers
            (name, email, password, phone, bg, city)
            VALUES (?, ?, ?, '', '', '')"
        );

        if (!$insert) {
            die("SQL Prepare Error: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param(
            $insert,
            "sss",
            $name,
            $email,
            $hashed_password
        );

        if (mysqli_stmt_execute($insert)) {

            $msg = "✅ Registration successful! You can login now.";

        } else {

            $msg = "❌ Registration Error: " . mysqli_stmt_error($insert);
        }

        mysqli_stmt_close($insert);
    }

    mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Receiver Registration</title>

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


<div class="container min-vh-100 d-flex justify-content-center align-items-center">

    <div class="col-md-5 col-lg-4">

        <div class="card p-4 shadow-lg">


            <!-- Title -->

            <h3 class="text-center title mb-4">
                🧑 Receiver Registration
            </h3>


            <!-- Message -->

            <?php if ($msg != "") { ?>

                <div class="alert alert-info text-center">

                    <?php
                    echo htmlspecialchars($msg);
                    ?>

                </div>

            <?php } ?>


            <!-- Registration Form -->

            <form method="POST">


                <!-- Name -->

                <div class="mb-3">

                    <label class="form-label">
                        Full Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        placeholder="Enter Full Name"
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
                        placeholder="Enter Password"
                        required
                    >

                </div>


                <!-- Register -->

                <button
                    type="submit"
                    name="register"
                    class="btn btn-danger w-100"
                >
                    Register
                </button>


            </form>


            <!-- Login Link -->

            <div class="text-center mt-3">

                <a
                    href="receiverLogin.php"
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


</body>

</html>