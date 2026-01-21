<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * Represents the user creation payload.
 * Wraps the User object.
 */
final class CreateUserPayloadType extends ObjectType
{
    public function __construct(
        UserType $type,
    ) {
        parent::__construct([
            'name' => 'CreateUserPayload',
            'fields' => [
                'user' => [
                    'type' => Type::nonNull($type),
                ],
            ],
        ]);
    }
}
