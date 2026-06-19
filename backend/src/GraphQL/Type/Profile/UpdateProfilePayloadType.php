<?php

declare(strict_types=1);

namespace App\GraphQL\Type\Profile;

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
                'profile' => [
                    'type' => Type::nonNull($typeRegistry->profile()),
                ],
                'changedFields' => [
                    'type' => Type::nonNull(Type::listOf(Type::nonNull(Type::string()))),
                ],
            ],
        ]);
    }
}
