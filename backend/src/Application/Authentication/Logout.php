<?php

declare(strict_types=1);

namespace App\Application\Authentication;

use App\Domain\Authentication\RefreshTokenRepository;
use App\Infrastructure\Authentication\RefreshTokenHasher;
use Doctrine\ORM\EntityManagerInterface;

final readonly class Logout
{
    public function __construct(
        private RefreshTokenHasher $refreshTokenHasher,
        private RefreshTokenRepository $repository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function execute(?string $rawToken = null): void
    {
        if ($rawToken === null || $rawToken === '') {
            return;
        }

        $tokenHash = $this->refreshTokenHasher->hash($rawToken);
        $refreshToken = $this->repository->findOneByTokenHash($tokenHash);

        if (!$refreshToken) {
            return;
        }

        if ($refreshToken->getRevokedAt() !== null) {
            return;
        }

        $refreshToken->revoke();
        $this->entityManager->flush();
    }
}
