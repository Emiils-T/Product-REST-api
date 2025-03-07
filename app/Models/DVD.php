<?php

namespace App\Models;


class DVD extends Product
{
    private int $size;


    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    public function save($dbConnection): void
    {
        $dbConnection->insert('products', [
            'sku' => $this->getSku(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
        ]);
        $dbConnection->insert('dvds', [
            'product_sku' => $this->getSku(),
            'size' => $this->getSize()
        ]);
    }

    protected function getSpecificAttributes()
    {
        return [
            'size' => $this->size,
        ];
    }

    protected function setSpecificAttributes(array $attributes)
    {
        $this->size = $attributes['size'];
    }

}