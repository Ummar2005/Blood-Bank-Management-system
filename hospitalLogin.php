<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Hospital Login</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(to right, #11998e, #38ef7d);
    height: 100vh;
}
.card {
    border-radius: 15px;
}
</style>

</head>
<body>

<div class="container h-100 d-flex justify-content-center align-items-center">
    <div class="col-md-4">
        <div class="card p-4 shadow">

            <h3 class="text-center mb-3">🏥 Hospital Login</h3>
        
            <!-- ERROR MESSAGE -->
            <?php if(isset($_GET['error'])){ ?>
                <div class="alert alert-danger">
                    <?php echo $_GET['error']; ?>
                </div>
            <?php } ?>

            <form action="hospitalLoginCheck.php" method="POST">

                <input type="email" name="email" class="form-control mb-3" placeholder="Enter Email" required>

                <input type="password" name="password" class="form-control mb-3" placeholder="Enter Password" required>

                <button type="submit" name="login" class="btn btn-success w-100">Login</button>

            </form>
            
            <div class="text-center mt-3">
                <a href="../index.php" class="btn btn-link">⬅ Back to Home</a>
                 <a href="hospitalReg.php" class="btn btn-link">register</a>
                <a href="hospitalLogin.php" class="btn btn-link">Login</a>
                <a href="../bloodinfo.php" class="btn btn-link">info</a>
            </div>

        </div>
    </div>
</div>

</body>
</html>