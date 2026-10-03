<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

/* ==============================
   DATABASE CONNECTION
   ============================== */
require_once __DIR__ . "/file/connection.php";

/* ==============================
   ADMIN LOGIN CHECK
   ============================== */
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}


/* ==============================
   COUNT BLOOD REQUESTS
   ============================== */

// Total requests
$result_total = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM bloodrequest"
);

$total = 0;

if ($result_total) {
    $row_total = mysqli_fetch_assoc($result_total);
    $total = $row_total['total'];
}


// Accepted requests
$result_accepted = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM bloodrequest
     WHERE status = 'Accepted'"
);

$accepted = 0;

if ($result_accepted) {
    $row_accepted = mysqli_fetch_assoc($result_accepted);
    $accepted = $row_accepted['total'];
}


// Rejected requests
$result_rejected = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM bloodrequest
     WHERE status = 'Rejected'"
);

$rejected = 0;

if ($result_rejected) {
    $row_rejected = mysqli_fetch_assoc($result_rejected);
    $rejected = $row_rejected['total'];
}


// Pending requests
$result_pending = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM bloodrequest
     WHERE status = 'Pending'"
);

$pending = 0;

if ($result_pending) {
    $row_pending = mysqli_fetch_assoc($result_pending);
    $pending = $row_pending['total'];
}


/* ==============================
   GET HOSPITALS
   ============================== */

$hospital_result = mysqli_query(
    $conn,
    "SELECT
        hospital_id,
        hospital_name,
        email,
        phone,
        city
     FROM hospitals
     ORDER BY hospital_id DESC"
);

if (!$hospital_result) {
    die("Hospital Query Error: " . mysqli_error($conn));
}


/* ==============================
   GET BLOOD REQUESTS
   ============================== */

$request_result = mysqli_query(
    $conn,
    "SELECT
        reqid,
        hid,
        rid,
        bg,
        status
     FROM bloodrequest
     ORDER BY reqid DESC"
);

if (!$request_result) {
    die("Request Query Error: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - Blood Bank</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            background-color: #f5f6fa;
        }

        .navbar {
            background: #dc3545;
        }

        .navbar-brand {
            color: white !important;
            font-weight: bold;
        }

        .admin-name {
            color: white;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .stat-card {
            color: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.10);
        }

        .total-card {
            background: #0d6efd;
        }

        .accepted-card {
            background: #198754;
        }

        .rejected-card {
            background: #dc3545;
        }

        .pending-card {
            background: #ffc107;
            color: #212529;
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .table th {
            background-color: #212529;
            color: white;
        }

        .badge {
            font-size: 13px;
            padding: 8px 12px;
        }

    </style>

</head>


<body>


<!-- ==============================
     NAVBAR
     ============================== -->

<nav class="navbar navbar-expand-lg">

    <div class="container">

        <a class="navbar-brand" href="admin_dashboard.php">
            🩸 Blood Bank - Admin
        </a>

        <div>

            <span class="admin-name me-3">
                👤 Admin
            </span>

            <a
                href="logout.php"
                class="btn btn-light btn-sm"
            >
                Logout
            </a>

        </div>

    </div>

</nav>


<!-- ==============================
     MAIN CONTAINER
     ============================== -->

<div class="container mt-4">


    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2>
                🛠️ Admin Dashboard
            </h2>

            <p class="text-muted">
                Manage hospitals and blood requests
            </p>

        </div>

        <a
            href="download_pdf.php"
            class="btn btn-primary"
        >
            📄 Download Report
        </a>

    </div>


    <!-- ==============================
         STATISTICS
         ============================== -->

    <div class="row g-4 mb-5">


        <!-- Total -->

        <div class="col-md-3">

            <div class="stat-card total-card">

                <h5>
                    🩸 Total Requests
                </h5>

                <div class="stat-number">
                    <?php echo $total; ?>
                </div>

            </div>

        </div>


        <!-- Accepted -->

        <div class="col-md-3">

            <div class="stat-card accepted-card">

                <h5>
                    ✅ Accepted
                </h5>

                <div class="stat-number">
                    <?php echo $accepted; ?>
                </div>

            </div>

        </div>


        <!-- Rejected -->

        <div class="col-md-3">

            <div class="stat-card rejected-card">

                <h5>
                    ❌ Rejected
                </h5>

                <div class="stat-number">
                    <?php echo $rejected; ?>
                </div>

            </div>

        </div>


        <!-- Pending -->

        <div class="col-md-3">

            <div class="stat-card pending-card">

                <h5>
                    ⏳ Pending
                </h5>

                <div class="stat-number">
                    <?php echo $pending; ?>
                </div>

            </div>

        </div>

    </div>


    <!-- ==============================
         HOSPITALS
         ============================== -->

    <div class="card shadow mb-5">

        <div class="card-body">

            <h4 class="section-title">
                🏥 Registered Hospitals
            </h4>


            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Hospital Name</th>

                            <th>Email</th>

                            <th>Phone</th>

                            <th>City</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php

                    if (mysqli_num_rows($hospital_result) > 0) {

                        while ($hospital = mysqli_fetch_assoc($hospital_result)) {

                    ?>

                        <tr>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $hospital['hospital_id']
                                );
                                ?>
                            </td>

                            <td>
                                🏥
                                <?php
                                echo htmlspecialchars(
                                    $hospital['hospital_name']
                                );
                                ?>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $hospital['email']
                                );
                                ?>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $hospital['phone']
                                );
                                ?>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $hospital['city']
                                );
                                ?>
                            </td>

                        </tr>

                    <?php

                        }

                    } else {

                    ?>

                        <tr>

                            <td
                                colspan="5"
                                class="text-center text-muted"
                            >
                                No hospitals registered.

                            </td>

                        </tr>

                    <?php

                    }

                    ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>



    <!-- ==============================
         BLOOD REQUESTS
         ============================== -->

    <div class="card shadow mb-5">

        <div class="card-body">

            <h4 class="section-title">
                🩸 All Blood Requests
            </h4>


            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead>

                        <tr>

                            <th>Request ID</th>

                            <th>Hospital ID</th>

                            <th>Receiver ID</th>

                            <th>Blood Group</th>

                            <th>Status</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php

                    if (mysqli_num_rows($request_result) > 0) {

                        while ($request = mysqli_fetch_assoc($request_result)) {

                    ?>

                        <tr>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $request['reqid']
                                );
                                ?>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $request['hid']
                                );
                                ?>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $request['rid']
                                );
                                ?>
                            </td>

                            <td>

                                <span class="badge bg-danger">

                                    <?php
                                    echo htmlspecialchars(
                                        $request['bg']
                                    );
                                    ?>

                                </span>

                            </td>


                            <td>

                                <?php

                                $status = $request['status'];

                                if ($status == "Accepted") {

                                ?>

                                    <span class="badge bg-success">
                                        ✅ Accepted
                                    </span>

                                <?php

                                } elseif ($status == "Rejected") {

                                ?>

                                    <span class="badge bg-danger">
                                        ❌ Rejected
                                    </span>

                                <?php

                                } else {

                                ?>

                                    <span class="badge bg-warning text-dark">
                                        ⏳ Pending
                                    </span>

                                <?php

                                }

                                ?>

                            </td>

                        </tr>

                    <?php

                        }

                    } else {

                    ?>

                        <tr>

                            <td
                                colspan="5"
                                class="text-center text-muted"
                            >
                                No blood requests found.

                            </td>

                        </tr>

                    <?php

                    }

                    ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>


</div>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>