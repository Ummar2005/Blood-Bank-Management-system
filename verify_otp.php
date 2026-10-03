<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
<title>Verify OTP</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card p-4 shadow col-md-4 mx-auto">

<h4 class="text-center">Verify OTP</h4>

<?php if(isset($_SESSION['msg'])){ ?>
<div class="alert alert-info">
<?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?>
</div>
<?php } ?>

<form action="check_otp.php" method="post">

<input type="text" name="otp" class="form-control mb-3" placeholder="Enter OTP" required>

<button class="btn btn-success w-100">Verify</button>

</form>

</div>

</div>

</body>
</html>