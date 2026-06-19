<?php

declare(strict_types=1);

namespace App\Application\Profile;

use App\Domain\Profile\Profile;
use App\Domain\Profile\ProfileNotFoundException;
use App\Domain\Profile\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use function count;

final readonly class UpdateProfile
{
    public function __construct(
        private ProfileRepository $repository,
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator,
        private ValidatorInterface $validator,
    ) {
    }

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
    ): UpdateProfileResult {
        $profile = $this->repository->find($id);

        if (!$profile) {
            throw new ProfileNotFoundException(
                $this->translator->trans('app.application.updateProfile.profileNotFoundException', ['{{ id }}' => $id]),
            );
        }

        $changedFields = [];

        if ($salutation !== null) {
            $profile->setSalutation($salutation);
            $changedFields[] = Profile::SALUTATION;
        }

        if ($pronouns !== null) {
            $profile->setPronouns($pronouns);
            $changedFields[] = Profile::PRONOUNS;
        }

        if ($genderIdentity !== null) {
            $profile->setGenderIdentity($genderIdentity);
            $changedFields[] = Profile::GENDER_IDENTITY;
        }

        if ($firstName !== null) {
            $profile->setFirstName($firstName);
            $changedFields[] = Profile::FIRST_NAME;
        }

        if ($middleName !== null) {
            $profile->setMiddleName($middleName);
            $changedFields[] = Profile::MIDDLE_NAME;
        }

        if ($lastName !== null) {
            $profile->setLastName($lastName);
            $changedFields[] = Profile::LAST_NAME;
        }

        if ($email !== null) {
            $profile->setEmail($email);
            $changedFields[] = Profile::EMAIL;
        }

        if ($phoneNumber !== null) {
            $profile->setPhoneNumber($phoneNumber);
            $changedFields[] = Profile::PHONE_NUMBER;
        }

        $errors = $this->validator->validate($profile);

        if (count($errors) > 0) {
            throw new ValidationFailedException(
                $this->translator->trans('app.application.updateProfile.validationFailed'),
                $errors,
            );
        }

        $this->entityManager->persist($profile);
        $this->entityManager->flush();

        return new UpdateProfileResult($profile, $changedFields);
    }
}
