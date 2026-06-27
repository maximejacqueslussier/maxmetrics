<?php

declare(strict_types=1);

namespace App\GraphQL\Type\Authentication;

use App\GraphQL\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class LoginPayloadType extends ObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
    ) {
        parent::__construct([
            'name' => 'LoginPayload',
            'fields' => [
                'user' => [
                    'type' => Type::nonNull($typeRegistry->user()),
                ],
                'accessToken' => [
                    'type' => Type::nonNull(Type::string()),
                ],
                'expiresAt' => [
                    'type' => Type::nonNull($typeRegistry->dateTime()),
                ],
            ]
        ]);
    }
}
