<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Application\User\ListUsers\UsersListQuery;

interface UserRepository
{
    public function createUser(): object;

    public function findUser(int $id): ?object;

    public function findByUsersListQuery(UsersListQuery $usersListQuery): array;
}
