<?php

declare(strict_types=1);

namespace App\GraphQL\Type\Account;

use App\GraphQL\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class UpdateUsernamePayloadType extends ObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
    ) {
        parent::__construct([
            'name' => 'UpdateUsernamePayload',
            'fields' => [
                'user' => [
                    'type' => Type::nonNull($typeRegistry->user()),
                ],
            ],
        ]);
    }
}
