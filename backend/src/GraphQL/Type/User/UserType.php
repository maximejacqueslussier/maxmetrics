<?php

declare(strict_types=1);

namespace App\GraphQL\Type\User;

use App\GraphQL\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class UserType extends ObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
    ) {
        parent::__construct([
            'name' => 'User',
            'fields' => [
                'id' => [
                    'type' => Type::nonNull(Type::id()),
                    'resolve' => static fn (object $user) => $user->getId(),
                ],
                'accountId' => [
                    'type' => Type::id(),
                    'resolve' => static fn (object $user) => $user->getAccount()?->getId(),
                ],
                'username' => [
                    'type' => Type::string(),
                    'resolve' => static fn (object $user) => $user->getAccount()?->getUsername(),
                ],
                'salutation' => [
                    'type' => Type::string(),
                    'resolve' => static fn (object $user) => $user->getSalutation(),
                ],
                'pronouns' => [
                    'type' => Type::string(),
                    'resolve' => static fn (object $user) => $user->getPronouns(),
                ],
                'genderIdentity' => [
                    'type' => Type::string(),
                    'resolve' => static fn (object $user) => $user->getGenderIdentity(),
                ],
                'firstName' => [
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => static fn (object $user) => $user->getFirstName(),
                ],
                'middleName' => [
                    'type' => Type::string(),
                    'resolve' => static fn (object $user) => $user->getMiddleName(),
                ],
                'lastName' => [
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => static fn (object $user) => $user->getLastName(),
                ],
                'email' => [
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => static fn (object $user) => $user->getEmail(),
                ],
                'phoneNumber' => [
                    'type' => Type::string(),
                    'resolve' => static fn (object $user) => $user->getPhoneNumber(),
                ],
                'createdAt' => [
                    'type' => Type::nonNull($typeRegistry->dateTime()),
                    'resolve' => static fn (object $user) => $user->getCreatedAt(),
                ],
                'updatedAt' => [
                    'type' => Type::nonNull($typeRegistry->dateTime()),
                    'resolve' => static fn (object $user) => $user->getUpdatedAt(),
                ],
            ],
        ]);
    }
}
