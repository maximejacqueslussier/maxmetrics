<?php

declare(strict_types=1);

namespace App\Application\Account;

use App\Domain\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

use function count;

final readonly class UpdateProfile
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator,
        private TranslatorInterface $translator,
    ) {
    }

    public function execute(
        User $user,
        ?string $salutation = null,
        ?string $pronouns = null,
        ?string $genderIdentity = null,
        ?string $phoneNumber = null,
    ): array {
        $changedFields = [];

        if ($salutation !== null) {
            $user->setSalutation($salutation);
            $changedFields[] = 'salutation';
        }

        if ($pronouns !== null) {
            $user->setPronouns($pronouns);
            $changedFields[] = 'pronouns';
        }

        if ($genderIdentity !== null) {
            $user->setGenderIdentity($genderIdentity);
            $changedFields[] = 'genderIdentity';
        }

        if ($phoneNumber !== null) {
            $user->setPhoneNumber($phoneNumber);
            $changedFields[] = 'phoneNumber';
        }

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            throw new ValidationFailedException(
                $this->translator->trans('app.application.updateProfile.validationFailed'),
                $errors,
            );
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $changedFields;
    }
}
