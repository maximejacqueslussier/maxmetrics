<?php

declare(strict_types=1);

namespace App\GraphQL\Type\User;

use App\GraphQL\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class UpdateUserPayloadType extends ObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
    ) {
        parent::__construct([
            'name' => 'UpdateUserPayload',
            'fields' => [
                'user' => [
                    'type' => Type::nonNull($typeRegistry->user()),
                ],
                'changedFields' => [
                    'type' => Type::nonNull(Type::listOf(Type::nonNull(Type::string()))),
                ],
            ],
        ]);
    }
}
