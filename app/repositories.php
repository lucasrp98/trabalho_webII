<?php
declare(strict_types=1);

use App\Domain\User\UserRepository;
use App\Domain\Cliente\ClienteRepository;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use App\Infrastructure\Persistence\Cliente\InMemoryClienteRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
        ClienteRepository::class => \DI\autowire(InMemoryClienteRepository::class),
    ]);
};
