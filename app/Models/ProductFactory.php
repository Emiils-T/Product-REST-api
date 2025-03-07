<?php

namespace App\Models;
class ProductFactory
{
    public static function create($type)
    {
        switch ($type) {
            case 'dvd':
                return new DVD();
            case 'book':
                return new Book();
            case 'furniture':
                return new Furniture();
            default:
                throw new \Exception("Unsupported product type");
        }
    }
}