<?php

declare(strict_types=1);

namespace App\GraphQL\Error;

use GraphQL\Error\Error;
use Throwable;

use function array_key_exists;
use function array_replace_recursive;

final readonly class ExceptionMapErrorFormatter implements ErrorFormatterInterface
{
    public function __construct(
        private array $map,
    ) {
    }

    public function supports(Error $error): bool
    {
        $exception = $error->getPrevious();

        if (!$exception) {
            return false;
        }

        foreach ($this->map as $class => $config) {
            if ($exception instanceof $class) {
                return true;
            }
        }

        return false;
    }

    public function format(Error $error): array
    {
        $exception = $error->getPrevious();
        $config = $this->getConfig($exception);
        $message = $config['message'] ?? $exception->getMessage();
        $field = $config['field'] ?? null;
        $extensions = [];

        if (!empty($config['code'])) {
            $extensions['code'] = $config['code'];
        }

        if ($field !== null) {
            $extensions['fields'] = [$field => $exception->getMessage()];
        }

        if (array_key_exists('extensions', $config)) {
            $extensions = array_replace_recursive($extensions, $config['extensions']);
        }

        return [
            'message' => $message,
            'extensions' => $extensions,
        ];
    }

    public static function getPriority(): int
    {
        return 10;
    }

    private function getConfig(Throwable $exception): array
    {
        foreach ($this->map as $class => $config) {
            if ($exception instanceof $class) {
                return $config;
            }
        }
    }
}
