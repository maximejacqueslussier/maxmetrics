<?php

declare(strict_types=1);

namespace App\GraphQL\Error;

use GraphQL\Error\Error;

interface ErrorFormatterInterface
{
    public function supports(Error $error): bool;

    public function format(Error $error): array;

    public static function getPriority(): int;
}
