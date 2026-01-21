<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use App\GraphQL\Resolver\UserQueryResolver;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * Represents the root GraphQL query.
 */
final class QueryType extends ObjectType
{
    public function __construct(
        UserType $userType,
        UserQueryResolver $userQueryResolver,
    ) {
        parent::__construct([
            'name' => 'Query',
            'fields' => [
                'users' => [
                    'type' => Type::nonNull(
                        Type::listOf(
                            Type::nonNull($userType)
                        )
                    ),
                    'resolve' => [$userQueryResolver, 'listUsers'],
                ],
            ],
        ]);
    }
}
