<?php

declare(strict_types=1);

namespace App\GraphQL\Request;

final readonly class Request implements RequestInterface
{
    public function __construct(
        private string $query,
        private ?array $variables,
        private ?string $operationName,
    ) {
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getVariables(): ?array
    {
        return $this->variables;
    }

    public function getOperationName(): ?string
    {
        return $this->operationName;
    }
}
