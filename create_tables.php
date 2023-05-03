<?php

// Include database configuration
require_once __DIR__ . '/config/database.php';

// SQL query to create the products table
$sql = "CREATE TABLE IF NOT EXISTS products (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    product_type ENUM('DVD', 'Book', 'Furniture') NOT NULL,
    value VARCHAR(11) NOT NULL
)";

// Prepare query statement
$stmt = $conn->prepare($sql);

// Execute query
try {
    $stmt->execute();
    echo "Table created successfully.";
} catch(PDOException $e) {
    echo 'Error creating table: ' . $e->getMessage();
}
?>
