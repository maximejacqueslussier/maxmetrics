<?php

declare(strict_types=1);

namespace App\GraphQL\Input\Account;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

final class UpdateEmailInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'UpdateEmailInput',
            'fields' => [
                'email' => [
                    'type' => Type::nonNull(Type::string()),
                ],
            ],
        ]);
    }
}
