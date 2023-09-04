<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Validation\DomainValidationHelper;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use JsonSerializable;

#[Entity, Table(name: 'users')]
class User implements JsonSerializable
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(type: 'string', unique: true, nullable: false)]
    private string $username;

    #[Column(type: 'string', nullable: false)]
    private string $firstName;

    #[Column(type: 'string', nullable: false)]
    private string $lastName;

    public function __construct(?int $id = null, ?string $username = null, ?string $firstName = null, ?string $lastName = null)
    {
        $this->setId($id)
            ->setUsername($username)
            ->setFirstName($firstName)
            ->setLastName($lastName);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setUsername(?string $username): self
    {
        DomainValidationHelper::validateRequiredArgument(
            argument: $username,
            argumentName: "username"
        );
        $this->username = strtolower($username);
        return $this;
    }

    public function setFirstName(?string $firstName): User
    {
        DomainValidationHelper::validateRequiredArgument(
            argument: $firstName,
            argumentName: "firstName"
        );
        $this->firstName = ucfirst($firstName);
        return $this;
    }

    public function setLastName(?string $lastName): User
    {
        DomainValidationHelper::validateRequiredArgument(
            argument: $lastName,
            argumentName: "lastName"
        );
        $this->lastName = ucfirst($lastName);
        return $this;
    }


    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
        ];
    }

    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }


}
