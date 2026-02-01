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

    /**
     * Returns true if the previous exception is an instance of ValidationFailedException.
     *
     * @param \GraphQL\Error\Error
     *
     * @return bool
     */
    public function supports(Error $error): bool
    {
        $exception = $error->getPrevious();

        return $exception instanceof ValidationFailedException;
    }

    /**
     * Formats a ValidationFailedException into an array of data explaining the validation errors.
     *
     * @param \GraphQL\Error\Error
     *
     * @return array<string, mixed>
     */
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

    /**
     * Get a high priority because this depends on User Validation.
     *
     * @return int
     */
    public static function getPriority(): int
    {
        return 10;
    }
}
