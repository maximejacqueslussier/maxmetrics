<?php

declare(strict_types=1);

namespace App\Application\Authentication;

use App\Domain\User\UserRepository;

final readonly class Login
{
    public function __construct(
        private UserRepository $repository,
    ) {
    }

    public function execute(string $username, string $password): LoginResult
    {
        $user = $this->repository->findByUsernameAndPassword($username, $password);

        return new LoginResult($user, $accessToken, $expiresAt);
    }
}
