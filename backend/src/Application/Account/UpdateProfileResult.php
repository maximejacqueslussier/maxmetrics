<?php

declare(strict_types=1);

namespace App\Application\Account;

use App\Domain\User\User;

final readonly class UpdateProfileResult
{
    public function __construct(
        private User $user,
        private array $changedFields,
    ) {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getChangedFields(): array
    {
        return $this->changedFields;
    }
}
