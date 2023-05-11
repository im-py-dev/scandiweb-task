<?php


abstract class Product {
    protected $id;
    protected $sku;
    protected $name;
    protected $price;
    protected $product_type;

    public function __construct(string $sku, string $name = null, float $price = null, string $product_type = null)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->product_type = $product_type;
        
    }

    public function getId(): int
    {
    return $this->id;
    }
    
    public function getSku(): string
    {
    return $this->sku;
    }
    
    public function getName(): string
    {
    return $this->name;
    }
    
    public function getPrice(): float
    {
    return $this->price;
    }
    
    public function getProductType(): string
    {
    return $this->product_type;
    }

    public function setId(int $id): void
    {
    $this->id = $id;
    }

    public function setSku(string $sku): void
    {
    $this->sku = $sku;
    }

    public function setName(string $name): void
    {
    $this->name = $name;
    }

    public function setPrice(float $price): void
    {
    $this->price = $price;
    }

    public function setProductType(string $product_type): void
    {
    $this->product_type = $product_type;
    }
    
    public static function executePreparedStatement(PDO $conn, string $query, array $params): bool
    {
        $stmt = $conn->prepare($query);
        foreach ($params as $paramName => $paramValue) {
            $stmt->bindParam($paramName, $paramValue);
        }
        return $stmt->execute();
    }
    
    public static function getAll(PDO $conn): array
    {
    $products = array();
    $result = $conn->query("SELECT * FROM products");
    while ($row = $result->fetch(PDO::FETCH_OBJ)) {
        $product = ProductFactory::createProduct($row->product_type, $row->sku, $row->name, $row->price, $row->value);
        $products[] = $product;
    }
    $result->closeCursor();
    return $products;
    }
    
    public static function delete(PDO $conn, string $sku): bool
    {
        // Make sure the SKU property is set
        if (!isset($sku)) {
            return false;
        }

        $query = "DELETE FROM `products` WHERE `sku` = :sku";
        $params = array(':sku' => $sku);
        $result = self::executePreparedStatement($conn, $query, $params);

        if ($result)
        {
            return true;
        }
        return false;
    }

    public static function skuExists(PDO $conn, string $sku): bool
    {
        $stmt = $conn->prepare("SELECT * FROM products WHERE sku=:sku");
        $stmt->bindParam(':sku', $sku);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

}
