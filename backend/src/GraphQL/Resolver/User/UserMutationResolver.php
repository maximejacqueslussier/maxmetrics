<?php

declare(strict_types=1);

namespace App\GraphQL\Resolver\User;

use App\Application\User\CreateUser;
use App\Application\User\DeleteUser;
use App\Application\User\UpdateUser;

final readonly class UserMutationResolver
{
    public function __construct(
        private CreateUser $createUser,
        private UpdateUser $updateUser,
        private DeleteUser $deleteUser,
    ) {
    }

    public function createUser(mixed $root, array $args): array
    {
        $input = $args['input'];

        $user = $this->createUser->execute(
            $input['username'],
            $input['password'],
            $input['salutation'] ?? null,
            $input['pronouns'] ?? null,
            $input['genderIdentity'] ?? null,
            $input['firstName'],
            $input['middleName'] ?? null,
            $input['lastName'],
            $input['email'],
            $input['phoneNumber'] ?? null,
        );

        return ['user' => $user];
    }

    public function updateUser(mixed $root, array $args): array
    {
        $id = (int) $args['id'];
        $input = $args['input'];

        $result = $this->updateUser->execute(
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
            'user' => $result->getUser(),
            'changedFields' => $result->getChangedFields(),
        ];
    }

    public function deleteUser(mixed $root, array $args): array
    {
        $id = (int) $args['id'];

        $this->deleteUser->execute($id);

        return ['deletedUserId' => $id];
    }
}
