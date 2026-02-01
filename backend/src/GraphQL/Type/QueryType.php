<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use App\GraphQL\TypeRegistry;
use App\GraphQL\Resolver\User\UserQueryResolver;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class QueryType extends ObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
        UserQueryResolver $userQueryResolver,
    ) {
        parent::__construct([
            'name' => 'Query',
            'fields' => [
                'users' => [
                    'type' => Type::nonNull($typeRegistry->userConnection()),
                    'args' => [
                        'first' => [
                            'type' => Type::int(),
                        ],
                        'after' => [
                            'type' => Type::string(),
                        ],
                        'filter' => [
                            'type' => $typeRegistry->userFilterInput(),
                        ],
                        'orderBy' => [
                            'type' => Type::listOf(
                                Type::nonNull($typeRegistry->userOrderByInput()),
                            ),
                        ]
                    ],
                    'resolve' => [$userQueryResolver, 'listUsers'],
                ],
            ],
        ]);
    }
}
