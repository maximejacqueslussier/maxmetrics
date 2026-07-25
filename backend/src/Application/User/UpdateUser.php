<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\User\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

use function count;

final readonly class UpdateUser
{
    public function __construct(
        private UserRepository $repository,
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator,
        private ValidatorInterface $validator,
    ) {
    }

    public function execute(
        int $id,
        ?string $role = null,
        ?string $salutation = null,
        ?string $pronouns = null,
        ?string $genderIdentity = null,
        ?string $firstName = null,
        ?string $middleName = null,
        ?string $lastName = null,
        ?string $email = null,
        ?string $phoneNumber = null,
        ?DateTime $dateOfBirth = null,
    ): UpdateUserResult {
        $user = $this->repository->find($id);

        if (!$user) {
            throw new UserNotFoundException(
                $this->translator->trans('app.application.updateUser.userNotFoundException', ['{{ id }}' => $id]),
            );
        }

        $changedFields = [];

        if ($role !== null) {
            $user->setRoles([$role]);
            $changedFields[] = 'role';
        }

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

        if ($firstName !== null) {
            $user->setFirstName($firstName);
            $changedFields[] = 'firstName';
        }

        if ($middleName !== null) {
            $user->setMiddleName($middleName);
            $changedFields[] = 'middleName';
        }

        if ($lastName !== null) {
            $user->setLastName($lastName);
            $changedFields[] = 'lastName';
        }

        if ($email !== null) {
            $user->setEmail($email);
            $changedFields[] = 'email';
        }

        if ($phoneNumber !== null) {
            $user->setPhoneNumber($phoneNumber);
            $changedFields[] = 'phoneNumber';
        }

        if ($dateOfBirth !== null) {
            $user->setDateOfBirth($dateOfBirth);
            $changedFields[] = 'dateOfBirth';
        }

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            throw new ValidationFailedException(
                $this->translator->trans('app.application.updateUser.validationFailed'),
                $errors,
            );
        }

        $this->entityManager->flush();

        return new UpdateUserResult($user, $changedFields);
    }
}
