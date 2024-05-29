<?php

declare(strict_types=1);

namespace App\Helper;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

class EntityManagerCreator
{
    public static function createEntityManager(): EntityManager
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [__DIR__ . "/.."],
            isDevMode: true,
        );

        $connectionParams = [
            'driver' => 'pdo_mysql',
            'host' => 'mysql',
            'port' => '3306',
            'dbname' => 'app',
            'user' => 'wesley',
            'password' => 'e46a73d1',
            'charset' => 'utf8mb4',
        ];

        $connection = DriverManager::getConnection($connectionParams, $config);

        return new EntityManager($connection, $config);
    }
}
