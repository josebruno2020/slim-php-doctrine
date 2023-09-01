<?php

use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Psr\Container\ContainerInterface;

// $container->set(
//   EntityManager::class, \DI\value(function (ContainerInterface $c) {
//     $settings = $c->get(SettingsInterface::class)->get('doctrine');

//     var_dump($settings);
//     exit;

//     $config = ORMSetup::createAttributeMetadataConfiguration(
//       $settings['metadata_dirs'],
//       $settings['dev_mode'],
//       null,
//       // $cache
//     );


//     return EntityManager::create($settings['connection'], $config);
//   })
// );


$container = require_once __DIR__ . '/bootstrap.php';


return ConsoleRunner::createHelperSet($container->get(EntityManager::class));