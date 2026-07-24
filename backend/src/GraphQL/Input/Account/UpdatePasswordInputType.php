<?php

declare(strict_types=1);

namespace App\GraphQL\Input\Account;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

final class UpdatePasswordInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'UpdatePasswordInput',
            'fields' => [
                'password' => [
                    'type' => Type::nonNull(Type::string()),
                ],
            ],
        ]);
    }
}
