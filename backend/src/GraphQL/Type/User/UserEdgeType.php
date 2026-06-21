<?php

declare(strict_types=1);

namespace App\GraphQL\Type\User;

use App\GraphQL\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class UserEdgeType extends ObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
    ) {
        parent::__construct([
            'name' => 'UserEdge',
            'fields' => [
                'node' => Type::nonNull($typeRegistry->user()),
                'cursor' => Type::nonNull(Type::string()),
            ],
        ]);
    }
}
