<?php
require '../config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
    }

    header {
      background-color: #222;
      color: white;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logout-btn {
      background-color: #ff3b3b;
      color: white;
      border: none;
      padding: 8px 14px;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }

    .header-right {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    h1, p {
      text-align: center;
      color: #333;
    }

    .btn-container {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 50px;
    }

    .admin-btn {
      background-color: #222;
      color: yellow;
      padding: 15px 25px;
      border: 2px solid yellow;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      font-size: 16px;
      transition: 0.3s;
      text-decoration: none;
    }

    .admin-btn:hover {
      background-color: yellow;
      color: #222;
    }

    footer {
      background: #222;
      color: white;
      text-align: center;
      padding: 60px;
      margin-top: 100px;
      margin-top: 600px;
    }
    .logo{
        color: yellow;
    }
  </style>
</head>
<body>

<header>
  <a href="#" class="logo">ADMIN DASHBOARD</a>
  <div class="header-right">
    <span><?= htmlspecialchars($_SESSION['username']); ?></span>
    <a class="logout-btn" href="../login.php">Logout</a>
  </div>
</header>

<h1>Welcome to Admin Dashboard</h1>
<p>You have admin access.</p>

<div class="btn-container">
  <a href="../admin/product_add.php" class="admin-btn">Add Product</a>
  <a href="../admin/product-edit.php" class="admin-btn">Edit Product</a>
  <a href="../admin/product_delete.php" class="admin-btn">Delete Product</a>
</div>

<footer>
  © <?= date("Y"); ?> Marketplace | All Rights Reserved
</footer>

</body>
</html>
