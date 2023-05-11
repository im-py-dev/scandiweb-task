<?php
// Add Product Page
header("Access-Control-Allow-Origin: *"); // Here we should add only our frontend domains
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

ini_set('display_errors', 1);

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    // Instantiate product controller object
    require_once '../controllers/ProductController.php';

    // Get all products
    $productController = new ProductController($conn);
    $productController->getAllProducts();
}
 elseif ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();

} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method Not Allowed']);
    exit();
}
?>
