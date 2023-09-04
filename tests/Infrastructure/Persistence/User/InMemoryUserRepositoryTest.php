<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use Tests\TestCase;

class InMemoryUserRepositoryTest extends TestCase
{
    public function testFindAll()
    {
        $user = $this->userMock();

        $userRepository = new InMemoryUserRepository([1 => $user]);

        $this->assertEquals([$user], $userRepository->findAll());
    }

    public function testFindAllUsersByDefault()
    {
        $users = [
            1 => new User(1, 'bill.gates', 'Bill', 'Gates'),
            2 => new User(2, 'steve.jobs', 'Steve', 'Jobs'),
            3 => new User(3, 'mark.zuckerberg', 'Mark', 'Zuckerberg'),
            4 => new User(4, 'evan.spiegel', 'Evan', 'Spiegel'),
            5 => new User(5, 'jack.dorsey', 'Jack', 'Dorsey'),
        ];

        $userRepository = new InMemoryUserRepository();

        $this->assertEquals(array_values($users), $userRepository->findAll());
    }

    public function testFindUserOfId()
    {
        $user = $this->userMock();

        $userRepository = new InMemoryUserRepository([1 => $user]);

        $this->assertEquals($user, $userRepository->findUserOfId(1));
    }

    public function testFindUserOfIdThrowsNotFoundException()
    {
        $userRepository = new InMemoryUserRepository([]);
        $this->expectException(UserNotFoundException::class);
        $userRepository->findUserOfId(1);
    }

    public function testCreateUser()
    {
        $userRepository = new InMemoryUserRepository([]);

        $data = [
            'username' => 'jb',
            'firstName' => 'josé',
            'lastName' => 'bruno'
        ];

        $userRepository->createUser($data);

        $this->assertCount(1, $userRepository->findAll());
    }

    public function testUpdateUser()
    {
        $user = $this->userMock();
        $userRepository = new InMemoryUserRepository([1 => $user]);

        $data = [
            'id' => 1,
            'username' => 'jb',
            'firstName' => 'José',
            'lastName' => 'Bruno'
        ];

        $userRepository->updateUserById(1, $data);

        $userUpdated = $userRepository->findUserOfId(1);

        $this->assertEquals(
            $data,
            $userUpdated->jsonSerialize()
        );
    }

    public function testDeleteUserById()
    {
        $user = $this->userMock();

        $userRepository = new InMemoryUserRepository([1 => $user]);
        $userRepository->deleteUserById(1);

        $this->assertCount(0, $userRepository->findAll());
    }

    public function testUsernameExistsWithId()
    {
        $user = $this->userMock();

        $userRepository = new InMemoryUserRepository([1 => $user]);

        $hasUsername = $userRepository->usernameExists('bill.gates', $user->getId());

        $this->assertFalse($hasUsername);
    }


    public function testUsernameExistsWithoutId()
    {
        $user = $this->userMock();

        $userRepository = new InMemoryUserRepository([1 => $user]);

        $hasUsername = $userRepository->usernameExists('bill.gates');

        $this->assertTrue($hasUsername);
    }

    private function userMock(): User
    {
        return new User(1, 'bill.gates', 'Bill', 'Gates');
    }
}
