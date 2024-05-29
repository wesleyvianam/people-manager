<?php

declare(strict_types=1);

namespace Easy\Wallet\Helper;

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
            'host' => 'easy-db',
            'port' => '3306',
            'dbname' => 'easywallet',
            'user' => 'wesley',
            'password' => 'P@ssw0rd',
            'charset' => 'utf8mb4',
        ];

        $connection = DriverManager::getConnection($connectionParams, $config);

        return new EntityManager($connection, $config);
    }
}
