<?php
include('include/db_connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Ziora Luxeon</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Lora:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #000000;
            color: #D8D8D8;
            overflow-x: hidden;
        }
        html, body {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.about-section {
    flex: 1; /* Pushes footer down */
}

        header {
            background: rgba(42, 42, 42, 0.95);
            padding: 15px 50px;
            display: flex;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            border-radius: 50px;
            max-width: 1200px;
            box-sizing: border-box;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        .logo {
    display: flex;
    align-items: center;
    gap: 10px; /* Space between logo and text */
}

.logo img {
    height: 40px;  /* Smaller size */
    width: 40px;
    border-radius: 50%; /* Makes it circular */
    object-fit: cover; /* Ensures proper fit inside circle */
    border: 2px solid #D4AF37; /* Optional: Gold border around logo */
}

.logo-text {
    font-size: 1.2em;
    font-family: 'Lora', serif;
    color: #D4AF37;
    text-transform: uppercase;
}



header .logo {
    font-size: 2em;
    font-family: 'Lora', serif;
    color: #D4AF37;
    text-transform: uppercase;
    
}
        header .logo {
            font-size: 2em;
            font-family: 'Lora', serif;
            color: #D4AF37;
            text-transform: uppercase;
            margin-right: 50px;
        }

        header .navbar-nav {
            list-style: none;
            display: flex;
            gap: 15px;
            margin: 0;
            padding: 0;
            flex: 1;
            justify-content: center;
        }

        header .navbar-nav li a {
            font-size: 0.9em;
            color: #D8D8D8;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 25px;
            text-transform: uppercase;
            font-weight: 500;
            transition: all 0.3s ease;
            background: rgba(26, 26, 26, 0.5);
        }

        header .navbar-nav li a:hover,
        header .navbar-nav li a.active {
            background-color: #D4AF37;
            color: #1a1a1a;
            transform: translateY(-2px);
        }

        .header-scrolled {
            top: 0;
            border-radius: 0 0 50px 50px;
            background: rgba(26, 26, 26, 0.98);
        }

        .about-section {
            padding: 120px 20px 100px;
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeInDown 1s ease-out forwards 0.5s;
        }

        .about-section h2 {
            font-size: 3em;
            font-weight: 700;
            color: #D4AF37;
            margin-bottom: 20px;
        }

        .about-section p {
            font-size: 1.2em;
            line-height: 1.8;
            color: #D8D8D8;
            margin-bottom: 20px;
        }

       

        footer {
            background: #1a1a1a;
            color: #D4AF37;
            font-size: 1.2em;
            text-align: center;
            padding: 20px 0;
            width: 100%;
        }

        @keyframes fadeInDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            header {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
            }

            header .navbar-nav {
                flex-wrap: wrap;
                justify-content: center;
            }

            .about-section h2 {
                font-size: 2.5em;
            }

            .about-section p {
                font-size: 1.1em;
            }
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
        <img src="assets/images/logo.png" alt="Ziora Luxeon Logo" class="logo-img">
    </a>
    <span class="logo-text">Ziora Luxeon</span>
</div>
        <ul class="navbar-nav">
            <li><a href="./index.php">Home</a></li>
            <li><a href="./login.php">Login</a></li>
            <li><a href="./product.php">Products</a></li>
            <li><a href="./cart.php">Cart</a></li>
            <li><a href="./contact.php">Contact</a></li>
            <li><a href="./about.php" class="active">About Us</a></li>
        </ul>
    </header>

    <section class="about-section">
        <h2>About Ziora Luxeon</h2>
        <p>Welcome to Ziora Luxeon, where time meets elegance. Our brand is dedicated to crafting luxurious timepieces that blend heritage, innovation, and artistry.</p>
        <p>At Ziora Luxeon, we believe that a watch is more than just an accessory—it's a statement of refinement, prestige, and timeless sophistication.</p>
        <p>Each watch in our collection is meticulously designed with precision engineering, premium materials, and an eye for perfection. Whether you're looking for a classic statement piece or a modern masterpiece, Ziora Luxeon delivers excellence.</p>
        <p>Join us on our journey to redefine luxury—one second at a time.</p>
    </section>


    <footer>
        <p>&copy; 2025 Ziora Luxeon. All rights reserved.</p>
    </footer>

    <script>
        $(document).ready(function() {
            // Scroll effect for header
            $(window).scroll(function() {
                if ($(this).scrollTop() > 100) {
                    $('header').addClass('header-scrolled');
                } else {
                    $('header').removeClass('header-scrolled');
                }
            });
        });
    </script>
</body>
</html>
