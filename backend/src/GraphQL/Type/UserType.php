<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use App\Entity\User;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class UserType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'User',
            'fields' => [
                'id' => [
                    'type' => Type::nonNull(Type::id()),
                    'resolve' => static fn (User $user) => $user->getId(),
                ],
                'salutation' => [
                    'type' => Type::string(),
                    'resolve' => static fn (User $user) => $user->getSalutation(),
                ],
                'pronouns' => [
                    'type' => Type::string(),
                    'resolve' => static fn (User $user) => $user->getPronouns(),
                ],
                'genderIdentity' => [
                    'type' => Type::string(),
                    'resolve' => static fn (User $user) => $user->getGenderIdentity(),
                ],
                'firstName' => [
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => static fn (User $user) => $user->getFirstName(),
                ],
                'middleName' => [
                    'type' => Type::string(),
                    'resolve' => static fn (User $user) => $user->getMiddleName(),
                ],
                'lastName' => [
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => static fn (User $user) => $user->getLastName(),
                ],
                'email' => [
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => static fn (User $user) => $user->getEmail(),
                ],
                'phoneNumber' => [
                    'type' => Type::string(),
                    'resolve' => static fn (User $user) => $user->getPhoneNumber(),
                ],
            ],
        ]);
    }
}
