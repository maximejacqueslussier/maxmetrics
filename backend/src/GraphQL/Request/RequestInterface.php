<?php

declare(strict_types=1);

namespace App\GraphQL\Request;

interface RequestInterface
{
    public function getQuery(): string;

    public function getVariables(): ?array;

    public function getOperationName(): ?string;
}
