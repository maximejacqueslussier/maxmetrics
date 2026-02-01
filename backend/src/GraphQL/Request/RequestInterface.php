<?php

declare(strict_types=1);

namespace App\GraphQL\Request;

interface RequestInterface
{
    /**
     * Get the GraphQL query as string.
     * Can be empty string.
     *
     * @return string
     */
    public function getQuery(): string;

    /**
     * Get the GraphQL variables as an array of string.
     *
     * @return string[]|null
     */
    public function getVariables(): ?array;

    /**
     * Get the GraphQL operation name.
     * Can be null. Means only one operation.
     *
     * @return string|null
     */
    public function getOperationName(): ?string;
}
