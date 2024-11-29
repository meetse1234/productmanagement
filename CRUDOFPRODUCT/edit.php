<?php
include('db.php');

// Fetch the product details
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM products WHERE id = $id");
$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $rating = $_POST['rating'];

    $imagePath = $product['image_url']; // Keep the existing image by default
    if (!empty($_FILES['image']['name'])) {
        $targetDir = 'uploads/';
        $imagePath = $targetDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    // Update the product in the database
    $stmt = $conn->prepare("UPDATE products SET product_name = ?, price = ?, quantity = ?, description = ?, rating = ?, image_url = ? WHERE id = ?");
    $stmt->bind_param("sdisssi", $product_name, $price, $quantity, $description, $rating, $imagePath, $id);
    $stmt->execute();

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .form-control, .form-select {
            border-radius: 8px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        .mb-3 {
            margin-bottom: 20px;
        }
        h2 {
            text-align: center;
            color: #343a40;
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: 600;
        }
        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        small {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <h2>Edit Product</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" id="product_name" name="product_name" class="form-control" value="<?= htmlspecialchars($product['product_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price (in Rupees)</label>
                <input type="number" id="price" name="price" step="0.01" class="form-control" value="<?= $product['price'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" id="quantity" name="quantity" class="form-control" value="<?= $product['quantity'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4" required><?= htmlspecialchars($product['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <select id="rating" name="rating" class="form-select" required>
                    <option value="1" <?= $product['rating'] == 1 ? 'selected' : '' ?>>1 Star</option>
                    <option value="2" <?= $product['rating'] == 2 ? 'selected' : '' ?>>2 Stars</option>
                    <option value="3" <?= $product['rating'] == 3 ? 'selected' : '' ?>>3 Stars</option>
                    <option value="4" <?= $product['rating'] == 4 ? 'selected' : '' ?>>4 Stars</option>
                    <option value="5" <?= $product['rating'] == 5 ? 'selected' : '' ?>>5 Stars</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" id="image" name="image" class="form-control">
                <small>Current Image: <?= htmlspecialchars($product['image_url']) ?></small>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
