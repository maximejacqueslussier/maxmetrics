<?php

declare(strict_types=1);

namespace App\GraphQL\Input;

use App\Entity\User;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

final class UpdateUserInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'UpdateUserInput',
            'fields' => [
                User::SALUTATION => ['type' => Type::string()],
                User::PRONOUNS => ['type' => Type::string()],
                User::GENDER_IDENTITY => ['type' => Type::string()],
                User::FIRST_NAME => ['type' => Type::string()],
                User::MIDDLE_NAME => ['type' => Type::string()],
                User::LAST_NAME => ['type' => Type::string()],
                User::EMAIL => ['type' => Type::string()],
                User::PHONE_NUMBER => ['type' => Type::string()],
            ],
        ]);
    }
}
