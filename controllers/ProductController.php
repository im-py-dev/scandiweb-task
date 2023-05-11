<?php

// Include BaseController class
require_once 'BaseController.php';

// Include database configuration
require_once '../config/database.php';

// Instantiate product object
require_once '../models/ProductFactory.php';


class ProductController extends BaseController
{
    public function __construct($conn)
    {
        parent::__construct($conn);
    }
    
    public function getAllProducts(): JSON
    {
    $products = Product::getAll($this->conn);
    $productData = array();

    foreach ($products as $product)
    {
        $productData[] = array(
            'sku' => $product->getSku(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'productType' => $product->getProductType(),
            'value' => $product->getAttribute()
        );
    }

    $jsonData = json_encode($productData);
    echo $jsonData;
    exit;
}

    public function deleteProduct($skusToDelete): JSON
    {
    if (empty($skusToDelete)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'No SKUs to delete provided']);
        exit();
    }
    
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
    
    public function addProduct($product): JSON
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
            return false;

        if ( $product->productType == 'Furniture' && count(explode("x", $product->value)) == 3 )
            return false;

        if (!is_numeric($product->price) || $product->price <= 0)
            return false;

        return true;
    }
}
