<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Input\CreateUserInputType;
use App\GraphQL\Input\UpdateUserInputType;
use App\GraphQL\Resolver\UserMutationResolver;

/**
 * Represents the root GraphQL mutation.
 */
final class MutationType extends ObjectType
{
    public function __construct(
        CreateUserPayloadType $createUserPayload,
        CreateUserInputType $createUserInput,
        UpdateUserPayloadType $updateUserPayload,
        UpdateUserInputType $updateUserInput,
        DeleteUserPayloadType $deleteUserPayload,
        UserMutationResolver $resolver,
    ) {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'createUser' => [
                    'type' => $createUserPayload,
                    'args' => [
                        'input' => Type::nonNull($createUserInput),
                    ],
                    'resolve' => [$resolver, 'createUser'],
                ],
                'updateUser' => [
                    'type' => $updateUserPayload,
                    'args' => [
                        'id' => Type::nonNull(Type::id()),
                        'input' => Type::nonNull($updateUserInput),
                    ],
                    'resolve' => [$resolver, 'updateUser'],
                ],
                'deleteUser' => [
                    'type' => $deleteUserPayload,
                    'args' => [
                        'id' => Type::nonNull(Type::id()),
                    ],
                    'resolve' => [$resolver, 'deleteUser'],
                ],
            ],
        ]);
    }
}
