<?php
// Start the session to manage cart data
session_start();

// Sample product array (you can replace it with a database call)
$products = [
    ['id' => 1, 'name' => 'Watch 1', 'price' => 1500],
    ['id' => 2, 'name' => 'Watch 2', 'price' => 2000],
    ['id' => 3, 'name' => 'Watch 3', 'price' => 2500]
];

// Handle remove item action
if (isset($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    // Reindex the array
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    // Redirect back to checkout page to prevent resubmission
    header("Location: checkout.php");
    exit();
}

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// User login check (you can implement a more robust login system)
$userLoggedIn = isset($_SESSION['user_id']); // Assuming user_id is set in session after login

// Handle form submission for checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $address = $_POST['address'] ?? '';

    // Basic validation
    if (!$name || !$email || !$address) {
        $errorMessage = "Please fill in all the fields.";
    } else {
        // Proceed with order processing (this is just a sample, you can connect to a database here)
        $_SESSION['order'] = [
            'name' => $name,
            'email' => $email,
            'address' => $address,
            'items' => $_SESSION['cart'],
            'total' => array_sum(array_column($_SESSION['cart'], 'price'))
        ];

        // Clear the cart after checkout
        unset($_SESSION['cart']);

        // Redirect to order confirmation page (you can customize this page)
        header("Location: order_confirmation.php");
        exit();
    }
}

// Calculate the total price
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Ziora Luxeon</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Lora:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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


        /* Checkout Section */
        .checkout-section {
            padding: 180px 20px 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeInDown 1s ease-out forwards 0.5s;
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

        .checkout-container {
            width: 100%;
            max-width: 800px;
            background: rgba(26, 26, 26, 0.8);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(212, 175, 55, 0.1);
        }

        .checkout-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .checkout-header h2 {
            font-size: 2.8em;
            font-weight: 700;
            color: #D4AF37;
            margin-bottom: 15px;
            font-family: 'Lora', serif;
        }

        .checkout-summary {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .checkout-summary h3 {
            color: #D4AF37;
            font-size: 1.5em;
            margin-bottom: 15px;
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            padding-bottom: 10px;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
        }

        .item-details {
            flex-grow: 1;
        }

        .item-actions {
            margin-left: 15px;
        }

        .checkout-summary .total {
            font-size: 1.6em;
            font-weight: 700;
            color: #D4AF37;
            text-align: right;
            margin-top: 15px;
        }

        .checkout-form {
            display: grid;
            gap: 20px;
        }

        .form-group {
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 10px;
            color: #D8D8D8;
            font-size: 1em;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-group input:focus {
            outline: none;
            border-color: #D4AF37;
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
        }

        .form-group input::placeholder {
            color: rgba(216, 216, 216, 0.6);
        }

        .checkout-button {
            background: linear-gradient(135deg, #D4AF37 0%, #E6C456 50%, #D4AF37 100%);
            color: #0a0a0a;
            font-weight: 700;
            font-size: 1.2em;
            padding: 18px 36px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 30px auto 10px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.25);
            width: 80%;
            max-width: 400px;
            display: block;
            height: 60px;
            font-family: 'Roboto', sans-serif;
            border: 1px solid rgba(255, 215, 0, 0.3);
        }

        .checkout-button:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(212, 175, 55, 0.4);
            background: linear-gradient(135deg, #E6C456 0%, #F5D76E 50%, #E6C456 100%);
            letter-spacing: 3px;
            width: 85%;
        }

        .checkout-button:active {
            transform: translateY(0);
            box-shadow: 0 5px 10px rgba(212, 175, 55, 0.3);
        }

        .checkout-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -150%;
            width: 120%;
            height: 100%;
            background: linear-gradient(
                90deg, 
                transparent, 
                rgba(255, 255, 255, 0.4), 
                transparent
            );
            transform: skewX(-25deg);
            transition: all 0.7s ease;
        }

        .checkout-button:hover::before {
            left: 150%;
            transition: 0.7s ease-in-out;
        }

        .checkout-button::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #FFC107, #FFD700, #FFC107);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.5s cubic-bezier(0.86, 0, 0.07, 1);
        }

        .checkout-button:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        .remove-button {
            background: transparent;
            color: #D8D8D8;
            font-weight: 500;
            font-size: 0.9em;
            padding: 10px 20px;
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-block;
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }

        .remove-button:hover {
            background: rgba(220, 53, 69, 0.1);
            color: #ff6b6b;
            border-color: rgba(220, 53, 69, 0.4);
        }

        .remove-button:active {
            transform: scale(0.98);
        }

        .remove-button i {
            margin-right: 6px;
            font-size: 0.9em;
            transition: transform 0.3s ease;
        }

        .remove-button:hover i {
            transform: translateX(-3px);
        }

        .error-message {
            background: rgba(220, 53, 69, 0.1);
            color: #ff6b6b;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 3px solid #ff6b6b;
        }

        footer {
            background: #1a1a1a;
            color: #D4AF37;
            font-size: 1.2em;
            text-align: center;
            padding: 20px 0;
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeInDown 1s ease-out forwards 1.5s;
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

            .checkout-section {
                padding: 150px 15px 50px;
            }

            .checkout-container {
                padding: 25px;
            }

            .checkout-header h2 {
                font-size: 2.2em;
            }
            
            .checkout-button {
                width: 100%;
                font-size: 1.1em;
                padding: 16px 24px;
                height: 55px;
            }
            
            .checkout-button:hover {
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
            <li><a href="./cart.php">Cart</a></li>
            <li><a href="./contact.php">Contact</a></li>
            <li><a href="./about.php" >About Us</a></li>
        </ul>
    </header>

    <section class="checkout-section">
        <div class="checkout-container">
            <div class="checkout-header">
                <h2>Complete Your Purchase</h2>
            </div>
            
            <?php if (isset($errorMessage)): ?>
            <div class="error-message">
                <?php echo $errorMessage; ?>
            </div>
            <?php endif; ?>
            
            <div class="checkout-summary">
                <h3>Order Summary</h3>
                <?php foreach ($_SESSION['cart'] as $key => $item): ?>
                <div class="item-row">
                    <div class="item-details">
                        <div style="display: flex; justify-content: space-between;">
                            <span><?php echo $item['name']; ?></span>
                            <span>₹<?php echo number_format($item['price']); ?></span>
                        </div>
                    </div>
                    <div class="item-actions">
                        <a href="checkout.php?remove=<?php echo $key; ?>" class="remove-button">
                            <i class="fas fa-times"></i> Remove
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
                <div class="total">Total: ₹<?php echo number_format($total); ?></div>
            </div>
            
            <form action="checkout.php" method="POST" class="checkout-form">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Your Full Name" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Your Email Address" required>
                </div>
                <div class="form-group">
                    <input type="text" name="address" placeholder="Your Shipping Address" required>
                </div>
                <button type="submit" class="checkout-button">Complete Purchase</button>
            </form>
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
        });
    </script>
</body>
</html>