<?php

declare(strict_types=1);

namespace App\GraphQL\Input\Profile;

use App\GraphQL\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

final class ProfileOrderByInputType extends InputObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
    ) {
        parent::__construct([
            'name' => 'ProfileOrderByInput',
            'fields' => [
                'field' => [
                    'type' => Type::nonNull($typeRegistry->profileOrderByField()),
                ],
                'direction' => [
                    'type' => $typeRegistry->orderByDirection(),
                    'defaultValue' => 'ASC',
                ],
            ],
        ]);
    }
}
