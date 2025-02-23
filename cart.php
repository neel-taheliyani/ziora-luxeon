<?php
include('include/db_connection.php');
session_start();

$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['remove'])) {
    $remove_id = $_POST['remove'];
    unset($_SESSION['cart'][$remove_id]);
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ziora Luxeon - Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Lora:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #000000;
            color: #D8D8D8;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* NAVBAR */
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

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 120px 20px 50px;
        }

        .cart-container {
            max-width: 1000px;
            width: 100%;
            background: #2c2c2c;
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            animation: fadeInDown 1s ease-out;
        }

        .cart-container h2 {
            font-size: 3em;
            color: #D4AF37;
            margin-bottom: 20px;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .cart-table th, .cart-table td {
            padding: 15px;
            border-bottom: 1px solid #444;
        }

        .cart-table th {
            text-transform: uppercase;
            color: #D4AF37;
            font-weight: 600;
        }

        .cart-table td img {
            width: 80px;
            border-radius: 10px;
        }

        .remove-btn {
            padding: 8px 15px;
            background: #D4AF37;
            color: #1a1a1a;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .remove-btn:hover {
            background: #b3952f;
            transform: scale(1.05);
        }

        .checkout-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            background: #D4AF37;
            color: #1a1a1a;
            text-decoration: none;
            font-weight: bold;
            border-radius: 25px;
            font-size: 1.1em;
            transition: all 0.3s ease;
        }

        .checkout-btn:hover {
            background: #b3952f;
            transform: scale(1.05);
        }

        .empty-cart {
            font-size: 1.5em;
            color: #D8D8D8;
            margin-top: 50px;
        }

        /* FOOTER */
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
                flex-direction: column;
                padding: 15px 20px;
                gap: 15px;
            }

            .cart-container {
                padding: 20px;
            }

            .cart-table th, .cart-table td {
                font-size: 0.9em;
                padding: 10px;
            }

            .checkout-btn {
                width: 100%;
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
            <li><a href="./cart.php"class="active">Cart</a></li>
            <li><a href="./contact.php">Contact</a></li>
            <li><a href="./about.php" >About Us</a></li>
        </ul>
    </header>

    <div class="main-content">
        <div class="cart-container">
            <h2>Your Cart</h2>
            <?php if (!empty($cart_items)) { ?>
                <table class="cart-table">
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($cart_items as $id => $item) { ?>
                    <tr>
                        <td><img src="images/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>"></td>
                        <td><?php echo $item['name']; ?></td>
                        <td>₹<?php echo number_format($item['price'], 2); ?></td>
                        <td><form method="POST"><button type="submit" name="remove" value="<?php echo $id; ?>" class="remove-btn">Remove</button></form></td>
                    </tr>
                    <?php } ?>
                </table>
                <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
            <?php } else { ?>
                <p class="empty-cart">Your cart is empty.</p>
            <?php } ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Ziora Luxeon. All rights reserved.</p>
    </footer>
</body>
</html>
