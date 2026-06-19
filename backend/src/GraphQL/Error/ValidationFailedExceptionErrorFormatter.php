<?php

declare(strict_types=1);

namespace App\GraphQL\Error;

use GraphQL\Error\Error;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class ValidationFailedExceptionErrorFormatter implements ErrorFormatterInterface
{
    public function __construct(
        private TranslatorInterface $translator,
    ) {
    }

    public function supports(Error $error): bool
    {
        $exception = $error->getPrevious();

        return $exception instanceof ValidationFailedException;
    }

    public function format(Error $error): array
    {
        $exception = $error->getPrevious();
        $fieldErrors = [];

        foreach ($exception->getViolations() as $violation) {
            $fieldErrors[$violation->getPropertyPath()] = $this->translator->trans(
                $violation->getMessage()
            );
        }

        return [
            'message' => $exception->getValue(),
            'path' => $error->getPath(),
            'extensions' => [
                'code' => 'VALIDATION_ERROR',
                'fields' => $fieldErrors,
            ],
        ];
    }

    public static function getPriority(): int
    {
        return 10;
    }
}
