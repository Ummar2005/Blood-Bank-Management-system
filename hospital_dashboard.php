<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

require_once "file/connection.php";


// Check hospital login
if (!isset($_SESSION['hid'])) {
    header("Location: file/hospitalLogin.php");
    exit();
}

$hid = $_SESSION['hid'];


// Get blood requests for this hospital
$stmt = mysqli_prepare(
    $conn,
    "SELECT reqid, hid, rid, bg, status
     FROM bloodrequest
     WHERE hid = ?
     ORDER BY reqid DESC"
);

if (!$stmt) {
    die("SQL Prepare Error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $hid);

mysqli_stmt_execute($stmt);

$res = mysqli_stmt_get_result($stmt);

if (!$res) {
    die("SQL Query Error: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Hospital Dashboard</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body class="bg-light">

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3>🏥 Hospital Dashboard</h3>

        <a
            href="file/hospitalLogout.php"
            class="btn btn-danger"
        >
            Logout
        </a>

    </div>


    <div class="card shadow">

        <div class="card-body">

            <h5 class="mb-3">
                🩸 Blood Requests
            </h5>


            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-dark">

                        <tr>
                            <th>Request ID</th>
                            <th>Receiver ID</th>
                            <th>Blood Group</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>

                    </thead>


                    <tbody>

                    <?php if (mysqli_num_rows($res) > 0): ?>

                        <?php while ($r = mysqli_fetch_assoc($res)): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($r['reqid']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($r['rid']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($r['bg']) ?>
                                </td>

                                <td>

                                    <?php if ($r['status'] == "Pending"): ?>

                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                    <?php elseif ($r['status'] == "Approved"): ?>

                                        <span class="badge bg-success">
                                            Approved
                                        </span>

                                    <?php elseif ($r['status'] == "Rejected"): ?>

                                        <span class="badge bg-danger">
                                            Rejected
                                        </span>

                                    <?php else: ?>

                                        <?= htmlspecialchars($r['status']) ?>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <?php if ($r['status'] == "Pending"): ?>

                                        <a
                                            href="file/accept.php?reqid=<?= urlencode($r['reqid']) ?>"
                                            class="btn btn-success btn-sm"
                                        >
                                            Accept
                                        </a>

                                        <a
                                            href="file/reject.php?reqid=<?= urlencode($r['reqid']) ?>"
                                            class="btn btn-danger btn-sm"
                                        >
                                            Reject
                                        </a>

                                    <?php else: ?>

                                        <span class="text-muted">
                                            No Action
                                        </span>

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="5" class="text-center">
                                No blood requests found.
                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>

</html>