<?php

declare(strict_types=1);

namespace App\Domain\Profile;

use App\Application\User\UserRepository;
use App\Application\User\ListUsers\UsersListQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ProfileRepository extends ServiceEntityRepository implements UserRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, Profile::class);
    }

    public function createUser(): object
    {
        return new Profile();
    }

    public function findUser(int $id): ?object
    {
        return $this->find($id);
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

        $qb->setMaxResults($usersListQuery->getLimit());
        $query = $qb->getQuery();

        return $query->execute();
    }
}
