<?php
require '../config.php';
session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $stock = trim($_POST['stock']);
    $image = $_FILES['image'];

   
    if (empty($title) || empty($price) || empty($image['name'])) {
        $message = "⚠ Please fill all required fields!";
    } else {
        $target_dir = "../uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $image_name = time() . "_" . basename($image["name"]);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            
            $sql = "INSERT INTO products (title, description, price, stock, image) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssdis", $title, $description, $price, $stock, $image_name);

            if ($stmt->execute()) {
                $message = "Product added successfully!";
            } else {
                $message = "Database error: " . $stmt->error;
            }
        } else {
            $message = " Failed to upload image.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Product</title>
<style>
body {
  font-family: Arial, sans-serif;
  background: #f4f4f4;
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
.container {
  width: 50%;
  margin: 50px auto;
  background: white;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
h2 {
  text-align: center;
  color: #333;
}
form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}
input, textarea {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 16px;
}
button {
  background-color: #222;
  color: yellow;
  padding: 10px;
  border: 2px solid yellow;
  border-radius: 6px;
  font-size: 16px;
  cursor: pointer;
  font-weight: bold;
}
button:hover {
  background: yellow;
  color: #222;
}
.message {
  text-align: center;
  font-weight: bold;
  color: green;
}
</style>
</head>
<body>

<header>
  <a href="admin_dashboard.php" style="color:white; text-decoration:none;">⬅ Back to Dashboard</a>
  <div><?= htmlspecialchars($_SESSION['username']); ?></div>
</header>

<div class="container">
  <h2>Add New Product</h2>
  <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>

  <form action="" method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Product Title" required>
    <textarea name="description" placeholder="Product Description" rows="4"></textarea>
    <input type="number" step="0.01" name="price" placeholder="Product Price" required>
    <input type="number" name="stock" placeholder="Available Stock" value="0" required>
    <input type="file" name="image" accept="image/*" required>
    <button type="submit">Add Product</button>
  </form>
</div>

</body>
</html>
