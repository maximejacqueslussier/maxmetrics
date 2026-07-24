<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use App\Domain\User\User;
use App\GraphQL\Authorization\AuthorizationGuard;
use App\GraphQL\TypeRegistry;
use App\GraphQL\Resolver\Account\AccountQueryResolver;
use App\GraphQL\Resolver\User\UserQueryResolver;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class QueryType extends ObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
        UserQueryResolver $userResolver,
        AccountQueryResolver $accountResolver,
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
                        $userResolver,
                    ): iterable {
                        $authorizationGuard->requireAdmin();

                        return $userResolver->listUsers($root, $args);
                    },
                ],
                'me' => [
                    'type' => Type::nonNull($typeRegistry->user()),
                    'resolve' => function () use (
                        $authorizationGuard,
                        $accountResolver,
                    ): User {
                        $authorizationGuard->requireUser();

                        return $accountResolver->me();
                    },
                ],
            ],
        ]);
    }
}
