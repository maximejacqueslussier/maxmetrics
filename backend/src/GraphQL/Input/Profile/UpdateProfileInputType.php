<?php

declare(strict_types=1);

namespace App\GraphQL\Input\Profile;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

final class UpdateProfileInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'UpdateProfileInput',
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
                    'type' => Type::string(),
                ],
                'middleName' => [
                    'type' => Type::string(),
                ],
                'lastName' => [
                    'type' => Type::string(),
                ],
                'email' => [
                    'type' => Type::string(),
                ],
                'phoneNumber' => [
                    'type' => Type::string(),
                ],
            ],
        ]);
    }
}
