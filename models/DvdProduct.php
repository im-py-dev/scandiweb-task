<?php

require_once __DIR__ . '/Product.php';


class DvdProduct extends Product
{
    private $size;
    
    public function __construct($sku, $name, $price, $size)
    {
        parent::__construct($sku, $name, $price, "DVD");
        $this->size = $size;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize($size): void
    {
        $this->size = $size;
    }

    public function getAttribute(): string
    {
        return $this->getSize() . ' MB';
    }

    public function getProductType(): string
    {
        return 'DVD';
    }

    public function save($conn): bool
    {
        $stmt = $conn->prepare("INSERT INTO products (sku, name, price, product_type, value) 
                                VALUES (:sku, :name, :price, :product_type, :size)");
        $stmt->execute([
            ':sku' => $this->getSku(),
            ':name' => $this->getName(),
            ':price' => $this->getPrice(),
            ':product_type' => $this->getProductType(),
            ':size' => $this->getSize()
        ]);
        return $stmt->rowCount() > 0;
    }
}
