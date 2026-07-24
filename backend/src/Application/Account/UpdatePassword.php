<?php

declare(strict_types=1);

namespace App\Application\Account;

use App\Domain\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class UpdatePassword
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator,
        private TranslatorInterface $translator,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function execute(User $user, string $newPassword): void
    {
        $user->setPassword($this->passwordHasher->hashPassword($user, $newPassword));

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            throw new ValidationFailedException(
                $this->translator->trans('app.application.updatePassword.validationFailed'),
                $errors,
            );
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
