<?php

namespace App\Models;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use JsonSerializable;

abstract class Product implements JsonSerializable
{

    private string $sku;
    private string $name;
    private int $price;


    public abstract function save(Connection $dbConnection): void;

    protected abstract function getSpecificAttributes();

    protected abstract function setSpecificAttributes(array $attributes);


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

    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function jsonSerialize(): array
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => $this->price
        ];
    }
}