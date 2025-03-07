<?php

namespace App\Controllers\Api;

use App\Models\ProductFactory;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class ProductController
{

    private $dbParams;
    private Connection $dbConnection;

    public function __construct($dbParams)
    {
        $this->dbParams = $dbParams;
        $this->dbConnection = DriverManager::getConnection($this->dbParams);
    }

    public function index()
    {
        $data = $this->dbConnection->fetchAllAssociative("SELECT * FROM products");
        $products = [
            "products" => $data
        ];
        return json_encode($products,JSON_PRETTY_PRINT);
    }

    public function store()
    {
        // TODO: validate
        $type = $_POST['type'];

        $product = ProductFactory::create($type);

        $product->setSku($_POST['sku']);
        $product->setName($_POST['name']);
        $product->setPrice($_POST['price']);

        switch ($type) {
            case "dvd":
                $product->setSize($_POST['size']);
                break;
            case "book":
                $product->setWeight($_POST['weight']);
                break;
            case "furniture":
                $product->setHeight($_POST['height']);
                $product->setWidth($_POST['width']);
                $product->setLength($_POST['width']);
                break;
            default:
                throw new \Exception("Unsupported product type");
        }
        $product->save($this->dbConnection);


        return json_encode(["message" => 'success']);
    }
}