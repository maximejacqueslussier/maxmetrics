<?php

declare(strict_types=1);

namespace App\Application\User\ListUsers;

use App\Domain\User\UserRepository;

use function is_array;

final readonly class ListUsers
{
    public function __construct(
        private UserRepository $repository,
    ) {
    }

    /**
     * Returns all users matching the query.
     *
     * @return \App\Domain\User\User[]
     */
    public function execute(UsersListQuery $query): iterable
    {
        return $this->repository->findByUsersListQuery($query);
    }
}
