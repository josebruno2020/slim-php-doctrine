<?php

namespace App\Application\Actions\User;

use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class UpdateUserAction extends UserAction
{

    /**
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        $id = $this->resolveArg('id');
        $this->userRepository->updateUserById(
            $id,
            data: $this->request->getParsedBody()
        );

        return $this->respondWithData(statusCode: 204);
    }
}