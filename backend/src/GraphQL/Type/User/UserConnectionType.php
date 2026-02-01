<?php

declare(strict_types=1);

namespace App\GraphQL\Type\User;

use App\GraphQL\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class UserConnectionType extends ObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
    ) {
        parent::__construct([
            'name' => 'UserConnection',
            'fields' => [
                'edges' => Type::nonNull(Type::listOf(Type::nonNull($typeRegistry->userEdge()))),
                'pageInfo' => Type::nonNull($typeRegistry->pageInfo()),
            ],
        ]);
    }
}
