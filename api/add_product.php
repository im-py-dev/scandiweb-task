<?php
header("Access-Control-Allow-Origin: *"); // Here we should add only our frontend domains
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    // Instantiate product controller object
    require_once '../controllers/ProductController.php';

    // Retrieve the raw data from the request body
    $data = file_get_contents('php://input');
    $product = json_decode($data);
    
    $productController = new ProductController($conn);
    $productController->addProduct($product);

} elseif ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
    
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method Not Allowed']);
    exit;
}
