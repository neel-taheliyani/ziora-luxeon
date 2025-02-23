<?php
session_start();
    $products = [
        ['id' => 1, 'name' => 'Shree Ram Janmbhumi Edition', 'price' => 3400000, 'image' => 'assets/images/shreeram.png', 'description' => 'Celebrate the legacy of Shree Ram with this limited edition luxury timepiece.'],
        ['id' => 2, 'name' => 'Patek Philippe Aquanaut', 'price' => 5000000, 'image' => 'assets/images/patekphilliphoragnedial.png', 'description' => 'Discover the perfect fusion of elegance and adventure with the Patek Philippe Aquanaut.'],
        ['id' => 3, 'name' => 'Tommy Hilfiger', 'price' => 1100000, 'image' => 'assets/images/tommyhilfiger.png', 'description' => 'Timeless elegance for every occasion.'],
        ['id' => 4, 'name' => 'Audemars Piguet', 'price' => 8000000, 'image' => 'assets/images/ap-1-removebg-preview.png', 'description' => 'Designed for the most demanding explorers.'],
        ['id' => 5, 'name' => 'Audemars Piguet', 'price' => 7000000, 'image' => 'assets/images/AP-2-removebg-preview.png', 'description' => 'Iconic design built for adventure.'],
        ['id' => 6, 'name' => 'Audemars Piguet', 'price' => 4500000, 'image' => 'assets/images/AP_3.png', 'description' => 'A blend of timeless design and cutting-edge innovation.'],
        ['id' => 7, 'name' => 'Omega Seamaster', 'price' => 9000000, 'image' => 'assets/images/omegaseamaster.png', 'description' => 'A masterpiece of craftsmanship.'],
        ['id' => 8, 'name' => 'Omega Seamaster', 'price' => 12000000, 'image' => 'assets/images/omegaseamasterblack-removebg-preview.png', 'description' => 'Refined innovation with classic appeal.'],
        ['id' => 9, 'name' => 'Rolex Black dial(date only)', 'price' => 7000000, 'image' => 'assets/images/rolexblackdial-removebg-preview.png', 'description' => 'A true statement of luxury.'],
        ['id' => 10, 'name' => 'Rolex Rainbow', 'price' => 6500000, 'image' => 'assets/images/rolexrainbowdial-removebg-preview.png', 'description' => 'Radiating a spectrum of brilliance with a rainbow bezel.'],
        ['id' => 11, 'name' => 'Montablic', 'price' => 6500000, 'image' => 'assets/images/montablic.png', 'description' => 'Sophisticated design with ultimate comfort.'],
        ['id' => 12, 'name' => 'HUBLOT', 'price' => 6500000, 'image' => 'assets/images/hublot.png', 'description' => 'Modern luxury with a steel dial chronograph.'],
    ];
if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $product = null;
    foreach ($products as $item) {
        if ($item['id'] == $productId) {
            $product = $item;
            break;
        }
    }
    if ($product) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (!in_array($product, $_SESSION['cart'])) {
            $_SESSION['cart'][] = $product;
        }
    }
    header('Location: cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ziora Luxeon - Luxury Watch Collection</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Lora:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* Global Styling */
body {
    margin: 0;
    font-family: 'Roboto', sans-serif;
    background-color: #1a1a1a;
    color: #D8D8D8;
    animation: fadeIn 1.2s ease-out;
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



/* Hero Section */
h1 {
    text-align: center;
    margin-top: 140px;
    color: #D4AF37;
    font-size: 2.8em;
    font-weight: 700;
    text-shadow: 0px 3px 10px rgba(212, 175, 55, 0.3);
}

/* Product Grid */
.products-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
    padding: 40px;
    margin: 30px auto;
    max-width: 1200px;
    background: rgba(25, 25, 25, 0.95);
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(212, 175, 55, 0.1);
    animation: fadeIn 1.2s ease-out;
}

/* Product Card */
.product-card {
    background: linear-gradient(135deg, #1a1a1a, #222);
    border-radius: 10px;
    padding: 18px;
    text-align: center;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    opacity: 0;
    animation: fadeInCard 0.8s ease-out forwards;
}

.product-card:hover {
    transform: scale(1.03);
    box-shadow: 0px 8px 20px rgba(212, 175, 55, 0.2);
}

/* Product Images */
.product-card img {
    width: 100%;
    height: 250px;
    object-fit: contain;
    border-radius: 10px;
    margin-bottom: 12px;
    box-shadow: 0px 4px 12px rgba(212, 175, 55, 0.12);
}

/* Product Name */
.product-card h2 {
    font-size: 1.3em;
    color: #D4AF37;
    margin: 8px 0;
}

/* Price */
.product-card .price {
    font-size: 1.1em;
    color: #ffffff;
    font-weight: bold;
    margin-bottom: 8px;
}

/* Button */
.product-card .view-button {
    background: linear-gradient(90deg, #D4AF37, #E6C456);
    color: #1a1a1a;
    padding: 10px 16px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 1em;
    font-weight: bold;
    display: inline-block;
    transition: all 0.2s ease;
    box-shadow: 0 3px 10px rgba(212, 175, 55, 0.15);
    cursor: pointer;
    border: none;
}

.product-card .view-button:hover {
    transform: scale(1.04);
    box-shadow: 0 5px 15px rgba(212, 175, 55, 0.25);
}

/* Footer */
footer {
    background: #141414;
    color: #D4AF37;
    text-align: center;
    padding: 18px;
    font-size: 1.1em;
    margin-top: 30px;
}

/* Animations */
@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}

@keyframes fadeInCard {
    0% { opacity: 0; transform: translateY(10px); }
    100% { opacity: 1; transform: translateY(0); }
}

/* Responsive Design */
@media (max-width: 768px) {
    header {
        padding: 15px 20px;
        flex-direction: column;
        width: 100%;
    }

    .products-container {
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        padding: 30px 15px;
    }

    .product-card {
        padding: 15px;
    }

    h1 {
        font-size: 2.4em;
        margin-top: 110px;
    }

    footer {
        font-size: 1em;
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
            <li><a href="./product.php"class="active">Products</a></li>
            <li><a href="./cart.php">Cart</a></li>
            <li><a href="./contact.php">Contact</a></li>
            <li><a href="./about.php" >About Us</a></li>
        </ul>
    </header>
    <h1>Our Products</h1>
    <div class="products-container">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <h2><?php echo $product['name']; ?></h2>
                <p class="price">₹<?php echo number_format($product['price']); ?></p>
                <p><?php echo $product['description']; ?></p>
                <!-- Form to add product to cart -->
                <form method="POST" action="product.php">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <button type="submit" name="add_to_cart" class="view-button">Add to your cart</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

    <footer>
        <p>&copy; 2025 Ziora Luxeon. All rights reserved.</p>
    </footer>
</body>
</html>