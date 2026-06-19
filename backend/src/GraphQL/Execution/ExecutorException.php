<?php

declare(strict_types=1);

namespace App\GraphQL\Execution;

use GraphQL\Executor\ExecutionResult;
use RuntimeException;

final class ExecutorException extends RuntimeException
{
    public function __construct(
        private ExecutionResult $result,
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getResult(): ExecutionResult
    {
        return $this->result;
    }
}
