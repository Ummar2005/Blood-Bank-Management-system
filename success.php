<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Success</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #28a745;
    color: white;
    text-align: center;
    margin-top: 100px;
}
.check {
    font-size: 80px;
    animation: pop 0.5s ease;
}
@keyframes pop {
    0% { transform: scale(0); }
    100% { transform: scale(1); }
}
</style>

</head>

<body>

<div class="check">✅</div>

<h2>Login Successful!</h2>
<p>Redirecting...</p>

<script>
setTimeout(()=>{
    window.location.href = "abs.php";
}, 2000);
</script>

</body>
</html>