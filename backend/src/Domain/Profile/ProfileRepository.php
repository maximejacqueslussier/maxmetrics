<?php

declare(strict_types=1);

namespace App\Domain\Profile;

use App\Application\Profile\ListProfiles\ProfilesListQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ProfileRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, Profile::class);
    }

    public function findByProfilesListQuery(ProfilesListQuery $profilesListQuery): array
    {
        $qb = $this->createQueryBuilder('u');

        if ($profilesListQuery->getIds() !== []) {
            $qb->andWhere(
                $qb->expr()->in('u.id', ':ids')
            )
            ->setParameter('ids', $profilesListQuery->getIds());
        }

        if ($profilesListQuery->getSorts() !== []) {
            foreach ($profilesListQuery->getSorts() as $field => $direction) {
                $qb->addOrderBy("u.{$field}", $direction);
            }
        }

        if ($profilesListQuery->getAfterId() !== null) {
            $qb->andWhere('u.id > :afterId')
               ->setParameter('afterId', $profilesListQuery->getAfterId());
        }

        $qb->setMaxResults($profilesListQuery->getLimit());
        $query = $qb->getQuery();

        return $query->execute();
    }
}
