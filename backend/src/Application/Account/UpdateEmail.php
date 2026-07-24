<?php

declare(strict_types=1);

namespace App\Application\Account;

use App\Domain\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class UpdateEmail
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator,
        private TranslatorInterface $translator,
    ) {
    }

    public function execute(User $user, string $newEmail): void
    {
        $user->setEmail($newEmail);

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            throw new ValidationFailedException(
                $this->translator->trans('app.application.updateEmail.validationFailed'),
                $errors,
            );
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
