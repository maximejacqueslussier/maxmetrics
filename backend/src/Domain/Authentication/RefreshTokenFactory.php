<?php

declare(strict_types=1);

namespace App\Domain\Authentication;

use App\Domain\User\User;
use DateTime;

use function time;

final readonly class RefreshTokenFactory
{
    public function __construct(
        private int $refreshTokenTtl,
    ) {
    }

    public function create(string $hashedToken, User $user): RefreshToken
    {
        $timeExpiresAt = time() + $this->refreshTokenTtl;
        $expiresAt = new DateTime();
        $expiresAt->setTimestamp($timeExpiresAt);

        $refreshToken = new RefreshToken();
        $refreshToken
            ->setTokenHash($hashedToken)
            ->setExpiresAt($expiresAt)
            ->setUser($user);
        
        return $refreshToken;
    }
}