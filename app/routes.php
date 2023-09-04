<?php

declare(strict_types=1);

use App\Application\Actions\User\{CreateUserAction,
    DeleteUserAction,
    ListUsersAction,
    UpdateUserAction,
    ViewUserAction
};
use App\Application\Middleware\UserCreateValidationMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $r = json_encode(['ok' => 200]);
        $response->getBody()->write($r);
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
        $group->post('', CreateUserAction::class)->add(UserCreateValidationMiddleware::class);
        $group->put('/{id}', UpdateUserAction::class)->add(UserCreateValidationMiddleware::class);
        $group->delete('/{id}', DeleteUserAction::class);
    });
};
