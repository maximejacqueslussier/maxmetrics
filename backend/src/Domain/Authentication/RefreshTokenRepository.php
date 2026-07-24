<?php

declare(strict_types=1);

namespace App\Domain\Authentication;

use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class RefreshTokenRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, RefreshToken::class);
    }

    public function deleteExpiredOrRevoked(DateTime $now): int
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
            DELETE
            FROM App\Domain\Authentication\RefreshToken rf
            WHERE rf.expiresAt <= :now OR rf.revokedAt IS NOT NULL
        ')->setParameter('now', $now);

        return $query->execute();
    }
}
