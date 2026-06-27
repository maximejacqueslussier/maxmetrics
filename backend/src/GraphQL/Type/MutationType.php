<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use App\GraphQL\Authorization\GraphQLAuthorizationGuard;
use App\GraphQL\TypeRegistry;
use App\GraphQL\Resolver\Authentication\AuthenticationMutationResolver;
use App\GraphQL\Resolver\User\UserMutationResolver;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class MutationType extends ObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
        UserMutationResolver $userResolver,
        AuthenticationMutationResolver $authenticationResolver,
        GraphQLAuthorizationGuard $graphQLAuthorizationGuard,
    ) {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'createUser' => [
                    'type' => $typeRegistry->createUserPayload(),
                    'args' => [
                        'input' => Type::nonNull($typeRegistry->createUserInput()),
                    ],
                    'resolve' => function (
                        mixed $root,
                        array $args,
                    ) use (
                        $userResolver,
                        $graphQLAuthorizationGuard,
                    ): array {
                        $graphQLAuthorizationGuard->requireAdmin();

                        return $userResolver->createUser($root, $args);
                    },
                ],
                'updateUser' => [
                    'type' => $typeRegistry->updateUserPayload(),
                    'args' => [
                        'id' => Type::nonNull(Type::id()),
                        'input' => Type::nonNull($typeRegistry->updateUserInput()),
                    ],
                    'resolve' => function (
                        mixed $root,
                        array $args,
                    ) use (
                        $userResolver,
                        $graphQLAuthorizationGuard,
                    ): array {
                        $graphQLAuthorizationGuard->requireAdmin();

                        return $userResolver->updateUser($root, $args);
                    },
                ],
                'deleteUser' => [
                    'type' => $typeRegistry->deleteUserPayload(),
                    'args' => [
                        'id' => Type::nonNull(Type::id()),
                    ],
                    'resolve' => function (
                        mixed $root,
                        array $args,
                    ) use (
                        $userResolver,
                        $graphQLAuthorizationGuard,
                    ): array {
                        $graphQLAuthorizationGuard->requireAdmin();

                        return $userResolver->deleteUser($root, $args);
                    },
                ],
                'login' => [
                    'type' => $typeRegistry->loginPayload(),
                    'args' => [
                        'input' => Type::nonNull($typeRegistry->loginInput())
                    ],
                    'resolve' => [$authenticationResolver, 'login'],
                ],
            ],
        ]);
    }
}
