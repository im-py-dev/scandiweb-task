<?php


class Product {
    public $id;
    public $sku;
    public $name;
    public $price;
    public $product_type;

    public function __construct($sku, $name = null, $price = null, $product_type = null) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->product_type = $product_type;
  }

    public function getId() {
    return $this->id;
    }
    
    public function getSku() {
    return $this->sku;
    }
    
    public function getName() {
    return $this->name;
    }
    
    public function getPrice() {
    return $this->price;
    }
    
    public function getProductType() {
    return $this->product_type;
    }

    public function setId($id) {
    $this->id = $id;
    }

    public function setSku($sku) {
    $this->sku = $sku;
    }

    public function setName($name) {
    $this->name = $name;
    }

    public function setPrice($price) {
    $this->price = $price;
    }

    public function setProductType($product_type) {
    $this->product_type = $product_type;
    }
    
    public static function getAll($conn) {
    $products = array();
    $result = $conn->query("SELECT * FROM products");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $product_type = $row['product_type'];
        $product = ProductFactory::createProduct($product_type, $row['sku'], $row['name'], $row['price'], $row['value']);
        $products[] = $product;
    }
    $result->closeCursor();
    return $products;
    }

    public function delete($conn) {
        // Make sure the SKU property is set
        if (!isset($this->sku)) {
            return false;
        }
    
        // Prepare the DELETE statement
        $query = "DELETE FROM `products` WHERE `sku` = :sku";
    
        // Prepare the statement
        $stmt = $conn->prepare($query);
    
        // Bind parameters
        $stmt->bindParam(':sku', $this->sku);
    
        // Execute the statement
        if ($stmt->execute()) {
            // Product deleted successfully
            return true;
        }
        // Error deleting product
        return false;
    }
}

class ProductFactory {
    public static function createProduct($type, $sku, $name, $price, $value) {

        switch($type) {
            case 'DVD':
                return new DVDProduct($sku, $name, $price, $value);
                break;
            case 'Book':
                return new BookProduct($sku, $name, $price, $value);
                break;
            case 'Furniture':
                return new FurnitureProduct($sku, $name, $price, $value);
                break;
            default:
                throw new Exception('Invalid product type');
        }
    }
}

class DVDProduct extends Product {
    private $size;
    
    public function __construct($sku, $name, $price, $size) {
        parent::__construct($sku, $name, $price, "DVD");
        $this->size = $size;
    }

    public function getSize() {
        return $this->size;
    }
    
    public function getAttribute() {
        return $this->getSize() . ' MB';
    }

    public function save($conn) {
        $stmt = $conn->prepare("INSERT INTO products (sku, name, price, product_type, value) 
                                VALUES (:sku, :name, :price, :product_type, :size)");
        $stmt->execute([
            ':sku' => $this->sku,
            ':name' => $this->name,
            ':price' => $this->price,
            ':product_type' => $this->product_type,
            ':size' => $this->size,
        ]);
        return $stmt->rowCount() > 0;
}

    public static function getAll($conn) {
        $products = array();
        $result = $conn->query("SELECT * FROM products WHERE product_type = 'DVD'");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $product = new DVDProduct($row['sku'], $row['name'], $row['price'], $row['value']);
            $product->setId($row['id']);
            $products[] = $product;
        }
        $result->closeCursor();
        return $products;
    }
}

class BookProduct extends Product {
    private $weight;
    
    public function __construct($sku, $name, $price, $weight) {
        parent::__construct($sku, $name, $price, "Book");
        $this->weight = $weight;
    }

    public function getWeight() {
        return $this->weight;
    }
    
    public function getAttribute() {
        return $this->getWeight() . ' Kg';
    }

    public function save($conn) {
    $stmt = $conn->prepare("INSERT INTO products (sku, name, price, product_type, value) 
                            VALUES (:sku, :name, :price, :product_type, :weight)");
    $stmt->execute([
        ':sku' => $this->sku,
        ':name' => $this->name,
        ':price' => $this->price,
        ':product_type' => $this->product_type,
        ':weight' => $this->weight,
    ]);
    return $stmt->rowCount() > 0;
}

    public static function getAll($conn) {
        $products = array();
        $result = $conn->query("SELECT * FROM products WHERE product_type = 'Book'");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $product = new BookProduct($row['sku'], $row['name'], $row['price'], $row['value']);
            $product->setId($row['id']);
            $products[] = $product;
        }
        $result->closeCursor();
        return $products;
    }
}

class FurnitureProduct extends Product {
    private $height;
    private $width;
    private $length;
    
    public function __construct($sku, $name, $price, $dimensions) {
        parent::__construct($sku, $name, $price, "Furniture");

        $dimensions_array = explode("x", $dimensions);

        $this->dimensions = $dimensions;
        $this->height = $dimensions_array[0];
        $this->width = $dimensions_array[1];
        $this->length = $dimensions_array[2];
    }
    
    public function getHeight() {
        return $this->height;
    }
    
    public function setHeight($height) {
        $this->height = $height;
    }
    
    public function getWidth() {
        return $this->width;
    }
    
    public function setWidth($width) {
        $this->width = $width;
    }
    
    public function getLength() {
        return $this->length;
    }
    
    public function setLength($length) {
        $this->length = $length;
    }
    
    public function getAttribute() {
        return $this->dimensions;
    }

    public function save($conn) {
    $stmt = $conn->prepare("INSERT INTO products (sku, name, price, product_type, value) 
                            VALUES (:sku, :name, :price, :product_type, :dimensions)");
    $stmt->execute([
        ':sku' => $this->getSku(),
        ':name' => $this->getName(),
        ':price' => $this->getPrice(),
        ':product_type' => $this->product_type,
        ':dimensions' => $this->dimensions,
    ]);

    return $stmt->rowCount() > 0;
}


    public static function getAll($conn) {
        $db = new Database();
        $conn = $db->getConnection();
        
        $sql = "SELECT * FROM products WHERE product_type = 'Furniture'";
        $result = $conn->query($sql);
        $products = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $product = new FurnitureProduct($row['sku'], $row['name'], $row['price'], $row['value']);
                $products[] = $product;
            }
        }
        
        return $products;
    }
}

?>