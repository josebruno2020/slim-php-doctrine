<?php

namespace App\Application\Middleware;

namespace App\Application\Middleware;

use App\Domain\DomainException\DomainInvalidArgumentException;
use App\Domain\User\UserRepository;
use App\Domain\Validation\DomainValidationHelper;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;

class UserCreateValidationMiddleware implements Middleware
{
    private UserRepository $repository;
    private DomainValidationHelper $validationHelper;

    public function __construct(UserRepository $repository, DomainValidationHelper $validationHelper)
    {
        $this->repository = $repository;
        $this->validationHelper = $validationHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $body = $request->getParsedBody();
        $fields = ['username', 'firstName', 'lastName'];
        try {
            $this->validationHelper->validateRequiredArguments($fields, $body);
        } catch (DomainInvalidArgumentException $e) {
            throw new HttpBadRequestException($request, $e->getMessage());
        }
        
        $id = $this->getPathParam($request, param: 'id');
        
        if($this->repository->usernameExists($body['username'], $id)) {
            throw new HttpBadRequestException($request, "Campo [username] deve ser único.");
        }
        

        return $handler->handle($request);
    }
    
    private function getPathParam(Request $request, string $param): ?string
    {
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();

        return $route->getArgument($param);
    }
}