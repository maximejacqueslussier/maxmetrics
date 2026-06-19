<?php

declare(strict_types=1);

namespace App\GraphQL\Type\Profile;

use GraphQL\Type\Definition\EnumType;
use GraphQL\Type\Definition\Type;

final class ProfileOrderByFieldType extends EnumType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'ProfileOrderByField',
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
