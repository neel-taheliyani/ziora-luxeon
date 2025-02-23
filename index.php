<?php
include('include/db_connection.php');
$query = "SELECT * FROM products LIMIT 3"; 
$result = mysqli_query($conn, $query);
$products = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
} else {
    $products = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ziora Luxeon - Luxury Watch Collection</title>
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

        header .navbar-nav li a:hover {
            background-color: #D4AF37;
            color: #1a1a1a;
            transform: translateY(-2px);
        }

        header .navbar-nav li a.active {
            background-color: #D4AF37;
            color: #1a1a1a;
            font-weight: bold;
        }

        .header-scrolled {
            top: 0;
            border-radius: 0 0 50px 50px;
            background: rgba(26, 26, 26, 0.98);
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

      /* Hero Section with Video Background */
      .hero {
    position: relative;
    width: 100%;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    overflow: hidden;
}

.hero.visible {
    opacity: 1;
    transform:scale(1) translateY(0);
}
.hero-video {
    min-width: 100%;
    min-height: 100%;
    object-fit: cover;
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100vw;
    height: 100vh;
    object-fit: cover; /* Ensures the video covers the full section */
    transform: translate(-50%, -50%);
    z-index: -1;
    x: -1;
}

.hero-overlay {
    position: relative;
    z-index: 2;
    color: #D4AF37;
    text-align: center;
    backdrop-filter: blur(5px);
    padding: 20px;
}

.hero-overlay h1 {
    font-size: 4em;
    font-family: 'Lora', serif;
    margin-bottom: 10px;
    text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.8); 
    
}

.hero-overlay p {
    font-size: 1.5em;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8);
}

.hero-overlay .btn {
    padding: 12px 30px;
    background: #1a1a1a;
    color: #D4AF37;
    text-decoration: none;
    font-weight: bold;
    border-radius: 25px;
    font-size: 1.1em;
    transition: all 0.3s ease;
}

.hero-overlay .btn:hover {
    background: #D4AF37;
    color: #1a1a1a;
    transform: translateY(-2px);
}
/* Smooth Scrolling */
html {
    scroll-behavior: smooth;
}

/* Scroll Animation */
.scroll-effect {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease-in-out;
}

.scroll-effect.visible {
    opacity: 1;
    transform: translateY(0);
}


        .products-section {
            padding: 60px 20px;
            background-color: #333;
            text-align: center;
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeInDown 1s ease-out forwards 1s;
        }

        .products-section h2 {
            font-size: 3em;
            font-weight: 700;
            color: #D4AF37;
            margin-bottom: 40px;
        }

        .carousel-container {
            position: relative;
            overflow: hidden;
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            border-radius: 15px;
        }

        .carousel {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .carousel-item {
            min-width: 100%;
            box-sizing: border-box;
            text-align: center;
            background: #2c2c2c;
            padding: 20px;
            border-radius: 15px;
            transition: transform 0.3s ease;
        }

        .carousel-item:hover {
            transform: scale(1.02);
        }

        .carousel-item img {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .carousel-item h3 {
            font-size: 1.5em;
            margin: 15px 0;
            color: #D4AF37;
        }

        .carousel-item p {
            font-size: 1.1em;
            color: #f1f1f1;
        }

        .prev-btn,
        .next-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            border: none;
            color: #fff;
            font-size: 2em;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 50%;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .prev-btn {
            left: 10px;
        }

        .next-btn {
            right: 10px;
        }

        .prev-btn:hover,
        .next-btn:hover {
            background: #D4AF37;
            color: #1a1a1a;
            transform: translateY(-50%) scale(1.1);
        }

        footer {
            background: #1a1a1a;
            color: #D4AF37;
            font-size: 1.5em;
            text-align: center;
            padding: 20px 0;
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeInDown 1s ease-out forwards 1.5s;
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

            .hero h1 {
                font-size: 2.5em;
            }

            .hero p {
                font-size: 1.2em;
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
            <li><a href="./index.php"class="active">Home</a></li>
            <li><a href="./login.php">Login</a></li>
            <li><a href="./product.php">Products</a></li>
            <li><a href="./cart.php">Cart</a></li>
            <li><a href="./contact.php">Contact</a></li>
            <li><a href="./about.php" >About Us</a></li>
        </ul>
    </header>

 
    <section class="hero" id="home">
    <!-- Background Video -->
    <video autoplay muted loop playsinline class="hero-video">
        <source src="assets/videos/vid1.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Hero Content (Text & Button) -->
    <div class="hero-overlay">
        <h1>Don't Dream, Wear It</h1>
        <p>Defining Luxury, Defining You</p>
        <a href="product.php" class="btn">Shop Now</a>
    </div>
</section>


    <section class="products-section" id="products">
        <h2>Deal of the Day</h2>
        <div class="carousel-container">
            <div class="carousel">
                <?php
                foreach ($products as $product) {
                    echo '
                    <div class="carousel-item">
                        <img src="images/' . $product['image'] . '" alt="' . $product['name'] . '">
                        <h3>' . $product['name'] . '</h3>
                        <p>Price: ₹' . number_format($product['price'], 2) . '</p>
                    </div>';
                }

                $additionalProducts = [
                    ['name' => 'Shree Ram Janmbhumi Edition', 'price' => 3400000, 'image' => 'assets/images/shreeram.png', 'description' => 'Celebrate the legacy of Shree Ram with this limited edition luxury timepiece.'],
                    ['name' => 'Patek Philippe Aquanaut', 'price' => 5000000, 'image' => 'assets/images/patekphilliphoragnedial.png', 'description' => 'Discover the perfect fusion of elegance and adventure with the Patek Philippe Aquanaut.'],
                    ['name' => 'Tommy Hilfiger', 'price' => 1100000, 'image' => 'assets/images/tommyhilfiger.png', 'description' => 'Timeless elegance for every occasion.'],
                ];

                foreach ($additionalProducts as $product) {
                    echo '
                    <div class="carousel-item">
                        <img src="' . $product['image'] . '" alt="' . $product['name'] . '">
                        <h3>' . $product['name'] . '</h3>
                        <p>Price: ₹' . number_format($product['price'], 2) . '</p>
                    </div>';
                }
                ?>
            </div>
            <button class="prev-btn">&#10094;</button>
            <button class="next-btn">&#10095;</button>
        </div>
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

            
            const carousel = $('.carousel');
            const prevBtn = $('.prev-btn');
            const nextBtn = $('.next-btn');
            let currentIndex = 0;

            function updateCarousel() {
                const totalItems = $('.carousel-item').length;
                const itemWidth = $('.carousel-item').width();
                
                if (currentIndex >= totalItems) currentIndex = 0;
                if (currentIndex < 0) currentIndex = totalItems - 1;
                
                carousel.css('transform', `translateX(-${currentIndex * itemWidth}px)`);
            }

            nextBtn.click(function() {
                currentIndex++;
                updateCarousel();
            });

            prevBtn.click(function() {
                currentIndex--;
                updateCarousel();
            });

          
            setInterval(function() {
                currentIndex++;
                updateCarousel();
            }, 5000);
        });
      
        document.addEventListener("DOMContentLoaded", function () {
        const heroSection = document.querySelector(".hero");

        function checkScroll() {
            const sectionPosition = heroSection.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;

            if (sectionPosition < windowHeight - 100) {
                heroSection.classList.add("visible");
            }
        }

        // Wait a little after page load to trigger the effect
        setTimeout(() => {
            checkScroll();
        }, 500);

        window.addEventListener("scroll", checkScroll);
    });

    </script>
</body>
</html>