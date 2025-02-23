<?php
// Start the session to manage cart data
session_start();

// Check if the order details are stored in session
if (!isset($_SESSION['order'])) {
    header("Location: index.php"); // Redirect to homepage if no order is found in session
    exit();
}

// Get the order details
$order = $_SESSION['order'];
$orderTotal = $order['total'];
$items = $order['items'];

// Clear the order details from session to prevent showing the same data on page reload
unset($_SESSION['order']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Ziora Luxeon</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Lora:wght@400;500&display=swap" rel="stylesheet">
    <style>
/* Global Styles */
body {
    margin: 0;
    font-family: 'Roboto', sans-serif;
    background-color: #1e1e1e;
    color: #f1f1f1;
    overflow-x: hidden;
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
}


/* Confirmation Section */
.confirmation-section {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 80px;
}

/* Confirmation Box */
.confirmation-container {
    width: 75%;
    max-width: 850px;
    background-color: #2c2c2c;
    border-radius: 10px;
    padding: 50px 40px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.5);
    text-align: center;
}

/* Heading */
.confirmation-container h1 {
    font-family: 'Lora', serif;
    color: #D4AF37;
    margin-bottom: 25px;
    font-size: 2.2em;
}

/* Order Summary */
.order-summary {
    margin-top: 25px;
    text-align: left;
}

.order-summary ul {
    list-style: none;
    padding: 0;
}

.order-summary ul li {
    margin-bottom: 8px;
}

.order-summary .total-price {
    font-size: 1.3em;
    font-weight: bold;
}

/* Buttons */
.confirmation-actions {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 30px;
}

/* Gold Button */
.button-gold {
    background: linear-gradient(45deg, #D4AF37, #E6C456, #D4AF37);
    background-size: 300% 300%;
    animation: gradientShift 4s ease infinite;
    color: #0a0a0a;
    font-weight: 700;
    font-size: 1em;
    padding: 14px 28px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.4s ease;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    text-decoration: none;
    display: inline-block;
    box-shadow: 0 6px 15px rgba(212, 175, 55, 0.4);
    min-width: 160px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.button-gold:hover {
    transform: scale(1.06);
    box-shadow: 0 8px 20px rgba(212, 175, 55, 0.6);
}

/* Dark Button */
.button-dark {
    background: #1e1e1e;
    color: #D4AF37;
    font-weight: 700;
    font-size: 1em;
    padding: 14px 28px;
    border: 1px solid #D4AF37;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.4s ease;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    text-decoration: none;
    display: inline-block;
    min-width: 160px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
    position: relative;
    overflow: hidden;
}

.button-dark:hover {
    background: #D4AF37;
    color: #1e1e1e;
    transform: scale(1.05);
    box-shadow: 0 8px 22px rgba(212, 175, 55, 0.5);
}

/* Gradient Animation */
@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Footer */
footer {
    background-color: #1a1a1a;
    color: #D4AF37;
    text-align: center;
    font-size: 1.2em;
    padding: 12px 0;
    position: fixed;
    bottom: 0;
    width: 100%;
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
            <li><a href="./about.php" >About Us</a></li>
        </ul>
    </header>
<section class="confirmation-section">
    <div class="confirmation-container">
        <h1>Thank You for Your Order!</h1>

        <p>Your order has been successfully placed.</p>

        <div class="order-summary">
            <h3>Order Summary:</h3>
            <ul>
                <?php foreach ($items as $item): ?>
                    <li>
                        <strong><?php echo $item['name']; ?></strong> - ₹<?php echo number_format($item['price']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="total-price">
                Total: ₹<?php echo number_format($orderTotal); ?>
            </div>
        </div>

        <div class="confirmation-actions">
            <a href="index.php" class = 'button-dark' >Return to Homepage</a>
            <a href="product.php"class = 'button-gold' >Shop More Products</a>
        </div>  

    </div>
</section>

<footer>
    <p>&copy; 2024 Ziora Luxeon. All rights reserved.</p>
</footer>

</body>

</html>
