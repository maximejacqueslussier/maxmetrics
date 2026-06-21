<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use App\GraphQL\TypeRegistry;
use App\GraphQL\Resolver\User\UserMutationResolver;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class MutationType extends ObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
        UserMutationResolver $userResolver,
    ) {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'createUser' => [
                    'type' => $typeRegistry->createUserPayload(),
                    'args' => [
                        'input' => Type::nonNull($typeRegistry->createUserInput()),
                    ],
                    'resolve' => [$userResolver, 'createUser'],
                ],
                'updateUser' => [
                    'type' => $typeRegistry->updateUserPayload(),
                    'args' => [
                        'id' => Type::nonNull(Type::id()),
                        'input' => Type::nonNull($typeRegistry->updateUserInput()),
                    ],
                    'resolve' => [$userResolver, 'updateUser'],
                ],
                'deleteUser' => [
                    'type' => $typeRegistry->deleteUserPayload(),
                    'args' => [
                        'id' => Type::nonNull(Type::id()),
                    ],
                    'resolve' => [$userResolver, 'deleteUser'],
                ],
            ],
        ]);
    }
}
