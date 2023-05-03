<?php
// Add Product Page
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Include database configuration
    require_once '../config/database.php';
    
    // Instantiate product object
    require_once '../objects/product.php';
    
    // Get all products from the database
    $products = Product::getAll($conn);
    
    // Create an array to hold the product data
    $productData = array();
    
    // Loop through all retrieved products and add their data to the array
    foreach ($products as $product) {
        $productData[] = array(
            'sku' => $product->getSku(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'productType' => $product->getProductType(),
            'value' => $product->getAttribute(),
        );
    }
    
    // Encode the product data as JSON
    $jsonData = json_encode($productData);
    
    // Output the JSON data
    echo $jsonData;
    exit;
}
?>
