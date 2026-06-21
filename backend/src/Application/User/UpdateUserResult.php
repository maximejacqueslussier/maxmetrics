<?php

declare(strict_types=1);

namespace App\Application\User;

final readonly class UpdateUserResult
{
    public function __construct(
        private object $user,
        private array $changedFields,
    ) {
    }

    public function getUser(): object
    {
        return $this->user;
    }

    public function getChangedFields(): array
    {
        return $this->changedFields;
    }
}
