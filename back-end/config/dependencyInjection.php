<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManager;
use App\Helper\EntityManagerCreator;
use DI\ContainerBuilder;

$builder = new ContainerBuilder();
$builder->addDefinitions([
    EntityManager::class => function (): EntityManager {
        return EntityManagerCreator::createEntityManager();
    },
]);

$container = $builder->build();

return $container;
