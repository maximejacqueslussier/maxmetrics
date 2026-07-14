<?php

declare(strict_types=1);

namespace App\Application\Authentication;

use DateTime;

final readonly class RotateRefreshTokenResult
{
    public function __construct(
        private string $accessToken,
        private DateTime $accessTokenExpiresAt,
        private string $rawRefreshToken,
        private DateTime $refreshTokenExpiresAt,
    ) {
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getAccessTokenExpiresAt(): DateTime
    {
        return $this->accessTokenExpiresAt;
    }

    public function getRawRefreshToken(): string
    {
        return $this->rawRefreshToken;
    }

    public function getRefreshTokenExpiresAt(): DateTime
    {
        return $this->refreshTokenExpiresAt;
    }
}
