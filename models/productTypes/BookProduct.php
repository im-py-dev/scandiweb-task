<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/models/Product.php');


class BookProduct extends Product
{
    private $weight;
    
    public function __construct($sku, $name, $price, $weight)
    {
        parent::__construct($sku, $name, $price, "Book");
        $this->weight = $weight;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }
    
    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }

    public function getAttribute(): string
    {
        return $this->getWeight() . ' Kg';
    }

    public function getProductType(): string
    {
        return 'Book';
    }

    public function save($conn): bool
    {
        $stmt = $conn->prepare("INSERT INTO products (sku, name, price, product_type, value) 
                                VALUES (:sku, :name, :price, :product_type, :weight)");
        $stmt->execute([
            ':sku' => $this->getSku(),
            ':name' => $this->getName(),
            ':price' => $this->getPrice(),
            ':product_type' => $this->getProductType(),
            ':weight' => $this->getWeight()
        ]);
        return $stmt->rowCount() > 0;
    }
}
