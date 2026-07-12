<?php

declare(strict_types=1);

namespace App\Infrastructure\Authentication;

use function bin2hex;
use function random_bytes;

final readonly class RefreshTokenIssuer
{
    public function __construct(
        private RefreshTokenHasher $refreshTokenHasher,
    ) {
    }

    public function issue(): array
    {
        $refreshToken = bin2hex(random_bytes(32));

        return [
            'rawToken' => $refreshToken,
            'hashedToken' => $this->refreshTokenHasher->hash($refreshToken),
        ];
    }
}