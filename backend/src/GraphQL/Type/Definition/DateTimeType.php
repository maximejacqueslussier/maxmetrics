<?php

declare(strict_types=1);

namespace App\GraphQL\Type\Definition;

use DateTimeImmutable;
use DateTimeInterface;
use GraphQL\Error\Error;
use GraphQL\Error\SerializationError;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Language\Printer;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;
use Throwable;

use function is_string;

final class DateTimeType extends ScalarType
{
    public string $name = 'DateTime';
    public ?string $description = 'The `DateTime` scalar type represents ISO-8601 date and time data.';

    public function serialize(mixed $value): string
    {
        if ($value instanceof DateTimeInterface) {
            return $value->format(DateTimeInterface::ATOM);
        }

        $notDateTimeable = Utils::printSafe($value);
        throw new SerializationError("DateTime cannot represent value: {$notDateTimeable}");
    }

    public function parseValue(mixed $value): DateTimeImmutable
    {
        if (!is_string($value)) {
            $notString = Utils::printSafeJson($value);
            throw new Error("DateTime cannot represent a non string value: {$notString}");
        }

        try {
            return new DateTimeImmutable($value);
        } catch (Throwable) {
            throw new Error('DateTime has invalid format, expecting ISO-8601');
        }
    }

    public function parseLiteral(mixed $valueNode, ?array $variables = null): DateTimeImmutable
    {
        if (!$valueNode instanceof StringValueNode) {
            $notString = Printer::doPrint($valueNode);
            throw new Error("DateTime cannot represent a non string value: {$notString}", $valueNode);
        }

        try {
            return new DateTimeImmutable($valueNode->value);
        } catch (Throwable) {
            throw new Error('Invalid DateTime literal, expecting ISO-8601');
        }
    }
}
