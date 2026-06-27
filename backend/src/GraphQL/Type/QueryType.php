<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use App\GraphQL\Authorization\GraphQLAuthorizationGuard;
use App\GraphQL\TypeRegistry;
use App\GraphQL\Resolver\User\UserQueryResolver;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class QueryType extends ObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
        UserQueryResolver $userQueryResolver,
        GraphQLAuthorizationGuard $graphQLAuthorizationGuard,
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
                        ],
                    ],
                    'resolve' => function (
                        mixed $root,
                        array $args,
                    ) use (
                        $graphQLAuthorizationGuard,
                        $userQueryResolver,
                    ): iterable {
                        $graphQLAuthorizationGuard->requireAdmin();

                        return $userQueryResolver->listUsers($root, $args);
                    },
                ],
            ],
        ]);
    }
}
