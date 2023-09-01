<?php

declare(strict_types=1);

use Monolog\Logger;
use DI\ContainerBuilder;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManager;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use App\Application\Settings\SettingsInterface;
use App\Infrastructure\Doctrine\Helper\EntityManagerDto;

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

        EntityManager::class => fn (ContainerInterface $c) => EntityManagerDto::make($c->get(SettingsInterface::class)->get('doctrine'))
    ]);
};
