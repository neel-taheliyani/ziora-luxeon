<?php
session_start();
include('include/db_connection.php');

if (isset($_POST['remove'])) {
    $product_id = $_POST['product_id'];

    // Remove product from the cart
    if (($key = array_search($product_id, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
    }

    // Redirect back to the Cart page
    header('Location: cart.php');
    exit();
}
?>
