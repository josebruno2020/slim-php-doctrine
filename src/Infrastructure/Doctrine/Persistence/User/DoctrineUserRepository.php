<?php

namespace App\Infrastructure\Doctrine\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class DoctrineUserRepository implements UserRepository
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function findAll(): array
    {
        return $this->em->getRepository(User::class)->findAll();
    }

    public function findUserOfId(int $id): ?User
    {
        return $this->em->getRepository(User::class)->find($id);
    }

    /**
     * @param array{username: string, firstName: string, lastName: string} $data
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createUser(array $data): void
    {
        $user = new User();
        $user->setUsername($data['username'])
            ->setFirstName($data['firstName'])
            ->setLastName($data['lastName']);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function usernameExists(string $username, ?int $id = null): bool
    {
        $q = $this->em->getRepository(User::class)->createQueryBuilder('u')
            ->where('u.username = :username');

        if ($id) {
            $q = $q->andWhere('u.id <> :id')
            ->setParameter('id', $id);
        }
        $result = $q->setParameter('username', $username)
            ->getQuery()->getResult();

//        var_dump($result);
//
//        var_dump(count($result));
//        exit();



        return count($result) > 0;
    }

    /**
     * @param int $id
     * @param array{username: string, firstName: string, lastName: string} $data
     * @return void
     */
    public function updateUserById(int $id, array $data): void
    {
        $user = $this->findUserOfId($id);
        if (!$user) {
            throw new UserNotFoundException();
        }
        $user
            ->setUsername($data['username'])
            ->setFirstName($data['firstName'])
            ->setLastName($data['lastName']);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function deleteUserById(int $id): void
    {
        $user = $this->findUserOfId($id);
        if (!$user) {
            throw new UserNotFoundException();
        }
        $this->em->remove($user);
        $this->em->flush();
    }


}