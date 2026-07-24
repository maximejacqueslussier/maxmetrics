<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

use function count;

final readonly class CreateUser
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator,
        private ValidatorInterface $validator,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function execute(
        string $username,
        string $plainPassword,
        string $role,
        ?string $salutation,
        ?string $pronouns,
        ?string $genderIdentity,
        string $firstName,
        ?string $middleName,
        string $lastName,
        string $email,
        ?string $phoneNumber,
    ): User {
        $user = new User();
        $user
            ->setUsername($username)
            ->setRoles([$role])
            ->setSalutation($salutation)
            ->setPronouns($pronouns)
            ->setGenderIdentity($genderIdentity)
            ->setFirstName($firstName)
            ->setMiddleName($middleName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setPhoneNumber($phoneNumber)
        ;
        $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            throw new ValidationFailedException(
                $this->translator->trans('app.application.createUser.validationFailed'),
                $errors,
            );
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
