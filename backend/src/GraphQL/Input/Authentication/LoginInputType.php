<?php

declare(strict_types=1);

namespace App\GraphQL\Input\Authentication;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

final class LoginInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'LoginInput',
            'fields' => [
                'username' => [
                    'type' => Type::nonNull(Type::string()),
                ],
                'password' => [
                    'type' => Type::nonNull(Type::string()),
                ],
            ],
        ]);
    }
}
