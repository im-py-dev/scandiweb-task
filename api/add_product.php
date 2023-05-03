<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    // Include database configuration
    require_once '../config/database.php';
    
    // Instantiate product object
    require_once '../objects/product.php';

    // Retrieve the raw data from the request body
    $data = file_get_contents('php://input');
    $product = json_decode($data);
    
    // Get form data
    $sku = $product->sku;
    $name = $product->name;
    $price = $product->price;
    $type = $product->productType;
    $value = $product->value;

  // Validate form data
if (!is_numeric($price) || $price <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Price must be a valid number greater than zero']);
    exit;
  } elseif (empty($sku) || empty($name) || empty($price)) {
      http_response_code(400);
      echo json_encode(['success' => false, 'error' => 'Please submit all required data']);
      exit;
  } else {
    // Check if SKU already exists
    $sql = "SELECT * FROM products WHERE sku=:sku";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':sku', $sku);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'SKU already exists']);
        exit;
    } else {
        $product = ProductFactory::createProduct($type, $sku, $name, $price, $value);
        $product->save($conn);

        http_response_code(200); // OK
        echo json_encode(['success' => true, 'message' => 'Product added successfully!']);
        exit;
    }
  }
}
?>