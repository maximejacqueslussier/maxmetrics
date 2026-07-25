<?php

declare(strict_types=1);

namespace App\GraphQL\Input\User;

use App\GraphQL\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

final class CreateUserInputType extends InputObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
    ) {
        parent::__construct([
            'name' => 'CreateUserInput',
            'fields' => [
                'username' => [
                    'type' => Type::nonNull(Type::string()),
                ],
                'password' => [
                    'type' => Type::nonNull(Type::string()),
                ],
                'role' => [
                    'type' => Type::nonNull($typeRegistry->userRole()),
                ],
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
                'dateOfBirth' => [
                    'type' => $typeRegistry->dateTime(),
                ],
            ],
        ]);
    }
}
