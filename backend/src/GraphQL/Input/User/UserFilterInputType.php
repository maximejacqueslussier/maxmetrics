<?php

declare(strict_types=1);

namespace App\GraphQL\Input\User;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

final class UserFilterInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'UserFilterInput',
            'fields' => [
                'ids' => [
                    'type' => Type::listOf(Type::nonNull(Type::id())),
                ],
            ],
        ]);
    }
}
