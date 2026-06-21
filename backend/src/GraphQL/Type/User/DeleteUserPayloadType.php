<?php

declare(strict_types=1);

namespace App\GraphQL\Type\User;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

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
