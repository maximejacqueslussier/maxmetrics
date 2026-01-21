<?php

declare(strict_types=1);

namespace App\GraphQL\Resolver;

use App\Application\User\CreateUser;
use App\Application\User\DeleteUser;
use App\Application\User\UpdateUser;
use App\Entity\User;

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
     * @return array<\App\Entity\User>
     */
    public function createUser(mixed $root, array $args): array
    {
        $input = $args['input'];

        $user = $this->createUser->execute(
            $input[User::SALUTATION] ?? null,
            $input[User::PRONOUNS] ?? null,
            $input[User::GENDER_IDENTITY] ?? null,
            $input[User::FIRST_NAME],
            $input[User::MIDDLE_NAME] ?? null,
            $input[User::LAST_NAME],
            $input[User::EMAIL],
            $input[User::PHONE_NUMBER] ?? null,
            $input[User::PASSWORD]
        );

        return ['user' => $user];
    }

    /**
     * Updates an existing User.
     *
     * @param mixed $root
     * @param string[][] $args
     *
     * @return array<\App\Entity\User>
     */
    public function updateUser(mixed $root, array $args): array
    {
        $id = (int) $args[User::ID];
        $input = $args['input'];

        $result = $this->updateUser->execute(
            $id,
            $input[User::SALUTATION] ?? null,
            $input[User::PRONOUNS] ?? null,
            $input[User::GENDER_IDENTITY] ?? null,
            $input[User::FIRST_NAME] ?? null,
            $input[User::MIDDLE_NAME] ?? null,
            $input[User::LAST_NAME] ?? null,
            $input[User::EMAIL] ?? null,
            $input[User::PHONE_NUMBER] ?? null,
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
        $id = (int) $args[User::ID];

        $user = $this->deleteUser->execute($id);

        return ['deletedUserId' => $id];
    }
}
