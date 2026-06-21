<?php

declare(strict_types=1);

namespace App\Domain\Account;

use App\Domain\Profile\Profile;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
#[UniqueEntity(
    fields: ['username'],
    message: 'app.domain.account.username.uniqueEntityMessage',
)]
final class Account implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const string ID = 'id';
    public const string USERNAME = 'username';
    public const string ROLES = 'roles';
    public const string PASSWORD = 'password';

    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'app.domain.account.username.notBlankMessage')]
    #[Assert\Length(max: 255, maxMessage: 'app.domain.account.username.maxMessage')]
    private ?string $username = null;

    #[ORM\Column(type: 'json')]
    #[Assert\NotBlank(message: 'app.domain.account.roles.notBlankMessage')]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'app.domain.account.password.notBlankMessage')]
    #[Assert\Length(max: 255, maxMessage: 'app.domain.account.password.maxMessage')]
    private ?string $password = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getRoles(): array
    {
        if ($this->roles === []) {
            return ['ROLE_USER'];
        }

        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
