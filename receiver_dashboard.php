<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

require_once "file/connection.php";


// --------------------------------------------------
// Check receiver login
// --------------------------------------------------

if (!isset($_SESSION['rid'])) {

    header("Location: file/receiverLogin.php");
    exit();

}


$rid = (int)$_SESSION['rid'];

$receiver_name = $_SESSION['rname'] ?? 'Receiver';


// --------------------------------------------------
// Message
// --------------------------------------------------

$msg = $_GET['msg'] ?? '';


// --------------------------------------------------
// Get blood stock
// --------------------------------------------------

$sql = "
    SELECT
        blood_stock.hospital_id,
        blood_stock.blood_group,
        blood_stock.units,
        hospitals.hospital_name
    FROM blood_stock
    INNER JOIN hospitals
        ON blood_stock.hospital_id = hospitals.hospital_id
    WHERE blood_stock.units > 0
    ORDER BY hospitals.hospital_name
";


$res = mysqli_query($conn, $sql);


if (!$res) {

    die("Blood stock query failed: " . mysqli_error($conn));

}

?>


<!DOCTYPE html>
<html>

<head>

    <title>Receiver Dashboard</title>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            background: #f5f6f8;
        }

        .dashboard-title {
            font-weight: 600;
        }

        .card {
            border-radius: 15px;
        }

        .blood-badge {
            font-size: 14px;
        }

    </style>

</head>


<body>


<div class="container mt-5">


    <!-- HEADER -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="dashboard-title">
                🧑‍⚕️ Receiver Dashboard
            </h2>

            <p class="mb-0">
                Welcome,
                <strong>
                    <?= htmlspecialchars($receiver_name) ?>
                </strong>
            </p>

        </div>


        <a
            href="file/receiverLogout.php"
            class="btn btn-danger"
        >
            Logout
        </a>

    </div>



    <!-- SUCCESS MESSAGE -->

    <?php if ($msg == "sent"): ?>

        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert"
        >

            <strong>
                ✅ Request Sent Successfully!
            </strong>

            Your blood request has been sent to the hospital.

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    <?php endif; ?>



    <!-- ALREADY REQUESTED -->

    <?php if ($msg == "already"): ?>

        <div
            class="alert alert-warning alert-dismissible fade show"
            role="alert"
        >

            <strong>
                ⚠ Request Already Sent!
            </strong>

            You already have a pending request for this blood group.

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    <?php endif; ?>



    <!-- AVAILABLE BLOOD STOCK -->

    <div class="card shadow">

        <div class="card-body p-4">

            <h3 class="mb-4">
                🩸 Available Blood Stock
            </h3>


            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">


                    <thead class="table-dark">

                        <tr>

                            <th>Hospital</th>

                            <th>Blood Group</th>

                            <th>Units</th>

                            <th>Action</th>

                        </tr>

                    </thead>


                    <tbody>


                    <?php if (mysqli_num_rows($res) > 0): ?>


                        <?php while ($row = mysqli_fetch_assoc($res)): ?>


                            <tr>


                                <td>
                                    <?= htmlspecialchars(
                                        $row['hospital_name']
                                    ) ?>
                                </td>


                                <td>

                                    <span class="badge bg-danger blood-badge">

                                        <?= htmlspecialchars(
                                            $row['blood_group']
                                        ) ?>

                                    </span>

                                </td>


                                <td>

                                    <?= htmlspecialchars(
                                        $row['units']
                                    ) ?>

                                </td>


                                <td>

                                    <a
                                        href="file/sendrequest.php?hid=<?= urlencode($row['hospital_id']) ?>&bg=<?= urlencode($row['blood_group']) ?>"
                                        class="btn btn-success btn-sm"
                                    >
                                        Request
                                    </a>
                                    <a href="file/receiverLogout.php" class="btn btn-danger">
                                          Logout
                                   </a>
                                </td>


                            </tr>


                        <?php endwhile; ?>


                    <?php else: ?>


                        <tr>

                            <td
                                colspan="4"
                                class="text-center"
                            >

                                No blood stock available.

                            </td>

                        </tr>


                    <?php endif; ?>


                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- HOSPITAL MAP -->

    <div class="mt-4">

        <a
            href="hospitalmap.php"
            class="btn btn-info"
        >
            🗺️ View Hospital Map
        </a>

    </div>


</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>


</body>

</html>