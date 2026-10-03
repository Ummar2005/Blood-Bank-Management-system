<?php

/* ==============================
   ERROR REPORTING
   ============================== */

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


/* ==============================
   START SESSION
   ============================== */

session_start();


/* ==============================
   CHECK EXISTING LOGIN
   ============================== */

if (isset($_SESSION['donor_id'])) {
    header("Location: ../donor_dashboard.php");
    exit();
}


/* ==============================
   DATABASE CONNECTION
   ============================== */

$host = "sql304.infinityfree.com";
$user = "if0_42840327";
$password = "YOUR_DATABASE_PASSWORD";
$database = "if0_42840327_blood_bank";

$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $database
);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


/* ==============================
   LOGIN
   ============================== */

$error = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password_input = $_POST['password'];

    /* Prepared statement */
    $stmt = mysqli_prepare(
        $conn,
        "SELECT * FROM donor WHERE email = ? LIMIT 1"
    );

    if (!$stmt) {
        die("Database query error: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);

        /* Check password */

        if (password_verify($password_input, $row['password'])) {

            $_SESSION['donor_id'] = $row['donor_id'];
            $_SESSION['donor_name'] = $row['name'];

            header("Location: ../donor_dashboard.php");
            exit();

        } else {

            $error = "Invalid Password!";

        }

    } else {

        $error = "Email Not Registered!";

    }

    mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Donor Login</title>


    <!-- Google Font -->

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >


    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #ff0844, #ff416c);
            padding: 20px;
        }

        .container {
            width: 400px;
            max-width: 100%;

            background: rgba(255, 255, 255, 0.12);

            backdrop-filter: blur(15px);

            border-radius: 25px;

            padding: 40px;

            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);

            color: white;

            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {

            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }

        .logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo i {
            font-size: 55px;
            margin-bottom: 10px;
        }

        .logo h1 {
            font-size: 32px;
            font-weight: 700;
        }

        .input-box {
            position: relative;
            margin-bottom: 20px;
        }

        .input-box input {
            width: 100%;

            padding: 14px 45px;

            border: none;

            outline: none;

            border-radius: 50px;

            background: rgba(255, 255, 255, 0.2);

            color: white;

            font-size: 15px;
        }

        .input-box input::placeholder {
            color: #f1f1f1;
        }

        .input-box i {
            position: absolute;

            top: 15px;

            left: 18px;

            color: white;
        }

        .btn {
            width: 100%;

            padding: 14px;

            border: none;

            border-radius: 50px;

            background: white;

            color: #ff0844;

            font-size: 16px;

            font-weight: 600;

            cursor: pointer;

            transition: 0.3s;
        }

        .btn:hover {
            transform: translateY(-3px);

            background: #ffe5e5;
        }

        .links {
            margin-top: 20px;

            text-align: center;
        }

        .links a {
            color: white;

            text-decoration: none;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .error {
            background: rgba(255, 255, 255, 0.2);

            padding: 12px;

            border-radius: 10px;

            text-align: center;

            margin-bottom: 15px;

            color: white;
        }

    </style>

</head>


<body>


    <div class="container">


        <div class="logo">

            <i class="fa-solid fa-droplet"></i>

            <h1>Donor Login</h1>

        </div>


        <?php if ($error != ""): ?>

            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>


        <form method="POST">


            <div class="input-box">

                <i class="fa-solid fa-envelope"></i>

                <input
                    type="email"
                    name="email"
                    placeholder="Enter Email"
                    required
                >

            </div>


            <div class="input-box">

                <i class="fa-solid fa-lock"></i>

                <input
                    type="password"
                    name="password"
                    placeholder="Enter Password"
                    required
                >

            </div>


            <button
                type="submit"
                name="login"
                class="btn"
            >
                Login
            </button>


        </form>


        <div class="links">

            <p>

                Don't have an account?

                <a href="../donor_register.php">
                    Register
                </a>

            </p>

        </div>


    </div>


</body>

</html>