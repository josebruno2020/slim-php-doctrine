<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use App\Domain\User\UserRepository;
use App\Infrastructure\Doctrine\Persistence\User\DoctrineUserRepository;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(DoctrineUserRepository::class),
    ]);
};
