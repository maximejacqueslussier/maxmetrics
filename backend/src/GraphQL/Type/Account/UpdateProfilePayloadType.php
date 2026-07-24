<?php

declare(strict_types=1);

namespace App\GraphQL\Type\Account;

use App\GraphQL\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class UpdateProfilePayloadType extends ObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
    ) {
        parent::__construct([
            'name' => 'UpdateProfilePayload',
            'fields' => [
                'user' => [
                    'type' => Type::nonNull($typeRegistry->user()),
                ],
                'changedFields' => [
                    'type' => Type::nonNull(Type::listOf(Type::nonNull(Type::string()))),
                ]
            ],
        ]);
    }
}
