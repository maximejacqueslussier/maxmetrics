<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(
    fields: ['email'],
    message: 'app.entity.user.email.uniqueEntityMessage',
)]
final class User
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
    public const string PASSWORD = 'password';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64, nullable: true)]
    #[Assert\Length(max: 64, maxMessage: 'app.entity.user.salutation.maxMessage')]
    private ?string $salutation = null;

    #[ORM\Column(length: 64, nullable: true)]
    #[Assert\Length(max: 64, maxMessage: 'app.entity.user.pronouns.maxMessage')]
    private ?string $pronouns = null;

    #[ORM\Column(length: 64, nullable: true)]
    #[Assert\Length(max: 64, maxMessage: 'app.entity.user.genderIdentity.maxMessage')]
    private ?string $genderIdentity = null;

    #[ORM\Column(length: 128)]
    #[Assert\NotBlank(message: 'app.entity.user.firstName.notBlankMessage')]
    #[Assert\Length(max: 128, maxMessage: 'app.entity.user.firstName.maxMessage')]
    private ?string $firstName = null;

    #[ORM\Column(length: 128, nullable: true)]
    #[Assert\Length(max: 128, maxMessage: 'app.entity.user.middleName.maxMessage')]
    private ?string $middleName = null;

    #[ORM\Column(length: 128)]
    #[Assert\NotBlank(message: 'app.entity.user.lastName.notBlankMessage')]
    #[Assert\Length(max: 128, maxMessage: 'app.entity.user.lastName.maxMessage')]
    private ?string $lastName = null;

    #[ORM\Column(length: 256)]
    #[Assert\NotBlank(message: 'app.entity.user.email.notBlankMessage')]
    #[Assert\Length(max: 256, maxMessage: 'app.entity.user.email.maxMessage')]
    #[Assert\Email(message: 'app.entity.user.email.emailMessage')]
    private ?string $email = null;

    #[ORM\Column(length: 64, nullable: true)]
    #[Assert\Length(max: 64, maxMessage: 'app.entity.user.phoneNumber.maxMessage')]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 256)]
    #[Assert\Length(max: 64, maxMessage: 'app.entity.user.password.maxMessage')]
    #[Assert\PasswordStrength(message: 'app.entity.user.password.passwordStrengthMessage')]
    private ?string $password = null;

    /**
     * Get User internal ID.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Sets the User internal ID.
     * To be used by ORM only.
     *
     * @param int $id A new internal ID
     *
     * @return \App\Entity\User
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the User salutation (eg: Mr., Ms., etc.)
     *
     * @return string|null
     */
    public function getSalutation(): ?string
    {
        return $this->salutation;
    }

    /**
     * Sets the User salutation.
     * Free-form field.
     * Can be null.
     *
     * @param string|null $salutation
     *
     * @return \App\Entity\User
     */
    public function setSalutation(?string $salutation): self
    {
        $this->salutation = $salutation;

        return $this;
    }

    /**
     * Get the User pronouns (eg: he/him, she/her, etc.)
     *
     * @return string|null
     */
    public function getPronouns(): ?string
    {
        return $this->pronouns;
    }

    /**
     * Sets the User pronouns.
     * Free-form field.
     * Can be null.
     *
     * @param string|null $pronouns
     *
     * @return \App\Entity\User
     */
    public function setPronouns(?string $pronouns): self
    {
        $this->pronouns = $pronouns;

        return $this;
    }

    /**
     * Get the User gender identity. (eg: male, female, queer, etc.)
     *
     * @return string|null
     */
    public function getGenderIdentity(): ?string
    {
        return $this->genderIdentity;
    }

    /**
     * Sets the User gender identity.
     * Free-form field.
     * Can be null.
     *
     * @param string|null $genderIdentity
     *
     * @return \App\Entity\User
     */
    public function setGenderIdentity(?string $genderIdentity): self
    {
        $this->genderIdentity = $genderIdentity;

        return $this;
    }

    /**
     * Get the User first name.
     * Should never be NULL except for ORM.
     *
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Sets the User first name.
     *
     * @param string $firstName
     *
     * @return \App\Entity\User
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the User middle name.
     *
     * @return string|null
     */
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    /**
     * Sets the User middle name.
     * Can be null.
     *
     * @param string|null $middleName
     *
     * @return \App\Entity\User
     */
    public function setMiddleName(?string $middleName): self
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * Get the User last name.
     * Should never be NULL except for ORM.
     *
     * @return string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * Sets the User last name.
     *
     * @param string $lastName
     *
     * @return \App\Entity\User
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the User email address.
     * Should never be NULL except for ORM.
     *
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Sets the User email address.
     *
     * @param string $email
     *
     * @return \App\Entity\User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the User phone number.
     * Can be null.
     *
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * Sets the User phone number.
     *
     * @param string|null $phoneNumber
     *
     * @return \App\Entity\User
     */
    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get the User password.
     * Should never be null except for ORM.
     * Should only be accessed by the Security layer.
     *
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Sets the User password.
     *
     * @param string $password
     *
     * @return \App\Entity\User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
