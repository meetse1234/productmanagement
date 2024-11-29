<?php
include('db.php');
$id = $_GET['id'];

$result = $conn->query("SELECT image_url FROM products WHERE id = $id");
$product = $result->fetch_assoc();
if ($product['image']) {
    unlink($product['image']);
}

$conn->query("DELETE FROM products WHERE id = $id");
header("Location: index.php");
?>
