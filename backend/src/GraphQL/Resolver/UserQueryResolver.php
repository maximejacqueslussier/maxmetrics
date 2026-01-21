<?php

declare(strict_types=1);

namespace App\GraphQL\Resolver;

use App\Application\User\ListUsers;

final readonly class UserQueryResolver
{
    public function __construct(
        private ListUsers $listUsers,
    ) {
    }

    /**
     * List all users.
     *
     * @return \App\Entity\User[]
     */
    public function listUsers(): iterable
    {
        return $this->listUsers->execute();
    }
}
