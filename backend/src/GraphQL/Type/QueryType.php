<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use App\Domain\User\User;
use App\GraphQL\Authorization\AuthorizationGuard;
use App\GraphQL\TypeRegistry;
use App\GraphQL\Resolver\Authentication\AuthenticationQueryResolver;
use App\GraphQL\Resolver\User\UserQueryResolver;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class QueryType extends ObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
        UserQueryResolver $userQueryResolver,
        AuthenticationQueryResolver $authenticationQueryResolver,
        AuthorizationGuard $authorizationGuard,
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
                        $authorizationGuard,
                        $userQueryResolver,
                    ): iterable {
                        $authorizationGuard->requireAdmin();

                        return $userQueryResolver->listUsers($root, $args);
                    },
                ],
                'me' => [
                    'type' => Type::nonNull($typeRegistry->user()),
                    'resolve' => function () use (
                        $authorizationGuard,
                        $authenticationQueryResolver,
                    ): User {
                        $authorizationGuard->requireUser();

                        return $authenticationQueryResolver->me();
                    },
                ],
            ],
        ]);
    }
}
