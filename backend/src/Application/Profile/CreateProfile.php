<?php

declare(strict_types=1);

namespace App\Application\Profile;

use App\Domain\Profile\Profile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Contracts\Translation\TranslatorInterface;

use function count;

final readonly class CreateProfile
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator,
        private ValidatorInterface $validator,
    ) {
    }

    public function execute(
        ?string $salutation,
        ?string $pronouns,
        ?string $genderIdentity,
        string $firstName,
        ?string $middleName,
        string $lastName,
        string $email,
        ?string $phoneNumber,
    ): Profile {
        $profile = new Profile();
        $profile
            ->setSalutation($salutation)
            ->setPronouns($pronouns)
            ->setGenderIdentity($genderIdentity)
            ->setFirstName($firstName)
            ->setMiddleName($middleName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setPhoneNumber($phoneNumber)
        ;

        $errors = $this->validator->validate($profile);

        if (count($errors) > 0) {
            throw new ValidationFailedException(
                $this->translator->trans('app.application.createProfile.validationFailed'),
                $errors,
            );
        }

        $this->entityManager->persist($profile);
        $this->entityManager->flush();

        return $profile;
    }
}
