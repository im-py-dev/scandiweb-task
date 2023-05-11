<?php
header("Access-Control-Allow-Origin: *"); // Here we should add only our frontend domains
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


// Check if the request method is DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    
    // Instantiate product controller object
    require_once '../controllers/ProductController.php';

    // Get the SKUs of the products to delete
    $skusToDelete = json_decode(file_get_contents('php://input'), true);

    $productController = new ProductController($conn);
    $productController->deleteProduct($skusToDelete);

} elseif ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();

} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method Not Allowed']);
    exit();
}

