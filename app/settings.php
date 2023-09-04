<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

if (!defined('APP_ROOT')) {
    define('APP_ROOT', __DIR__ . "/..");
}

$dotenv = Dotenv\Dotenv::createImmutable(APP_ROOT);
$dotenv->load();

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'doctrine' => [
                    // Enables or disables Doctrine metadata caching
                    // for either performance or convenience during development.
                    'dev_mode' => true,

                    // Path where Doctrine will cache the processed metadata
                    // when 'dev_mode' is false.
                    'cache_dir' => APP_ROOT . '/var/doctrine',

                    // with comments or PHP8 attributes.
                    'metadata_dirs' => [APP_ROOT . '/src/Domain'],

                    'connection' => [
                        'driver' => $_ENV['DB_DRIVER'],
                        'path' => $_ENV['DB_PATH'],
//                        'host' => $_ENV['DB_HOST'],
//                        'port' => $_ENV['DB_PORT'],
//                        'dbname' => $_ENV['DB_NAME'],
//                        'user' => $_ENV['DB_USER'],
//                        'password' => $_ENV['DB_PASSWORD'],
                        'charset' => 'utf8'
                    ],
                ]
            ]);
        }
    ]);
};
