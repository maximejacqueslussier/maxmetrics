<?php

declare(strict_types=1);

namespace App\Domain\User;

use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(
    fields: ['username'],
    message: 'app.domain.user.username.uniqueEntityMessage',
)]
#[UniqueEntity(
    fields: ['email'],
    message: 'app.domain.user.email.uniqueEntityMessage',
)]
final class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const string ID = 'id';
    public const string USERNAME = 'username';
    public const string ROLES = 'roles';
    public const string PASSWORD = 'password';
    public const string SALUTATION = 'salutation';
    public const string PRONOUNS = 'pronouns';
    public const string GENDER_IDENTITY = 'genderIdentity';
    public const string FIRST_NAME = 'firstName';
    public const string MIDDLE_NAME = 'middleName';
    public const string LAST_NAME = 'lastName';
    public const string EMAIL = 'email';
    public const string PHONE_NUMBER = 'phoneNumber';
    public const string CREATED_AT = 'createdAt';
    public const string UPDATED_AT = 'updatedAt';

    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'app.domain.user.username.notBlankMessage')]
    #[Assert\Length(max: 255, maxMessage: 'app.domain.user.username.maxMessage')]
    private ?string $username = null;

    #[ORM\Column(type: Types::JSON)]
    #[Assert\NotBlank(message: 'app.domain.user.roles.notBlankMessage')]
    #[Assert\Type(type: 'array', message: 'app.domain.user.roles.notArrayMessage')]
    #[Assert\Count(min: 1, max: 1, minMessage: 'app.domain.user.roles.oneMessage')]
    #[Assert\Unique(message: 'app.domain.user.roles.notUniqueMessage')]
    #[Assert\All([
        new Assert\Choice(
            choices: ['ROLE_USER', 'ROLE_ADMIN'],
            message: 'app.domain.user.roles.choiceMessage',
        ),
    ])]
    private array $roles = [];

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'app.domain.user.password.notBlankMessage')]
    #[Assert\Length(max: 255, maxMessage: 'app.domain.user.password.maxMessage')]
    private ?string $password = null;

    #[ORM\Column(length: 64, nullable: true)]
    #[Assert\Length(max: 64, maxMessage: 'app.domain.user.salutation.maxMessage')]
    private ?string $salutation = null;

    #[ORM\Column(length: 64, nullable: true)]
    #[Assert\Length(max: 64, maxMessage: 'app.domain.user.pronouns.maxMessage')]
    private ?string $pronouns = null;

    #[ORM\Column(length: 64, nullable: true)]
    #[Assert\Length(max: 64, maxMessage: 'app.domain.user.genderIdentity.maxMessage')]
    private ?string $genderIdentity = null;

    #[ORM\Column(length: 128)]
    #[Assert\NotBlank(message: 'app.domain.user.firstName.notBlankMessage')]
    #[Assert\Length(max: 128, maxMessage: 'app.domain.user.firstName.maxMessage')]
    private ?string $firstName = null;

    #[ORM\Column(length: 128, nullable: true)]
    #[Assert\Length(max: 128, maxMessage: 'app.domain.user.middleName.maxMessage')]
    private ?string $middleName = null;

    #[ORM\Column(length: 128)]
    #[Assert\NotBlank(message: 'app.domain.user.lastName.notBlankMessage')]
    #[Assert\Length(max: 128, maxMessage: 'app.domain.user.lastName.maxMessage')]
    private ?string $lastName = null;

    #[ORM\Column(length: 256)]
    #[Assert\NotBlank(message: 'app.domain.user.email.notBlankMessage')]
    #[Assert\Length(max: 256, maxMessage: 'app.domain.user.email.maxMessage')]
    #[Assert\Email(message: 'app.domain.user.email.emailMessage')]
    private ?string $email = null;

    #[ORM\Column(length: 64, nullable: true)]
    #[Assert\Length(max: 64, maxMessage: 'app.domain.user.phoneNumber.maxMessage')]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTime $updatedAt;

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

    public function getRole(): string
    {
        return $this->getRoles()[0];
    }

    public function getRoles(): array
    {
        return $this->roles === [] ? ['ROLE_USER'] : $this->roles;
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

    public function getSalutation(): ?string
    {
        return $this->salutation;
    }

    public function setSalutation(?string $salutation): self
    {
        $this->salutation = $salutation;

        return $this;
    }

    public function getPronouns(): ?string
    {
        return $this->pronouns;
    }

    public function setPronouns(?string $pronouns): self
    {
        $this->pronouns = $pronouns;

        return $this;
    }

    public function getGenderIdentity(): ?string
    {
        return $this->genderIdentity;
    }

    public function setGenderIdentity(?string $genderIdentity): self
    {
        $this->genderIdentity = $genderIdentity;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(?string $middleName): self
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function setTimestamps(): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTime();
    }

    #[ORM\PreUpdate]
    public function updateTimestamp(): void
    {
        $this->updatedAt = new DateTime();
    }
}
