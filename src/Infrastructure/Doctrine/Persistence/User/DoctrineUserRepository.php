<?php

namespace App\Infrastructure\Doctrine\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserRepository;
use Doctrine\ORM\EntityManager;

class DoctrineUserRepository implements UserRepository {
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
}