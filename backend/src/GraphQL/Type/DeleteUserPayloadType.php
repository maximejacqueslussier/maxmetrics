<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * Represents the user hard deletion payload.
 * Returns the deleted User ID.
 */
final class DeleteUserPayloadType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'DeleteUserPayload',
            'fields' => [
                'deletedUserId' => [
                    'type' => Type::nonNull(Type::id()),
                ],
            ],
        ]);
    }
}
