<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Blood Bank Management System</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    
    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{
            background: linear-gradient(135deg,#ff0844,#ff416c);
            min-height:100vh;
            color:white;
        }

        /* NAVBAR */

        .navbar{
            width:100%;
            padding:20px 8%;
            display:flex;
            justify-content:space-between;
            align-items:center;
            background:rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
        }

        .logo{
            font-size:28px;
            font-weight:700;
        }

        .nav-links a{
            color:white;
            text-decoration:none;
            margin-left:25px;
            font-weight:500;
            transition:0.3s;
        }

        .nav-links a:hover{
            color:#ffe5e5;
        }

        /* HERO SECTION */

        .hero{
            width:100%;
            padding:80px 8%;
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
        }

        .hero-text{
            flex:1;
            min-width:300px;
        }

        .hero-text h1{
            font-size:60px;
            line-height:1.2;
            margin-bottom:20px;
        }

        .hero-text p{
            font-size:18px;
            margin-bottom:30px;
            color:#f8f8f8;
        }

        .hero-buttons a{
            display:inline-block;
            padding:14px 30px;
            margin-right:15px;
            border-radius:50px;
            text-decoration:none;
            font-weight:600;
            transition:0.3s;
        }

        .btn-primary{
            background:white;
            color:#ff0844;
        }

        .btn-primary:hover{
            transform:translateY(-3px);
        }

        .btn-secondary{
            border:2px solid white;
            color:white;
        }

        .btn-secondary:hover{
            background:white;
            color:#ff0844;
        }

        /* HERO IMAGE */

        .hero-image{
            flex:1;
            text-align:center;
            min-width:300px;
        }

        .hero-image img{
            width:90%;
            max-width:500px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float{
            0%{transform:translateY(0px);}
            50%{transform:translateY(-15px);}
            100%{transform:translateY(0px);}
        }

        /* BLOOD GROUP CARDS */

        .section-title{
            text-align:center;
            margin-top:30px;
            font-size:40px;
            font-weight:700;
        }

        .blood-container{
            width:100%;
            padding:60px 8%;
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
            gap:25px;
        }

        .blood-card{
            background:rgba(255,255,255,0.12);
            backdrop-filter: blur(10px);
            border-radius:20px;
            padding:30px;
            text-align:center;
            transition:0.4s;
            box-shadow:0 8px 20px rgba(0,0,0,0.2);
        }

        .blood-card:hover{
            transform:translateY(-10px);
            background:rgba(255,255,255,0.2);
        }

        .blood-card h2{
            font-size:45px;
            margin-bottom:10px;
        }

        .blood-card p{
            font-size:15px;
        }

        /* HEALTH TIPS */

        .tips{
            padding:60px 8%;
        }

        .tips-box{
            background:rgba(255,255,255,0.12);
            border-radius:25px;
            padding:40px;
            backdrop-filter:blur(10px);
        }

        .tips h2{
            margin-bottom:25px;
            font-size:35px;
        }

        .tips ul{
            list-style:none;
        }

        .tips ul li{
            margin-bottom:15px;
            font-size:18px;
        }

        .tips ul li i{
            margin-right:10px;
        }

        /* FOOTER */

        footer{
            text-align:center;
            padding:30px;
            margin-top:40px;
            background:rgba(0,0,0,0.1);
        }

        /* RESPONSIVE */

        @media(max-width:900px){

            .hero{
                flex-direction:column;
                text-align:center;
            }

            .hero-text h1{
                font-size:42px;
            }

            .hero-image{
                margin-top:40px;
            }

        }

    </style>
</head>
<body>

    <!-- NAVBAR -->

    <nav class="navbar">
        <div class="logo">
            <i class="fa-solid fa-droplet"></i> Blood Bank
        </div>

        <div class="nav-links">
        <a href="file/donor_login.php">Donor</a>
        <a href="file/hospitalLogin.php">Hospital</a>
        <a href="file/receiverLogin.php">Receiver</a>
        <a href="admin_login.php">Admin</a>
        </div>
    </nav>

    <!-- HERO SECTION -->

    <section class="hero">

        <div class="hero-text">
            <h1>Donate Blood <br> Save Life ❤️</h1>

            <p>
                Blood Bank Management System helps connect donors,
                hospitals and receivers quickly and safely.
            </p>

            <div class="hero-buttons">
                <a href="file/donor_login.php" class="btn-primary"> Donate Now</a>
                <a href="https://www.who.int/" class="btn-secondary">Learn More</a>
            </div>
        </div>

        <div class="hero-image">
            <img src="https://cdn-icons-png.flaticon.com/512/3774/3774299.png">
        </div>

    </section>

    <!-- BLOOD GROUPS -->

    <h1 class="section-title">Available Blood Groups</h1>

    <section class="blood-container">

        <div class="blood-card">
            <h2>A+</h2>
            <p>Available Donors</p>
        </div>

        <div class="blood-card">
            <h2>A-</h2>
            <p>Available Donors</p>
        </div>

        <div class="blood-card">
            <h2>B+</h2>
            <p>Available Donors</p>
        </div>

        <div class="blood-card">
            <h2>B-</h2>
            <p>Available Donors</p>
        </div>

        <div class="blood-card">
            <h2>AB+</h2>
            <p>Available Donors</p>
        </div>

        <div class="blood-card">
            <h2>AB-</h2>
            <p>Available Donors</p>
        </div>

        <div class="blood-card">
            <h2>O+</h2>
            <p>Available Donors</p>
        </div>

        <div class="blood-card">
            <h2>O-</h2>
            <p>Available Donors</p>
        </div>

    </section>

    <!-- HEALTH TIPS -->

    <section class="tips">

        <div class="tips-box">

            <h2>Health Tips</h2>

            <ul>
                <li><i class="fa-solid fa-apple-whole"></i> Eat healthy food</li>
                <li><i class="fa-solid fa-dumbbell"></i> Exercise regularly</li>
                <li><i class="fa-solid fa-ban-smoking"></i> Avoid smoking</li>
                <li><i class="fa-solid fa-glass-water"></i> Drink safe water</li>
                <li><i class="fa-solid fa-heart-pulse"></i> Regular health checkups</li>
            </ul>

        </div>

    </section>

    <!-- FOOTER -->

    <footer>
        © 2026 Blood Bank Management System | Designed with ❤️
    </footer>

</body>
</html>