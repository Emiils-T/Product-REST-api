<?php

namespace App\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Schema;

class DVDRepository implements DatabaseRepository
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


        if (!$this->schemaManager->tableExists('dvds')) {

            $schema = new Schema();
            $table = $schema->createTable('dvds');
            $table->addColumn('id', 'integer', ['autoincrement' => true]);
            $table->addColumn('product_sku', 'string', ['notnull' => true, 'length' => 50]);
            $table->addColumn('size', 'decimal', ['notnull' => true, 'precision' => 2]);
            $table->addUniqueIndex(['product_sku']);
            $table->addForeignKeyConstraint('products', ['product_sku'], ['sku'], ['onDelete' => "CASCADE"]);
            $table->setPrimaryKey(['id']);

            $platform = $this->connection->getDatabasePlatform();
            $queries = $schema->toSql($platform);
            foreach ($queries as $query) {
                $this->connection->executeQuery($query);
            }
        }


    }
}