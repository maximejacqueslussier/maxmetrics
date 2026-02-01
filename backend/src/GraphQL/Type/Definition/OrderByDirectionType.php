<?php

declare(strict_types=1);

namespace App\GraphQL\Type\Definition;

use GraphQL\Type\Definition\EnumType;
use GraphQL\Type\Definition\Type;

final class OrderByDirectionType extends EnumType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'OrderByDirection',
            'values' => [
                'ASC',
                'DESC',
            ],
        ]);
    }
}
