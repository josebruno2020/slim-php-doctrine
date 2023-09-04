<?php

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class CreateUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $this->userRepository->createUser(
            data: $this->request->getParsedBody()
        );

        return $this->respondWithData(statusCode: 201);
    }
}