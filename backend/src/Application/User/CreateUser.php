<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\Account\Account;
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
        private UserRepository $repository,
        private TranslatorInterface $translator,
        private ValidatorInterface $validator,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function execute(
        string $username,
        string $plainPassword,
        ?string $salutation,
        ?string $pronouns,
        ?string $genderIdentity,
        string $firstName,
        ?string $middleName,
        string $lastName,
        string $email,
        ?string $phoneNumber,
    ): object {
        $account = new Account();
        $account
            ->setUsername($username)
            ->setRoles(['ROLE_USER'])
        ;
        $account->setPassword($this->passwordHasher->hashPassword($account, $plainPassword));

        $user = $this->repository->createUser();
        $user
            ->setSalutation($salutation)
            ->setPronouns($pronouns)
            ->setGenderIdentity($genderIdentity)
            ->setFirstName($firstName)
            ->setMiddleName($middleName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setPhoneNumber($phoneNumber)
            ->setAccount($account)
        ;

        $accountErrors = $this->validator->validate($account);

        if (count($accountErrors) > 0) {
            throw new ValidationFailedException(
                $this->translator->trans('app.application.createUser.validationFailed'),
                $accountErrors,
            );
        }

        $userErrors = $this->validator->validate($user);

        if (count($userErrors) > 0) {
            throw new ValidationFailedException(
                $this->translator->trans('app.application.createUser.validationFailed'),
                $userErrors,
            );
        }

        return $this->entityManager->wrapInTransaction(function () use ($account, $user): object {
            $this->entityManager->persist($account);
            $this->entityManager->persist($user);

            return $user;
        });
    }
}
