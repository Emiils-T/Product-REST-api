<?php

namespace App\Models;

use Doctrine\DBAL\Connection;

class Furniture extends Product
{
    private float $width;
    private float $height;
    private float $length;


    public function getHeight(): float
    {
        return $this->height;
    }

    public function getLength(): float
    {
        return $this->length;
    }

    public function getWidth(): float
    {
        return $this->width;
    }


    public function setWidth(float $width): void
    {
        $this->width = $width;
    }


    public function setHeight(float $height): void
    {
        $this->height = $height;
    }


    public function setLength(float $length): void
    {
        $this->length = $length;
    }

    public function save(Connection $dbConnection): void
    {
        $dbConnection->insert('products', [
            'sku' => $this->getSku(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
        ]);
        $dbConnection->insert('dvds', [
            'product_sku' => $this->getSku(),
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'length' => $this->getLength()
        ]);
    }

    protected function getSpecificAttributes()
    {
        return [
            'width' => $this->width,
            'height' => $this->height,
            'length' => $this->length,
        ];
    }

    protected function setSpecificAttributes(array $attributes)
    {
        $this->height = $attributes['height'];
        $this->width = $attributes['width'];
        $this->length = $attributes['length'];
    }


}