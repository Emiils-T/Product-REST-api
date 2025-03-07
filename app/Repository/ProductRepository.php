<?php

namespace App\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Schema;

class ProductRepository implements DatabaseRepository
{
    private Connection $connection;
    private AbstractSchemaManager $schemaManager;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->schemaManager = $this->connection->createSchemaManager();

    }

    public function createTable(): void
    {

        if (!$this->schemaManager->tableExists('products')) {

            $schema = new Schema();

            $products = $schema->createTable('products');
            $products->addColumn('id', 'integer', ['autoincrement' => true]);
            $products->addColumn('sku', 'string', ['notnull' => true, 'length' => 50]);
            $products->addColumn('name', 'string', ['notnull' => true, 'length' => 100]);
            $products->addColumn('price', 'decimal', ['notnull' => true, 'precision' => 10, 'scale' => 2]);
            $products->addUniqueIndex(['sku']);
            $products->setPrimaryKey(['id']);

            $platform = $this->connection->getDatabasePlatform();
            $queries = $schema->toSql($platform);
            foreach ($queries as $query) {
                $this->connection->executeQuery($query);
            }
        }
    }
}