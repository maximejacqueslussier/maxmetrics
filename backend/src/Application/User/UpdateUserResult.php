<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Entity\User;

/**
 * Represents the GraphQL result for the updateUser mutation.
 */
final readonly class UpdateUserResult
{
    /**
     * @param \App\Entity\User $user,
     * @param string[] $changedFields
     */
    public function __construct(
        private User $user,
        private array $changedFields,
    ) {
    }

    /**
     * Get the User entity.
     *
     * @return \App\Entity\User $user
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Get the changed fields from the updateUser mutation.
     *
     * @return string[]
     */
    public function getChangedFields(): array
    {
        return $this->changedFields;
    }
}
