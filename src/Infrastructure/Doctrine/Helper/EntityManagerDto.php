<?php

namespace App\Infrastructure\Doctrine\Helper;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;


class EntityManagerDto
{
  public static function make(array $settings): EntityManager
  {
    // TODO: make cache
    $config = ORMSetup::createAttributeMetadataConfiguration(
      $settings['metadata_dirs'],
      $settings['dev_mode'],
      null,
      // $cache
    );


    return EntityManager::create($settings['connection'], $config);
  }
}
