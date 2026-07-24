<?php

declare(strict_types=1);

namespace App\GraphQL\Input\Account;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

final class UpdateUsernameInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'UpdateUsernameInput',
            'fields' => [
                'username' => [
                    'type' => Type::nonNull(Type::string()),
                ],
            ],
        ]);
    }
}
