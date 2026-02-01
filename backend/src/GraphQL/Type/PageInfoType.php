<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class PageInfoType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'PageInfo',
            'fields' => [
                'hasPreviousPage' => Type::nonNull(Type::boolean()),
                'hasNextPage' => Type::nonNull(Type::boolean()),
                'startCursor' => Type::string(),
                'endCursor' => Type::string(),
            ],
        ]);
    }
}
