<?php

declare(strict_types=1);

namespace App\Application\Profile\ListProfiles;

use App\Domain\Profile\ProfileRepository;

use function is_array;

final readonly class ListProfiles
{
    public function __construct(
        private ProfileRepository $repository,
    ) {
    }

    public function execute(ProfilesListQuery $query): iterable
    {
        return $this->repository->findByProfilesListQuery($query);
    }
}
