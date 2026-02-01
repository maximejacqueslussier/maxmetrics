<?php

declare(strict_types=1);

namespace App\GraphQL\Request;

final readonly class Request implements RequestInterface
{
    /**
     * @param string $query
     * @param string[]|null $variables
     * @param string|null $operationName
     */
    public function __construct(
        private string $query,
        private ?array $variables,
        private ?string $operationName,
    ) {
    }

    /**
     * Get the GraphQL query as string.
     * Can be empty string.
     *
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * Get the GraphQL variables as an array of string.
     *
     * @return string[]|null
     */
    public function getVariables(): ?array
    {
        return $this->variables;
    }

    /**
     * Get the GraphQL operation name.
     * Can be null. Means only one operation.
     *
     * @return string|null
     */
    public function getOperationName(): ?string
    {
        return $this->operationName;
    }
}
