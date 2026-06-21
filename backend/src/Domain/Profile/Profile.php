<?php

declare(strict_types=1);

namespace App\Domain\Profile;

use App\Domain\Account\Account;
use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(
    fields: ['email'],
    message: 'app.domain.profile.email.uniqueEntityMessage',
)]
final class Profile
{
    public const string ID = 'id';
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
    public const string ACCOUNT = 'account';

    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(length: 64, nullable: true)]
    #[Assert\Length(max: 64, maxMessage: 'app.domain.profile.salutation.maxMessage')]
    private ?string $salutation = null;

    #[ORM\Column(length: 64, nullable: true)]
    #[Assert\Length(max: 64, maxMessage: 'app.domain.profile.pronouns.maxMessage')]
    private ?string $pronouns = null;

    #[ORM\Column(length: 64, nullable: true)]
    #[Assert\Length(max: 64, maxMessage: 'app.domain.profile.genderIdentity.maxMessage')]
    private ?string $genderIdentity = null;

    #[ORM\Column(length: 128)]
    #[Assert\NotBlank(message: 'app.domain.profile.firstName.notBlankMessage')]
    #[Assert\Length(max: 128, maxMessage: 'app.domain.profile.firstName.maxMessage')]
    private ?string $firstName = null;

    #[ORM\Column(length: 128, nullable: true)]
    #[Assert\Length(max: 128, maxMessage: 'app.domain.profile.middleName.maxMessage')]
    private ?string $middleName = null;

    #[ORM\Column(length: 128)]
    #[Assert\NotBlank(message: 'app.domain.profile.lastName.notBlankMessage')]
    #[Assert\Length(max: 128, maxMessage: 'app.domain.profile.lastName.maxMessage')]
    private ?string $lastName = null;

    #[ORM\Column(length: 256)]
    #[Assert\NotBlank(message: 'app.domain.profile.email.notBlankMessage')]
    #[Assert\Length(max: 256, maxMessage: 'app.domain.profile.email.maxMessage')]
    #[Assert\Email(message: 'app.domain.profile.email.emailMessage')]
    private ?string $email = null;

    #[ORM\Column(length: 64, nullable: true)]
    #[Assert\Length(max: 64, maxMessage: 'app.domain.profile.phoneNumber.maxMessage')]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTime $updatedAt;

    #[ORM\OneToOne(targetEntity: Account::class)]
    private ?Account $account = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

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

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): self
    {
        $this->account = $account;

        return $this;
    }
}
