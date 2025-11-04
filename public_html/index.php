<?php
session_start();
require 'config.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


$query = "SELECT id, title, price, image, description FROM products ORDER BY id DESC";
$result = $mysqli->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Store</title>
<link rel="icon" type="image/png" href="shop.png">
<style>
  body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background-color: #f5f5f5;
  }

  
  header {
    background-color: #222;
    color: white;
    padding: 15px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .logo {
    font-size: 24px;
    font-weight: bold;
    color: #ffcc00;
    text-decoration: none;
  }
  .search-box input {
    padding: 8px 10px;
    border-radius: 5px;
    border: none;
    width: 250px;
  }
  .header-right {
    display: flex;
    align-items: center;
    gap: 15px;
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


  .welcome {
    text-align: center;
    margin: 20px 0;
    font-size: 22px;
    font-weight: bold;
  }

  
  .products {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 25px;
    padding: 20px 40px;
  }

  .product-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.3s;
  }

  .product-card:hover {
    transform: translateY(-5px);
  }

  .product-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
  }

  .product-info {
    padding: 15px;
    text-align: center;
  }

  .product-info h3 {
    margin: 0;
    font-size: 18px;
    color: #333;
  }

  .product-info p {
    font-size: 14px;
    color: #777;
    height: 40px;
    overflow: hidden;
  }

  .price {
    color: #e63946;
    font-weight: bold;
    font-size: 16px;
  }

  .buy-btn {
    margin-top: 10px;
    background-color: #222;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
  }

  .buy-btn:hover {
    background-color: #ffcc00;
    color: black;
  }

  
  footer {
    background: #222;
    color: white;
    text-align: center;
    padding: 15px;
    margin-top: 40px;
  }
</style>
</head>
<body>

<header>
  <a href="#" class="logo">Ecommerce</a>
  <div class="search-box">
    <input type="text" placeholder="Search products...">
  </div>
  <div class="header-right">
    <span><?= htmlspecialchars($_SESSION['username']); ?></span>
    <button class="logout-btn" id="logoutBtn">Logout</button>
  </div>
</header>

<div class="welcome">Welcome to Marketplace!</div>

<section class="products">
  <?php if ($result && $result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
      <div class="product-card">
        <img src="uploads/<?= htmlspecialchars($row['image']); ?>" alt="<?= htmlspecialchars($row['title']); ?>">
        <div class="product-info">
          <h3><?= htmlspecialchars($row['title']); ?></h3>
          <p><?= htmlspecialchars($row['description']); ?></p>
          <div class="price">$<?= htmlspecialchars($row['price']); ?></div>
          <button class="buy-btn">Add to Cart</button>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p style="text-align:center;">No products found.</p>
  <?php endif; ?>
</section>

<footer>
  © <?= date("Y"); ?> Marketplace | All Rights Reserved
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$("#logoutBtn").click(function() {
  $.ajax({
    url: "logout.php",
    type: "POST",
    success: function() {
      localStorage.setItem("logoutSuccess", "true");
      window.location.href = "login.php";
    }
  });
});


if (localStorage.getItem("loginSuccess") === "true") {
  alert("Login Successful! Welcome back.");
  localStorage.removeItem("loginSuccess");
}
</script>

</body>
</html>
