<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Receiver Login (OTP)</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }
        .login-box {
            width: 400px;
            margin: 80px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px #ccc;
        }
    </style>
</head>

<body>

<div class="login-box">

    <h3 class="text-center mb-4">Receiver Login (OTP)</h3>

    <!-- SUCCESS / ERROR MESSAGE -->
    <?php if(isset($_SESSION['msg'])) { ?>
        <div class="alert alert-info">
            <?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?>
        </div>
    <?php } ?>

    <!-- OTP FORM -->
    <form action="send_otp.php" method="post">

        <div class="mb-3">
            <label>Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Send OTP
        </button>

    </form>

    <hr>

    <p class="text-center">
        Don't have account? <a href="register.php">Register</a>
    </p>

</div>

</body>
</html>