<?php

session_start();

unset($_SESSION['hid']);
unset($_SESSION['hname']);
unset($_SESSION['hemail']);

session_destroy();

header("Location: hospitalLogin.php");
exit();

?>