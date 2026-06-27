<?php

declare(strict_types=1);

namespace App\Application\Authentication;

use App\Domain\User\User;
use DateTime;

final class LoginResult
{
    public function __construct(
        private User $user,
        private string $accessToken,
        private DateTime $expiresAt,
    ) {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getExpiresAt(): DateTime
    {
        return $this->expiresAt;
    }
}
