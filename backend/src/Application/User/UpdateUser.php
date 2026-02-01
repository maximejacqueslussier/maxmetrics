<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    /**
     * Updates an existing user.
     *
     * @param int $id
     * @param string|null $salutation
     * @param string|null $pronouns
     * @param string|null $genderIdentity
     * @param string|null $firstName
     * @param string|null $middleName
     * @param string|null $lastName
     * @param string|null $email
     * @param string|null $phoneNumber
     *
     * @return \App\Domain\User\User
     */
    public function execute(
        int $id,
        ?string $salutation,
        ?string $pronouns,
        ?string $genderIdentity,
        ?string $firstName,
        ?string $middleName,
        ?string $lastName,
        ?string $email,
        ?string $phoneNumber,
    ): UpdateUserResult {
        $user = $this->repository->find($id);

        if (!$user) {
            throw new UserNotFoundException(
                $this->translator->trans('app.application.updateUser.userNotFoundException', ['{{ id }}' => $id]),
            );
        }

        $changedFields = [];

        if ($salutation !== null) {
            $user->setSalutation($salutation);
            $changedFields[] = User::SALUTATION;
        }

        if ($pronouns !== null) {
            $user->setPronouns($pronouns);
            $changedFields[] = User::PRONOUNS;
        }

        if ($genderIdentity !== null) {
            $user->setGenderIdentity($genderIdentity);
            $changedFields[] = User::GENDER_IDENTITY;
        }

        if ($firstName !== null) {
            $user->setFirstName($firstName);
            $changedFields[] = User::FIRST_NAME;
        }

        if ($middleName !== null) {
            $user->setMiddleName($middleName);
            $changedFields[] = User::MIDDLE_NAME;
        }

        if ($lastName !== null) {
            $user->setLastName($lastName);
            $changedFields[] = User::LAST_NAME;
        }

        if ($email !== null) {
            $user->setEmail($email);
            $changedFields[] = User::EMAIL;
        }

        if ($phoneNumber !== null) {
            $user->setPhoneNumber($phoneNumber);
            $changedFields[] = User::PHONE_NUMBER;
        }

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            throw new ValidationFailedException(
                $this->translator->trans('app.application.updateUser.validationFailed'),
                $errors,
            );
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new UpdateUserResult($user, $changedFields);
    }
}
