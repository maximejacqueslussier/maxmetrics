<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use App\GraphQL\Authorization\AuthorizationGuard;
use App\GraphQL\TypeRegistry;
use App\GraphQL\Resolver\Account\AccountMutationResolver;
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
        AccountMutationResolver $accountResolver,
        AuthorizationGuard $authorizationGuard,
    ) {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'createUser' => [
                    'type' => $typeRegistry->createUserPayload(),
                    'args' => [
                        'input' => [
                            'type' => Type::nonNull($typeRegistry->createUserInput()),
                        ],
                    ],
                    'resolve' => function (
                        mixed $root,
                        array $args,
                    ) use (
                        $userResolver,
                        $authorizationGuard,
                    ): array {
                        $authorizationGuard->requireAdmin();

                        return $userResolver->createUser($root, $args);
                    },
                ],
                'updateUser' => [
                    'type' => $typeRegistry->updateUserPayload(),
                    'args' => [
                        'id' => [
                            'type' => Type::nonNull(Type::id()),
                        ],
                        'input' => [
                            'type' => Type::nonNull($typeRegistry->updateUserInput()),
                        ],
                    ],
                    'resolve' => function (
                        mixed $root,
                        array $args,
                    ) use (
                        $userResolver,
                        $authorizationGuard,
                    ): array {
                        $authorizationGuard->requireAdmin();

                        return $userResolver->updateUser($root, $args);
                    },
                ],
                'deleteUser' => [
                    'type' => $typeRegistry->deleteUserPayload(),
                    'args' => [
                        'id' => [
                            'type' => Type::nonNull(Type::id()),
                        ],
                    ],
                    'resolve' => function (
                        mixed $root,
                        array $args,
                    ) use (
                        $userResolver,
                        $authorizationGuard,
                    ): array {
                        $authorizationGuard->requireAdmin();

                        return $userResolver->deleteUser($root, $args);
                    },
                ],
                'login' => [
                    'type' => $typeRegistry->loginPayload(),
                    'args' => [
                        'input' => [
                            'type' => Type::nonNull($typeRegistry->loginInput()),
                        ],
                    ],
                    'resolve' => [$authenticationResolver, 'login'],
                ],
                'refreshToken' => [
                    'type' => $typeRegistry->refreshTokenPayload(),
                    'resolve' => [$authenticationResolver, 'refreshToken'],
                ],
                'logout' => [
                    'type' => $typeRegistry->logoutPayload(),
                    'resolve' => [$authenticationResolver, 'logout'],
                ],
                'updateUsername' => [
                    'type' => $typeRegistry->updateUsernamePayload(),
                    'args' => [
                        'input' => [
                            'type' => Type::nonNull($typeRegistry->updateUsernameInput()),
                        ],
                    ],
                    'resolve' => function (
                        mixed $root,
                        array $args,
                    ) use (
                        $accountResolver,
                        $authorizationGuard,
                    ): array {
                        $authorizationGuard->requireUser();

                        return $accountResolver->updateUsername($root, $args);
                    }
                ],
                'updateEmail' => [
                    'type' => $typeRegistry->updateEmailPayload(),
                    'args' => [
                        'input' => [
                            'type' => Type::nonNull($typeRegistry->updateEmailInput()),
                        ],
                    ],
                    'resolve' => function (
                        mixed $root,
                        array $args,
                    ) use (
                        $accountResolver,
                        $authorizationGuard,
                    ): array {
                        $authorizationGuard->requireUser();

                        return $accountResolver->updateEmail($root, $args);
                    }
                ],
                'updatePassword' => [
                    'type' => $typeRegistry->updatePasswordPayload(),
                    'args' => [
                        'input' => [
                            'type' => Type::nonNull($typeRegistry->updatePasswordInput()),
                        ],
                    ],
                    'resolve' => function (
                        mixed $root,
                        array $args,
                    ) use (
                        $accountResolver,
                        $authorizationGuard,
                    ): array {
                        $authorizationGuard->requireUser();

                        return $accountResolver->updatePassword($root, $args);
                    }
                ],
                'updateProfile' => [
                    'type' => $typeRegistry->updateProfilePayload(),
                    'args' => [
                        'input' => [
                            'type' => $typeRegistry->updateProfileInput(),
                        ],
                    ],
                    'resolve' => function (
                        mixed $root,
                        array $args,
                    ) use (
                        $accountResolver,
                        $authorizationGuard,
                    ): array {
                        $authorizationGuard->requireUser();

                        return $accountResolver->updateProfile($root, $args);
                    }
                ],
            ],
        ]);
    }
}
