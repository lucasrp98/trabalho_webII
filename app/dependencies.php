<?php
declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
    ]);

    $containerBuilder->addDefinitions([
        'db' => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $dbSettings =  $settings->get('db');

            $driver =  $dbSettings ['driver'];
            $host =  $dbSettings ['host'];
            $dbname =  $dbSettings ['database'];
            $username =  $dbSettings ['username'];
            $password =  $dbSettings ['password'];
            $dsn = "$driver:host=$host;dbname=$dbname;";

            $con = mysqli_connect($host, $username, $password, $dbname);
            return $con;
        }
    ]);
};
