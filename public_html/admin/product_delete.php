<?php
session_start();
require_once '../config.php';
require_once '../functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    
    if (delete_product($product_id)) {
        $success_message = "Product deleted successfully.";
    } else {
        $error_message = "There was an error deleting the product.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delete Product</title>
</head>
<body>
    <h2>Delete Product</h2>
    <?php if (isset($success_message)): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>


    <?php elseif (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>


    <form method="POST" action="">
        <label for="product_id">Product ID:</label>
        <input type="text" name="product_id" id="product_id" required>
        <button type="submit">Delete Product</button>
    </form>
</body>
</html>