<?php

declare(strict_types=1);

namespace App\Infrastructure\Authentication;

use hash;

final readonly class RefreshTokenHasher
{
    public function hash(string $rawToken): string
    {
        return hash('sha256', $rawToken);
    }
}
