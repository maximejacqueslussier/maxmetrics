<?php

declare(strict_types=1);

namespace App\Application\Authentication;

use App\Domain\User\User;
use DateTime;

final class LoginResult
{
    public function __construct(
        private User $user,
        private string $token,
        private DateTime $expiresAt,
    ) {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getExpiresAt(): DateTime
    {
        return $this->expiresAt;
    }
}
