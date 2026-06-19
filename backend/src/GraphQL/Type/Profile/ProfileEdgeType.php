<?php

declare(strict_types=1);

namespace App\GraphQL\Type\Profile;

use App\GraphQL\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class ProfileEdgeType extends ObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
    ) {
        parent::__construct([
            'name' => 'ProfileEdge',
            'fields' => [
                'node' => Type::nonNull($typeRegistry->profile()),
                'cursor' => Type::nonNull(Type::string()),
            ],
        ]);
    }
}
