<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManager;
use Easy\Wallet\Helper\EntityManagerCreator;
use DI\ContainerBuilder;

$builder = new ContainerBuilder();
$builder->addDefinitions([
    EntityManager::class => function (): EntityManager {
        return EntityManagerCreator::createEntityManager();
    },
    PDO::class => function (): PDO {
        $host = 'easy-db';
        $port = '3306';
        $dbName = 'easywallet';
        $user = 'wesley';
        $password = 'P@ssw0rd';

        $dsn = "mysql:host=$host;port=$port;dbname=$dbName;charset=utf8";

        try {
            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            return $pdo;
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }
]);

$container = $builder->build();

return $container;
