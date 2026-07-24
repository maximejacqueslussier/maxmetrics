<?php

declare(strict_types=1);

namespace App\GraphQL\Type\Account;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class UpdatePasswordPayloadType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'UpdatePasswordPayload',
            'fields' => [
                'success' => [
                    'type' => Type::nonNull(Type::boolean()),
                ],
            ],
        ]);
    }
}
