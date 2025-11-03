<?php
require '../config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
   

    if ($username === '' || $email === '' || $password === '') {
        echo 'All fields are required.';
        exit;
    }


    $check = $mysqli->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
    $check->bind_param('s', $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo 'Email already registered.';
        exit;
    }

    $check->close();
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("INSERT INTO users (username, email, password, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param('sss', $username, $email, $hash);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'Registration failed. Try again.';
    }

    $stmt->close();
}
?>
