<?php

declare(strict_types=1);

namespace App\Application\User\ListUsers;

use App\Application\User\UserRepository;

final readonly class ListUsers
{
    public function __construct(
        private UserRepository $repository,
    ) {
    }

    public function execute(UsersListQuery $query): iterable
    {
        return $this->repository->findByUsersListQuery($query);
    }
}
