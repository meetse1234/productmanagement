<?php
include('db.php'); // Include database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .card {
            width: 100%;
            max-width: 300px; /* Restrict card width */
            margin: auto; /* Center the card in the column */
        }
        .card-img-top {
            border-radius: 10px;
            height: 200px;
            object-fit: cover;
        }
        .card:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transform: scale(1.02);
            transition: all 0.3s ease-in-out;
        }
        .card-footer {
            display: flex;
            justify-content: space-evenly; /* Space buttons evenly */
        }
        .golden-star {
            color: goldenrod; /* Set star color to golden */
        }
        .header {
            background-color: #343a40;
            padding: 20px 0;
            color: white;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body class="bg-light">

    <!-- Header -->
    <header class="header">
        <div class="container">
            <h1 class="text-center">Product Management System</h1>
        </div>
    </header>

    <div class="container py-5">
        <h2 class="text-center mb-4">Manage Your Products</h2>
        <div class="row gy-2"> <!-- Add spacing between rows -->
            <!-- Loop through products -->
            <?php
            $result = $conn->query("SELECT * FROM products");
            while ($row = $result->fetch_assoc()):
            ?>
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="<?= htmlspecialchars($row['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['product_name']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['product_name']) ?></h5>
                        <p class="card-text">
                            <strong>Price:</strong> Rupees <?= $row['price'] ?><br>
                            <strong>Quantity:</strong> <?= $row['quantity'] ?><br>
                            <strong>Description:</strong> <?= htmlspecialchars($row['description']) ?>
                        </p>
                        <div class="mb-2">
                            <strong>Rating:</strong>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="bi bi-star<?= $i <= $row['rating'] ? '-fill' : '' ?> golden-star"></i>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            <!-- Add New Product Card -->
            <div class="col-md-4">
                <a href="add.php" class="text-decoration-none">
                    <div class="card h-100 border-primary">
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <h5 class="text-primary">+ Add New Product</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p class="mb-0">&copy; 2024 Product Management System. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>
