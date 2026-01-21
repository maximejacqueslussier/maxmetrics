<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Contracts\Translation\TranslatorInterface;

use function count;

final readonly class CreateUser
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator,
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * Creates a new User.
     *
     * @param string|null $salutation
     * @param string|null $pronouns
     * @param string|null $genderIdentity
     * @param string $firstName
     * @param string|null $middleName
     * @param string $lastName
     * @param string $email
     * @param string|null $phoneNumber
     * @param string $password
     *
     * @return \App\Entity\User
     */
    public function execute(
        ?string $salutation,
        ?string $pronouns,
        ?string $genderIdentity,
        string $firstName,
        ?string $middleName,
        string $lastName,
        string $email,
        ?string $phoneNumber,
        string $password
    ): User {
        $user = new User();
        $user
            ->setSalutation($salutation)
            ->setPronouns($pronouns)
            ->setGenderIdentity($genderIdentity)
            ->setFirstName($firstName)
            ->setMiddleName($middleName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setPhoneNumber($phoneNumber)
            ->setPassword($password)
        ;

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            throw new ValidationFailedException(
                $this->translator->trans('app.application.createUser.validationFailed'),
                $errors,
            );
        }

        $this->entityManager->persist($user);

        return $user;
    }
}
