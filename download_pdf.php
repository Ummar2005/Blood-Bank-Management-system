<?php

ob_start();

error_reporting(0);
ini_set('display_errors', 0);

require_once __DIR__ . "/file/connection.php";
require_once __DIR__ . "/fpdf/fpdf.php";

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();


// =========================
// TITLE
// =========================

$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(0, 10, 'BLOOD BANK REPORT', 0, 1, 'C');

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 7, 'Blood Bank Management System', 0, 1, 'C');

$pdf->Ln(5);


// =========================
// REQUEST SUMMARY
// =========================

$total = 0;
$pending = 0;
$accepted = 0;
$rejected = 0;


// Total
$result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM bloodrequest"
);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $total = $row['total'];
}


// Pending
$result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM bloodrequest
     WHERE status = 'Pending'"
);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $pending = $row['total'];
}


// Accepted
$result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM bloodrequest
     WHERE status = 'Approved'"
);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $accepted = $row['total'];
}


// Rejected
$result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM bloodrequest
     WHERE status = 'Rejected'"
);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $rejected = $row['total'];
}


// Display summary
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, 'Request Summary', 0, 1);

$pdf->SetFont('Arial', '', 11);

$pdf->Cell(50, 8, 'Total Requests:', 0, 0);
$pdf->Cell(30, 8, $total, 0, 1);

$pdf->Cell(50, 8, 'Pending:', 0, 0);
$pdf->Cell(30, 8, $pending, 0, 1);

$pdf->Cell(50, 8, 'Accepted:', 0, 0);
$pdf->Cell(30, 8, $accepted, 0, 1);

$pdf->Cell(50, 8, 'Rejected:', 0, 0);
$pdf->Cell(30, 8, $rejected, 0, 1);

$pdf->Ln(7);


// =========================
// BLOOD REQUESTS
// =========================

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, 'All Blood Requests', 0, 1);

$pdf->SetFont('Arial', 'B', 9);

$pdf->Cell(25, 8, 'Request ID', 1);
$pdf->Cell(25, 8, 'Hospital ID', 1);
$pdf->Cell(25, 8, 'Receiver ID', 1);
$pdf->Cell(30, 8, 'Blood Group', 1);
$pdf->Cell(35, 8, 'Status', 1);

$pdf->Ln();


$request_result = mysqli_query(
    $conn,
    "SELECT reqid, hid, rid, bg, status
     FROM bloodrequest
     ORDER BY reqid DESC"
);

$pdf->SetFont('Arial', '', 9);

if ($request_result && mysqli_num_rows($request_result) > 0) {

    while ($row = mysqli_fetch_assoc($request_result)) {

        $pdf->Cell(25, 8, $row['reqid'], 1);
        $pdf->Cell(25, 8, $row['hid'], 1);
        $pdf->Cell(25, 8, $row['rid'], 1);
        $pdf->Cell(30, 8, $row['bg'], 1);
        $pdf->Cell(35, 8, $row['status'], 1);

        $pdf->Ln();
    }

} else {

    $pdf->Cell(
        140,
        8,
        'No blood requests found',
        1,
        1,
        'C'
    );
}


$pdf->Ln(8);


// =========================
// REGISTERED HOSPITALS
// =========================

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, 'Registered Hospitals', 0, 1);

$pdf->SetFont('Arial', 'B', 9);

$pdf->Cell(18, 8, 'ID', 1);
$pdf->Cell(45, 8, 'Hospital Name', 1);
$pdf->Cell(55, 8, 'Email', 1);
$pdf->Cell(35, 8, 'City', 1);

$pdf->Ln();


$hospital_result = mysqli_query(
    $conn,
    "SELECT hospital_id, hospital_name, email, city
     FROM hospitals
     ORDER BY hospital_id DESC"
);

$pdf->SetFont('Arial', '', 8);

if ($hospital_result && mysqli_num_rows($hospital_result) > 0) {

    while ($hospital = mysqli_fetch_assoc($hospital_result)) {

        $name = substr($hospital['hospital_name'], 0, 28);
        $email = substr($hospital['email'], 0, 32);
        $city = substr($hospital['city'], 0, 20);

        $pdf->Cell(18, 8, $hospital['hospital_id'], 1);
        $pdf->Cell(45, 8, $name, 1);
        $pdf->Cell(55, 8, $email, 1);
        $pdf->Cell(35, 8, $city, 1);

        $pdf->Ln();
    }

} else {

    $pdf->Cell(
        153,
        8,
        'No hospitals found',
        1,
        1,
        'C'
    );
}


// =========================
// SEND PDF
// =========================

while (ob_get_level() > 0) {
    ob_end_clean();
}

$pdf->Output('I', 'blood_bank_report.pdf');

exit;

?>