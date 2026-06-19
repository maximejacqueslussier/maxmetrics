<?php

declare(strict_types=1);

namespace App\GraphQL\Resolver\Profile;

use App\Application\Profile\CreateProfile;
use App\Application\Profile\DeleteProfile;
use App\Application\Profile\UpdateProfile;
use App\Domain\Profile\Profile;

final readonly class ProfileMutationResolver
{
    public function __construct(
        private CreateProfile $createProfile,
        private UpdateProfile $updateProfile,
        private DeleteProfile $deleteProfile,
    ) {
    }

    public function createProfile(mixed $root, array $args): array
    {
        $input = $args['input'];

        $profile = $this->createProfile->execute(
            $input['salutation'] ?? null,
            $input['pronouns'] ?? null,
            $input['genderIdentity'] ?? null,
            $input['firstName'],
            $input['middleName'] ?? null,
            $input['lastName'],
            $input['email'],
            $input['phoneNumber'] ?? null,
        );

        return ['profile' => $profile];
    }

    public function updateProfile(mixed $root, array $args): array
    {
        $id = (int) $args['id'];
        $input = $args['input'];

        $result = $this->updateProfile->execute(
            $id,
            $input['salutation'] ?? null,
            $input['pronouns'] ?? null,
            $input['genderIdentity'] ?? null,
            $input['firstName'] ?? null,
            $input['middleName'] ?? null,
            $input['lastName'] ?? null,
            $input['email'] ?? null,
            $input['phoneNumber'] ?? null,
        );

        return [
            'profile' => $result->getProfile(),
            'changedFields' => $result->getChangedFields(),
        ];
    }

    public function deleteProfile(mixed $root, array $args): array
    {
        $id = (int) $args['id'];

        $profile = $this->deleteProfile->execute($id);

        return ['deletedProfileId' => $id];
    }
}
