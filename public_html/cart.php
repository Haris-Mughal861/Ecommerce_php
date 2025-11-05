<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_items = get_cart_items($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method'];
    $shipping_address = $_POST['shipping_address'];

    if (process_order($user_id, $cart_items, $payment_method, $shipping_address)) {
        clear_cart($user_id);
        header('Location: order_success.php');
        exit();
    } else {
        $error_message = "There was an error processing your order.";
    }
}
?>