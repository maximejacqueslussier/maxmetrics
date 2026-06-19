<?php

declare(strict_types=1);

namespace App\GraphQL\Error;

use GraphQL\Error\DebugFlag;
use GraphQL\Error\Error;
use GraphQL\Error\FormattedError;

use function array_replace_recursive;

final readonly class ErrorFormatterChain
{
    public function __construct(
        private iterable $errorFormatters,
        private bool $isDebug,
    ) {
    }

    public function format(Error $error): array
    {
        $debugFlags = $this->isDebug
            ? DebugFlag::INCLUDE_DEBUG_MESSAGE | DebugFlag::INCLUDE_TRACE
            : DebugFlag::NONE;

        $base = FormattedError::createFromException($error, $debugFlags);

        foreach ($this->errorFormatters as $errorFormatter) {
            if ($errorFormatter->supports($error)) {
                $specific = $errorFormatter->format($error);

                return array_replace_recursive($base, $specific);
            }
        }

        return $base;
    }
}
