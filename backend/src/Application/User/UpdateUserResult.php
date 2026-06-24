<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\User\User;

final readonly class UpdateUserResult
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
