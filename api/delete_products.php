<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Include database configuration
require_once '../config/database.php';

// Instantiate product object
require_once '../objects/product.php';

// Get the SKUs of the products to delete
$skusToDelete = json_decode($_POST['skusToDelete']);

// Check if the SKUs to delete were provided
if (empty($skusToDelete)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'No SKUs to delete provided']);
    exit();
}

// Loop through all SKUs and delete the corresponding products from the database
foreach ($skusToDelete as $sku) {
    // Check if the SKU is valid
    if (empty($sku)) {
        continue;
    }

    $product = new Product($sku);
    if (!$product->delete($conn)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Failed to delete product with SKU: ' . $sku]);
        exit();
    }
}

http_response_code(204);
exit();
?>
