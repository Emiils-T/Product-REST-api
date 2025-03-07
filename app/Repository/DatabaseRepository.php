<?php

namespace App\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Schema\Schema;


interface DatabaseRepository
{

    public function createTable(): void;

}



