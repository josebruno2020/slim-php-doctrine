<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;

class InMemoryUserRepository implements UserRepository
{
    /**
     * @var User[]
     */
    private array $users;

    /**
     * @param User[]|null $users
     */
    public function __construct(array $users = null)
    {
        $this->users = $users ?? [
            1 => new User(1, 'bill.gates', 'Bill', 'Gates'),
            2 => new User(2, 'steve.jobs', 'Steve', 'Jobs'),
            3 => new User(3, 'mark.zuckerberg', 'Mark', 'Zuckerberg'),
            4 => new User(4, 'evan.spiegel', 'Evan', 'Spiegel'),
            5 => new User(5, 'jack.dorsey', 'Jack', 'Dorsey'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->users);
    }

    /**
     * {@inheritdoc}
     */
    public function findUserOfId(int $id): User
    {
        if (!isset($this->users[$id])) {
            throw new UserNotFoundException();
        }

        return $this->users[$id];
    }

    /**
     * @param array{username: string, firstName: string, lastName: string} $data
     */
    public function createUser(array $data): void
    {
        if (empty($this->users)) {
            $userId = 1;
        } else {
            $lastUser = $this->users[count($this->users)];
            $userId = $lastUser->getId() + 1;
        }
        $this->users[] = [
            $userId => new User(
                id: $userId,
                username: $data['username'],
                firstName: $data['firstName'],
                lastName: $data['lastName']
            )
        ];
    }

    public function usernameExists(string $username, ?int $id = null): bool
    {
        $result = false;
        foreach ($this->users as $user) {
            if ($user->getId() !== $id && $user->getUsername() === $username) {
                $result = true;
            }
        }
        return $result;
    }

    /**
     * @param int $id
     * @param array{username: string, firstName: string, lastName: string} $data
     * @return void
     * @throws UserNotFoundException
     */
    public function updateUserById(int $id, array $data): void
    {
        $user = $this->users[$id];
        if (!$user) {
            throw new UserNotFoundException();
        }

        $user->setUsername($data['username'])
            ->setFirstName($data['firstName'])
            ->setLastName($data['lastName']);
    }

    public function deleteUserById(int $id): void
    {
        $user = $this->findUserOfId($id);
        unset($this->users[$user->getId()]);
    }
}
