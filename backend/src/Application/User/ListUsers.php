<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Repository\UserRepository;

final readonly class ListUsers
{
    public function __construct(
        private UserRepository $repository,
    ) {
    }

    /**
     * Returns all users.
     *
     * @return \App\Entity\User[]
     */
    public function execute(): iterable
    {
        return $this->repository->findAll();
    }
}
