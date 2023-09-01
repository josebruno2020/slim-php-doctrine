<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpNotFoundException;

class ViewUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $user = $this->userRepository->findUserOfId($userId);

        if (!$user) throw new HttpNotFoundException($this->request, "User not found");

        $this->logger->info("User of id $userId was viewed.");

        return $this->respondWithData($user);
    }
}
