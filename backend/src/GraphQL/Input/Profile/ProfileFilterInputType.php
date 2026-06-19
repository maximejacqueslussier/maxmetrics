<?php

declare(strict_types=1);

namespace App\GraphQL\Input\Profile;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

final class ProfileFilterInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'ProfileFilterInput',
            'fields' => [
                'ids' => [
                    'type' => Type::listOf(Type::nonNull(Type::id())),
                ],
            ],
        ]);
    }
}
