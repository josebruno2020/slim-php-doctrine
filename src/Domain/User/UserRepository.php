<?php

declare(strict_types=1);

namespace App\Domain\User;

interface UserRepository
{
    /**
     * @return User[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return User|null
     * @throws UserNotFoundException
     */
    public function findUserOfId(int $id): ?User;
}
