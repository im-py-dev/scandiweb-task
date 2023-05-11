<?php

ini_set('display_errors', 1);

// Include BaseController class
require_once 'BaseController.php';

// Include database configuration
require_once '../config/database.php';

// Instantiate product object
require_once '../objects/ProductFactory.php';


class ProductController extends BaseController
{
    public function __construct($conn)
    {
        parent::__construct($conn);
    }
    
    public function getAllProducts()
    {
    // Get all products from the database
    $products = Product::getAll($this->conn);
    
    // Create an array to hold the product data
    $productData = array();

    // Loop through all retrieved products and add their data to the array
    foreach ($products as $product)
    {
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

    public function deleteProduct($skusToDelete)
    {
    // Check if the SKUs to delete were provided
    if (empty($skusToDelete)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'No SKUs to delete provided']);
        exit();
    }
    
    // Loop through all SKUs and delete the corresponding products from the database
    foreach ($skusToDelete as $sku) {
        if (!Product::delete($this->conn, $sku)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Failed to delete product with SKU: ' . $sku]);
            exit();
        }
    }

    http_response_code(204);
    echo json_encode(['success' => true, 'message' => "Product deleted successfully"]);
    exit();
    }
    
    public function addProduct($product)
    {
        if (!$this->isValidFormData($product))
        {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid form data']);
            exit;
        }
    
        if (Product::skuExists($this->conn, $product->sku))
        {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'SKU already exists']);
            exit;
        }
        
        $product = ProductFactory::createProduct($product->productType, $product->sku, $product->name, $product->price, $product->value);
        $product->save($this->conn);
        http_response_code(200); // OK
        echo json_encode(['success' => true, 'message' => 'Product added successfully!']);
        exit;
}

    private function isValidFormData($product): bool
    {
        if (empty($product->sku) || empty($product->name) || empty($product->price) || empty($product->productType) || empty($product->value))
        {
            return false;
        if ( $product->productType == 'Furniture' && count(explode("x", $product->value)) == 3 )
        {
            return false;
        }
        } elseif (!is_numeric($product->price) || $product->price <= 0) {
            return false;
        }
        return true;
    }
}
