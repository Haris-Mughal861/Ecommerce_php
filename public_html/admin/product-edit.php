 <?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../login.php");
    exit;
}
if (!isset($_GET['id'])) {
    header("Location: ../admin/product-edit.php");
    exit;
}
$product_id = $_GET['id'];
$product = get_product($product_id);
if (!$product) {
    header("Location: product_list.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $stock = trim($_POST['stock']);
    $image = $_FILES['image'];

    if (empty($title) || empty($price)) {
        $message = "Please fill all required fields!";
    } else {
        if (!empty($image['name'])) {
            $target_dir = "../uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $image_name = time() . "_" . basename($image["name"]);
            $target_file = $target_dir . $image_name;

            if (move_uploaded_file($image["tmp_name"], $target_file)) {
                $product['image'] = $image_name;
            } else {
                $message = " Failed to upload image.";
            }
        }

        $sql = "UPDATE products SET title=?, description=?, price=?, stock=?, image=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdisi", $title, $description, $price, $stock, $product['image'], $product_id);

        if ($stmt->execute()) {
            $message = "Product updated successfully!";
        } else {
            $message = "Database error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Product</title>
<link rel="stylesheet" href="../styles.css">
</head>
<body>
<h1>Edit Product</h1>
<?php if (isset($message)): ?>
    <p><?php echo $message; ?></p>
<?php endif; ?>
<form method="POST" action="" enctype="multipart/form-data">
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($product['title']); ?>" required><br>

    <label for="description">Description:</label>
    <textarea name="description" id="description"><?php echo htmlspecialchars($product['description']); ?></textarea><br>

    <label for="price">Price:</label>
    <input type="text" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" required><br>

    <label for="stock">Stock:</label>
    <input type="number" name="stock" id="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required><br>

    <label for="image">Image:</label>
    <input type="file" name="image" id="image"><br>
    <?php if (!empty($product['image'])): ?>
        <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" width="100"><br>
    <?php endif; ?>

    <button type="submit">Update Product</button>
</form>
</body>
</html>
<?php
function get_product($product_id) {
    global $conn;
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
?>
