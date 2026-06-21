<?php

declare(strict_types=1);

namespace App\GraphQL\Type\User;

use GraphQL\Type\Definition\EnumType;

final class UserOrderByFieldType extends EnumType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'UserOrderByField',
            'values' => [
                'ID' => [
                    'value' => 'id',
                ],
                'CREATED_AT' => [
                    'value' => 'createdAt',
                ],
                'UPDATED_AT' => [
                    'value' => 'updatedAt',
                ],
            ],
        ]);
    }
}
