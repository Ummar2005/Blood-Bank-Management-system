<?php
session_start();
require 'file/connection.php';

// OPTIONAL: protect admin login
// if(!isset($_SESSION['admin'])){
//     header("Location: admin_login.php");
//     exit();
// }

// Fetch data
$total = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM bloodrequest"));
$accepted = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM bloodrequest WHERE status='Accepted'"));
$rejected = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM bloodrequest WHERE status='Rejected'"));
$pending = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM bloodrequest WHERE status='Pending'"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Simple styling -->
    <style>
        body {
            font-family: Arial;
            margin: 20px;
            background: #f4f6f9;
        }

        h2 {
            text-align: center;
        }

        .cards {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-bottom: 30px;
        }

        .card {
            padding: 20px;
            color: white;
            border-radius: 10px;
            font-size: 18px;
            min-width: 150px;
            text-align: center;
        }

        .blue { background: #007bff; }
        .green { background: #28a745; }
        .red { background: #dc3545; }
        .yellow { background: #ffc107; color: black; }

        .chart-container {
            width: 80%;
            margin: auto;
        }
    </style>
</head>

<body>

<h2>Blood Request Analytics Dashboard</h2>

<!-- DASHBOARD CARDS -->
<div class="cards">
    <div class="card blue">Total<br><?php echo $total; ?></div>
    <div class="card green">Accepted<br><?php echo $accepted; ?></div>
    <div class="card red">Rejected<br><?php echo $rejected; ?></div>
    <div class="card yellow">Pending<br><?php echo $pending; ?></div>
</div>

<!-- BAR CHART -->
<div class="chart-container">
    <canvas id="barChart"></canvas>
</div>

<br><br>

<!-- PIE CHART -->
<div class="chart-container">
    <canvas id="pieChart"></canvas>
</div>

<script>
// BAR CHART
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: ['Total', 'Accepted', 'Rejected', 'Pending'],
        datasets: [{
            label: 'Blood Requests',
            data: [
                <?php echo $total; ?>,
                <?php echo $accepted; ?>,
                <?php echo $rejected; ?>,
                <?php echo $pending; ?>
            ],
            backgroundColor: [
                '#007bff',
                '#28a745',
                '#dc3545',
                '#ffc107'
            ],
            borderRadius: 10
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});

// PIE CHART
new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: ['Accepted', 'Rejected', 'Pending'],
        datasets: [{
            data: [
                <?php echo $accepted; ?>,
                <?php echo $rejected; ?>,
                <?php echo $pending; ?>
            ],
            backgroundColor: ['green','red','orange']
        }]
    }
});
</script>

</body>
</html>