<?php
// Load the environment variables
require_once __DIR__ . '/config/env.php';

// Create a PDO object to connect to the database
try {
    $conn = new PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}", $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

// Read the contents of the SQL file
$sql = file_get_contents(__DIR__ . '/dummy_data.sql');

// Prepare the SQL statements
$stmt = $conn->prepare($sql);

// Execute the SQL statements
try {
    $stmt->execute();
    echo "Data loaded successfully!";
} catch(PDOException $e) {
    echo 'Error loading data: ' . $e->getMessage();
}
?>
