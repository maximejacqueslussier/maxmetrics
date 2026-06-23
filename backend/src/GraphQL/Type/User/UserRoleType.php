<?php

declare(strict_types=1);

namespace App\GraphQL\Type\User;

use GraphQL\Type\Definition\EnumType;

final class UserRoleType extends EnumType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'UserRole',
            'values' => [
                'ROLE_USER',
                'ROLE_ADMIN',
            ],
        ]);
    }
}
