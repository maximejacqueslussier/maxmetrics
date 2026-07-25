<?php

declare(strict_types=1);

namespace App\GraphQL\Input\Account;

use App\GraphQL\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

final class UpdateProfileInputType extends InputObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
    )
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
                'phoneNumber' => [
                    'type' => Type::string(),
                ],
                'dateOfBirth' => [
                    'type' => $typeRegistry->dateTime(),
                ]
            ],
        ]);
    }
}
