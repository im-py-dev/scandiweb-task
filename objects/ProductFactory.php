<?php
ini_set('display_errors', 1);

require_once 'FurnitureProduct.php';
require_once 'BookProduct.php';
require_once 'DvdProduct.php';


class ProductFactory {
    public static function createProduct($type, $sku, $name, $price, $value)
    {
        switch($type) {
            case 'DVD':
                return new DvdProduct($sku, $name, $price, $value);
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