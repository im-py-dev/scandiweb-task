<?php

require_once __DIR__ . '/Product.php';


class FurnitureProduct extends Product
{
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
    
    public function getHeight(): int
    {
        return $this->height;
    }
    
    public function setHeight($height): void
    {
        $this->height = $height;
    }
    
    public function getWidth(): int
    {
        return $this->width;
    }
    
    public function setWidth($width): void
    {
        $this->width = $width;
    }
    
    public function getLength(): int
    {
        return $this->length;
    }
    
    public function setLength($length): void
    {
        $this->length = $length;
    }
    
    public function getAttribute(): string
    {
        return $this->dimensions;
    }
    
    public function getProductType(): string
    {
        return "Furniture";
    }

    public function save($conn): bool
    {
        $query = "INSERT INTO products (sku, name, price, product_type, value) VALUES (:sku, :name, :price, :product_type, :dimensions)";
        $stmt = $conn->prepare($query);
        $stmt->execute([
        ':sku' => $this->getSku(),
        ':name' => $this->getName(),
        ':price' => $this->getPrice(),
        ':product_type' => $this->getProductType(),
        ':dimensions' => $this->getAttribute()
        ]);

        return $stmt->rowCount() > 0;
    }
}
