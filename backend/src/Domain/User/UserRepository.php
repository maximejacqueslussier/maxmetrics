<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Application\User\ListUsers\UsersListQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class UserRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, User::class);
    }

    public function findByUsersListQuery(UsersListQuery $usersListQuery): array
    {
        $qb = $this->createQueryBuilder('u');

        if ($usersListQuery->getIds() !== []) {
            $qb->andWhere(
                $qb->expr()->in('u.id', ':ids')
            )
            ->setParameter('ids', $usersListQuery->getIds());
        }

        if ($usersListQuery->getSorts() !== []) {
            foreach ($usersListQuery->getSorts() as $field => $direction) {
                $qb->addOrderBy("u.{$field}", $direction);
            }
        }

        if ($usersListQuery->getAfterId() !== null) {
            $qb->andWhere('u.id > :afterId')
                ->setParameter('afterId', $usersListQuery->getAfterId());
        }

        return $qb
            ->setMaxResults($usersListQuery->getLimit())
            ->getQuery()
            ->getResult();
    }
}
