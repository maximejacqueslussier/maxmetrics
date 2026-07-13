<?php

declare(strict_types=1);

namespace App\Infrastructure\Authentication;

use DateTime;
use Firebase\JWT\JWT;
use Symfony\Component\Security\Core\User\UserInterface;

use function time;

final readonly class JwtIssuer
{
    public function __construct(
        private string $jwtSecret,
        private string $jwtIssuer,
        private string $jwtAudience,
        private int $jwtTtl,
    ) {
    }

    public function issue(UserInterface $user): array
    {
        $now = time();

        $payload = [
            'iss' => $this->jwtIssuer,
            'aud' => $this->jwtAudience,
            'iat' => $now,
            'exp' => $now + $this->jwtTtl,
            'sub' => $user->getUserIdentifier(),
        ];

        return [
            'accessToken' => JWT::encode($payload, $this->jwtSecret, 'HS256'),
            'expiresAt' => (new DateTime())->setTimestamp($now + $this->jwtTtl),
        ];
    }
}
