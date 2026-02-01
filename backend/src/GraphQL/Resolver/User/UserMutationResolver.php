<?php

declare(strict_types=1);

namespace App\GraphQL\Resolver\User;

use App\Application\User\CreateUser;
use App\Application\User\DeleteUser;
use App\Application\User\UpdateUser;
use App\Domain\User\User;

final readonly class UserMutationResolver
{
    public function __construct(
        private CreateUser $createUser,
        private UpdateUser $updateUser,
        private DeleteUser $deleteUser,
    ) {
    }

    /**
     * Creates a new User.
     *
     * @param mixed $root
     * @param string[][] $args
     *
     * @return array<\App\Domain\User\User>
     */
    public function createUser(mixed $root, array $args): array
    {
        $input = $args['input'];

        $user = $this->createUser->execute(
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

    /**
     * Updates an existing User.
     *
     * @param mixed $root
     * @param string[][] $args
     *
     * @return array<\App\Domain\User\User>
     */
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

    /**
     * Deletes an existing User.
     *
     * @param mixed $root
     * @param string[][] $args
     *
     * @return array<int>
     */
    public function deleteUser(mixed $root, array $args): array
    {
        $id = (int) $args['id'];

        $user = $this->deleteUser->execute($id);

        return ['deletedUserId' => $id];
    }
}
