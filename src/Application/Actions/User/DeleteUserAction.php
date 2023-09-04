<?php

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class DeleteUserAction extends UserAction
{
    
    protected function action(): Response
    {
        $id = $this->resolveArg('id');
        $this->userRepository->deleteUserById($id);
        
        return $this->respondWithData(statusCode: 204);
    }
}