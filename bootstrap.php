<?php

use App\Application\Settings\SettingsInterface;
use App\Infrastructure\Doctrine\Helper\EntityManagerDto;
use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;

require_once __DIR__ . '/vendor/autoload.php';
$settings = require_once __DIR__ . '/app/settings.php';

$containerBuilder = new ContainerBuilder();
$settings($containerBuilder);

$containerBuilder->addDefinitions([
  EntityManager::class => fn (ContainerInterface $c) => EntityManagerDto::make($c->get(SettingsInterface::class)->get('doctrine'))
]);


return $containerBuilder->build();