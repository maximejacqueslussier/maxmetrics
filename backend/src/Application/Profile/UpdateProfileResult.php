<?php

declare(strict_types=1);

namespace App\Application\Profile;

use App\Domain\Profile\Profile;

final readonly class UpdateProfileResult
{
    public function __construct(
        private Profile $profile,
        private array $changedFields,
    ) {
    }

    public function getProfile(): Profile
    {
        return $this->profile;
    }

    public function getChangedFields(): array
    {
        return $this->changedFields;
    }
}
