<?php

namespace App\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Schema;

class FurnitureRepository implements DatabaseRepository
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

        if (!$this->schemaManager->tableExists('furniture')) {
            $schema = new Schema();

            $table = $schema->createTable('furniture');
            $table->addColumn('id', 'integer', ['autoincrement' => true]);
            $table->addColumn('product_sku', 'string', ['notnull' => true, 'length' => 50]);
            $table->addColumn('width', 'decimal', ['notnull' => true, 'precision' => 2]);
            $table->addColumn('height', 'decimal', ['notnull' => true, 'precision' => 2]);
            $table->addColumn('length', 'decimal', ['notnull' => true, 'precision' => 2]);
            $table->addUniqueIndex(["product_sku"]);
            $table->setPrimaryKey(['id']);
            $table->addForeignKeyConstraint('products', ['product_sku'], ['sku'], ['onDelete' => "CASCADE"]);

            $platform = $this->connection->getDatabasePlatform();
            $queries = $schema->toSql($platform);
            foreach ($queries as $query) {
                $this->connection->executeQuery($query);
            }
        }
    }
}