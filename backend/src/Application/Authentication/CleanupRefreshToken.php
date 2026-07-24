<?php

declare(strict_types=1);

namespace App\Application\Authentication;

use App\Domain\Authentication\RefreshTokenRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

final readonly class CleanupRefreshToken
{
    public function __construct(
        private RefreshTokenRepository $repository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function execute(DateTime $now): void
    {
        $this->repository->deleteExpiredOrRevoked($now);
        $this->entityManager->flush();
    }
}
