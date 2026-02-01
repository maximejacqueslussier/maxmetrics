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

    /**
     * Returns true if the previous exception matches the mapped exception.
     *
     * @param \GraphQL\Error\Error $error
     *
     * @return bool
     */
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

    /**
     * Formats the mapped exception into a GraphQL compliant error array.
     *
     * @param \GraphQL\Error\Error $error
     *
     * @return array<string, mixed>
     */
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

    /**
     * Higher than the default error formatter.
     *
     * @return int
     */
    public static function getPriority(): int
    {
        return 10;
    }

    /**
     * Get the configuration (code, message, field, extensions) for the mapped exception.
     *
     * return array<array<string, mixed>>
     */
    private function getConfig(Throwable $exception): array
    {
        foreach ($this->map as $class => $config) {
            if ($exception instanceof $class) {
                return $config;
            }
        }
    }
}
