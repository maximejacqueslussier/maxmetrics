<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use App\GraphQL\TypeRegistry;
use App\GraphQL\Resolver\Profile\ProfileQueryResolver;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class QueryType extends ObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
        ProfileQueryResolver $profileQueryResolver,
    ) {
        parent::__construct([
            'name' => 'Query',
            'fields' => [
                'profiles' => [
                    'type' => Type::nonNull($typeRegistry->profileConnection()),
                    'args' => [
                        'first' => [
                            'type' => Type::int(),
                        ],
                        'after' => [
                            'type' => Type::string(),
                        ],
                        'filter' => [
                            'type' => $typeRegistry->profileFilterInput(),
                        ],
                        'orderBy' => [
                            'type' => Type::listOf(
                                Type::nonNull($typeRegistry->profileOrderByInput()),
                            ),
                        ]
                    ],
                    'resolve' => [$profileQueryResolver, 'listProfiles'],
                ],
            ],
        ]);
    }
}
