<?php

declare(strict_types=1);

namespace App\GraphQL\Input\User;

use App\Domain\User\User;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

final class CreateUserInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'CreateUserInput',
            'fields' => [
                'salutation' => [
                    'type' => Type::string(),
                ],
                'pronouns' => [
                    'type' => Type::string(),
                ],
                'genderIdentity' => [
                    'type' => Type::string(),
                ],
                'firstName' => [
                    'type' => Type::nonNull(Type::string()),
                ],
                'middleName' => [
                    'type' => Type::string(),
                ],
                'lastName' => [
                    'type' => Type::nonNull(Type::string()),
                ],
                'email' => [
                    'type' => Type::nonNull(Type::string()),
                ],
                'phoneNumber' => [
                    'type' => Type::string(),
                ],
            ],
        ]);
    }
}
