<?php
session_start();
require '../config.php'; 
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        echo "Please enter email and password.";
        exit;
    }

    $stmt = $mysqli->prepare("SELECT id, username, password FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($id, $username, $hash);

    if ($stmt->fetch()) {
        if (password_verify($password, $hash)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            echo "success";
            exit;
        }
    }
    echo "Invalid email or password.";

}
?>
