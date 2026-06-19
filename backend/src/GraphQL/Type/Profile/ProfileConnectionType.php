<?php

declare(strict_types=1);

namespace App\GraphQL\Type\Profile;

use App\GraphQL\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class ProfileConnectionType extends ObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
    ) {
        parent::__construct([
            'name' => 'ProfileConnection',
            'fields' => [
                'edges' => Type::nonNull(Type::listOf(Type::nonNull($typeRegistry->profileEdge()))),
                'pageInfo' => Type::nonNull($typeRegistry->pageInfo()),
            ],
        ]);
    }
}
