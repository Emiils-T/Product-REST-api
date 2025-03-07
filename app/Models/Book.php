<?php

namespace App\Models;

use Doctrine\DBAL\Connection;

class Book extends Product
{
    private int $weight;

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }


    public function save(Connection $dbConnection): void
    {
        $dbConnection->insert('products', [
            'sku' => $this->getSku(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
        ]);
        $dbConnection->insert('books', [
            'product_sku' => $this->getSku(),
            'weight' => $this->getWeight()
        ]);
    }

    protected function getSpecificAttributes()
    {
        return [
            'weight' => $this->weight
        ];
    }

    protected function setSpecificAttributes(array $attributes)
    {
        $this->weight = $attributes['weight'];
    }

}
