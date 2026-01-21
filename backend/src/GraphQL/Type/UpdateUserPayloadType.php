<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * Represents the user update payload.
 * Wraps the UpdateUserResult class which contains the User object and a changedFields array.
 */
final class UpdateUserPayloadType extends ObjectType
{
    public function __construct(
        UserType $type,
    ) {
        parent::__construct([
            'name' => 'UpdateUserPayload',
            'fields' => [
                'user' => [
                    'type' => Type::nonNull($type),
                ],
                'changedFields' => [
                    'type' => Type::nonNull(Type::listOf(Type::nonNull(Type::string()))),
                ],
            ],
        ]);
    }
}
