<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use App\GraphQL\TypeRegistry;
use App\GraphQL\Resolver\Profile\ProfileMutationResolver;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class MutationType extends ObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
        ProfileMutationResolver $resolver,
    ) {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'createProfile' => [
                    'type' => $typeRegistry->createProfilePayload(),
                    'args' => [
                        'input' => Type::nonNull($typeRegistry->createProfileInput()),
                    ],
                    'resolve' => [$resolver, 'createProfile'],
                ],
                'updateProfile' => [
                    'type' => $typeRegistry->updateProfilePayload(),
                    'args' => [
                        'id' => Type::nonNull(Type::id()),
                        'input' => Type::nonNull($typeRegistry->updateProfileInput()),
                    ],
                    'resolve' => [$resolver, 'updateProfile'],
                ],
                'deleteProfile' => [
                    'type' => $typeRegistry->deleteProfilePayload(),
                    'args' => [
                        'id' => Type::nonNull(Type::id()),
                    ],
                    'resolve' => [$resolver, 'deleteProfile'],
                ],
            ],
        ]);
    }
}
