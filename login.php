<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Blood Bank Login</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            margin: 0;
            min-height: 100vh;
            background: #f8f9fa;
        }

        .navbar-custom {
            background: #dc3545;
            height: 70px;
        }

        .logo {
            color: white;
            font-size: 25px;
            font-weight: bold;
        }

        .login-container {
            min-height: calc(100vh - 140px);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            width: 520px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.15);
        }

        .tab-button {
            font-size: 18px;
            padding: 18px;
        }

        .form-control {
            height: 48px;
        }

        .login-btn {
            height: 48px;
            font-size: 17px;
        }

        .register-link {
            font-size: 18px;
            text-decoration: none;
        }

        footer {
            height: 70px;
            background: #f8f9fa;
            border-top: 1px solid #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
        }

    </style>

</head>


<body>


<!-- ========================= -->
<!-- NAVBAR -->
<!-- ========================= -->

<nav class="navbar-custom d-flex align-items-center">

    <div class="container-fluid">

        <span class="logo">
            🩸 Blood Bank
        </span>

    </div>

</nav>


<!-- ========================= -->
<!-- LOGIN AREA -->
<!-- ========================= -->

<div class="login-container">

    <div class="login-card">

        <!-- TABS -->

        <ul class="nav nav-tabs nav-fill">

            <li class="nav-item">

                <button
                    class="nav-link active tab-button"
                    id="hospital-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#hospital"
                    type="button"
                >
                    Hospitals
                </button>

            </li>


            <li class="nav-item">

                <button
                    class="nav-link tab-button"
                    id="receiver-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#receiver"
                    type="button"
                >
                    Receiver's
                </button>

            </li>

        </ul>


        <!-- TAB CONTENT -->

        <div class="tab-content p-4">


            <!-- ========================= -->
            <!-- HOSPITAL LOGIN -->
            <!-- ========================= -->

            <div
                class="tab-pane fade show active"
                id="hospital"
            >

                <form
                    action="file/hospitalLoginCheck.php"
                    method="POST"
                >

                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Hospital Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Hospital Email"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Hospital Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Hospital Password"
                            required
                        >

                    </div>


                    <button
                        type="submit"
                        name="login"
                        class="btn btn-primary w-100 login-btn"
                    >
                        Login
                    </button>

                </form>


                <!-- IMPORTANT: file/ is required -->

                <div class="text-center mt-4">

                    <a
                        href="file/hospitalReg.php"
                        class="register-link"
                    >
                        Don't have account?
                    </a>

                </div>

            </div>


            <!-- ========================= -->
            <!-- RECEIVER LOGIN -->
            <!-- ========================= -->

            <div
                class="tab-pane fade"
                id="receiver"
            >

                <form
                    action="file/send_otp.php"
                    method="POST"
                >

                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Receiver Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Receiver Email"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Receiver Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Receiver Password"
                            required
                        >

                    </div>


                    <button
                        type="submit"
                        name="login"
                        class="btn btn-primary w-100 login-btn"
                    >
                        Login
                    </button>

                </form>


                <!-- IMPORTANT: file/ is required -->

                <div class="text-center mt-4">

                    <a
                        href="file/register.php"
                        class="register-link"
                    >
                        Don't have account?
                    </a>

                </div>

            </div>


        </div>

    </div>

</div>


<!-- ========================= -->
<!-- FOOTER -->
<!-- ========================= -->

<footer>

    © 2026
    <strong class="ms-1 text-danger">
        Blood Bank
    </strong>
    . All Rights Reserved.

</footer>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


</body>

</html>