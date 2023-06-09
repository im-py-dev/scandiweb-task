<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/models/productTypes/FurnitureProduct.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/models/productTypes/BookProduct.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/models/productTypes/DvdProduct.php');


class ProductFactory {
    public static $types = [
        'Book' => BookProduct::class,
        'DVD' => DvdProduct::class,
        'Furniture' => FurnitureProduct::class
    ];
        
    public static function createProduct($type, $sku, $name, $price, $value)
    {
        if (isset(self::$types[$type])) {
            $class_name = self::$types[$type];
            return new $class_name($sku, $name, $price, $value);
        } else {
            throw new Exception('Invalid product type');
        }
    }
}
