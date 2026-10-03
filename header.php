<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Blood Bank</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.dark-mode {
    background-color: #121212;
    color: white;
}
</style>
<style>
.navbar-brand {
    font-weight: bold;
}
</style>

</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
  <div class="container-fluid">

    <!-- LOGO -->
    <a class="navbar-brand" href="#">🩸 Blood Bank</a>

    <!-- TOGGLE -->
     <button onclick="toggleDark()" class="btn btn-dark">🌙</button>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- MENU -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">

        <!-- HOSPITAL MENU -->
        <?php if(isset($_SESSION['hospital'])) { ?>

            <li class="nav-item">
                <a class="nav-link" href="bloodinfo.php">Add Blood</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="blood_request.php">Requests</a>
            </li>

        <?php } ?>

        <!-- RECEIVER MENU -->
        <?php if(isset($_SESSION['receiver'])) { ?>

            <li class="nav-item">
                <a class="nav-link" href="abs.php">Available Blood</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="sentrequest.php">My Requests</a>
            </li>

        <?php } ?>

        <!-- MAP -->
        <li class="nav-item">
            <a class="nav-link" href="map.php">Map</a>
        </li>

        <!-- USER NAME -->
        <?php if(isset($_SESSION['hospital'])) { ?>
            <li class="nav-item">
                <span class="nav-link text-warning">🏥 <?php echo $_SESSION['hospital']; ?></span>
            </li>
        <?php } ?>

        <?php if(isset($_SESSION['receiver'])) { ?>
            <li class="nav-item">
                <span class="nav-link text-warning">👤 <?php echo $_SESSION['receiver']; ?></span>
            </li>
        <?php } ?>

        <!-- LOGOUT -->
        <li class="nav-item">
            <a class="btn btn-dark ms-2" href="logout.php">Logout</a>
        </li>

      </ul>
    </div>

  </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleDark(){
    document.body.classList.toggle("dark-mode");
}
</script>
</body>
</html>