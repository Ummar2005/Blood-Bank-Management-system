<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

require_once "file/connection.php";


/*
|--------------------------------------------------------------------------
| Check Donor Login
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['donor_id'])) {

    header("Location: file/donor_login.php");
    exit();

}


/*
|--------------------------------------------------------------------------
| Success message
|--------------------------------------------------------------------------
*/

$success = isset($_GET['success']);


/*
|--------------------------------------------------------------------------
| Get low blood stock
|--------------------------------------------------------------------------
*/

$res = mysqli_query(
    $conn,
    "SELECT * FROM blood_stock WHERE units <= 3"
);

if (!$res) {

    die(
        "Blood stock query failed: " .
        mysqli_error($conn)
    );

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Donor Dashboard</title>

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>


<body class="bg-light">


<div class="container mt-4">


    <!-- Header -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3 class="mb-0">
            🧑 Donor Dashboard
        </h3>


        <a
            href="file/donorLogout.php"
            class="btn btn-danger"
        >
            🚪 Logout
        </a>

    </div>


    <!-- Success Message -->

    <?php if ($success): ?>

        <div class="alert alert-success">

            ✅ Donate Successfully!

        </div>

    <?php endif; ?>


    <!-- Blood Shortage -->

    <h5 class="text-danger mt-4">

        ⚠ Blood Shortage

    </h5>


    <table class="table table-bordered table-hover bg-white">

        <thead class="table-dark">

            <tr>

                <th>Blood</th>

                <th>Units</th>

            </tr>

        </thead>


        <tbody>

        <?php while ($r = mysqli_fetch_assoc($res)): ?>

            <tr>

                <td>
                    <?= htmlspecialchars($r['blood_group']) ?>
                </td>


                <td>
                    <?= htmlspecialchars($r['units']) ?>
                </td>

            </tr>

        <?php endwhile; ?>

        </tbody>

    </table>


    <hr>


    <!-- Donate Blood -->

    <h5 class="mb-3">

        🩸 Donate Blood

    </h5>


    <form
        action="file/donate_blood.php"
        method="POST"
    >


        <select
            name="blood_group"
            class="form-control mb-2"
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


        <input
            type="number"
            name="units"
            placeholder="Units"
            class="form-control mb-2"
            min="1"
            required
        >


        <button
            type="submit"
            class="btn btn-primary"
        >

            Donate

        </button>


    </form>


</div>


</body>

</html>