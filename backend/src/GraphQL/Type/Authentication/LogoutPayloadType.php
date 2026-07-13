<?php

declare(strict_types=1);

namespace App\GraphQL\Type\Authentication;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class LogoutPayloadType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'LogoutPayload',
            'fields' => [
                'success' => [
                    'type' => Type::nonNull(Type::boolean()),
                ],
            ],
        ]);
    }
}
