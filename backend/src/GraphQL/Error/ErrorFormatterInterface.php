<?php

declare(strict_types=1);

namespace App\GraphQL\Error;

use GraphQL\Error\Error;

interface ErrorFormatterInterface
{
    /**
     * Does it supports the current GraphQLError.
     *
     * @return bool
     */
    public function supports(Error $error): bool;

    /**
     * Format the error messages as array of strings.
     *
     * @return array<string, mixed>
     */
    public function format(Error $error): array;

    /**
     * Get the ErrorFormatter priority.
     *
     * @return int
     */
    public static function getPriority(): int;
}
