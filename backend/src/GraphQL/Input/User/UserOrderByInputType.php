<?php

declare(strict_types=1);

namespace App\GraphQL\Input\User;

use App\GraphQL\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

final class UserOrderByInputType extends InputObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
    ) {
        parent::__construct([
            'name' => 'UserOrderByInput',
            'fields' => [
                'field' => [
                    'type' => $typeRegistry->userOrderByField(),
                    'defaultValue' => 'id',
                ],
                'direction' => [
                    'type' => $typeRegistry->orderByDirection(),
                    'defaultValue' => 'ASC',
                ],
            ],
        ]);
    }
}
