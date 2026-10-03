<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

require_once "file/connection.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Donor Register</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>


<body class="bg-light">


<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-body p-4">

                    <h2 class="text-center mb-4">
                        🩸 Donor Registration
                    </h2>


                    <form
                        action="file/donorRegister.php"
                        method="POST"
                    >


                        <!-- Name -->

                        <div class="mb-3">

                            <label class="form-label">
                                Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="Enter your name"
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
                                placeholder="Enter your email"
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
                                placeholder="Create a password"
                                required
                            >

                        </div>


                        <!-- Phone -->

                        <div class="mb-3">

                            <label class="form-label">
                                Phone
                            </label>

                            <input
                                type="text"
                                name="phone"
                                class="form-control"
                                placeholder="Enter phone number"
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
                                placeholder="Enter city"
                                required
                            >

                        </div>


                        <!-- Blood Group -->

                        <div class="mb-3">

                            <label class="form-label">
                                Blood Group
                            </label>

                            <select
                                name="bg"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Select Blood Group
                                </option>

                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>

                            </select>

                        </div>


                        <!-- Register Button -->

                        <button
                            type="submit"
                            class="btn btn-success w-100"
                        >

                            Register

                        </button>


                    </form>


                    <!-- Login Link -->

                    <div class="text-center mt-3">

                        Already registered?

                        <a href="file/donor_login.php">
                            Login here
                        </a>

                    </div>


                    <!-- Home Link -->

                    <div class="text-center mt-2">

                        <a
                            href="index.php"
                            class="btn btn-link"
                        >
                            ← Back to Home
                        </a>

                    </div>


                </div>

            </div>

        </div>

    </div>

</div>


</body>

</html>