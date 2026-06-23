<?php

declare(strict_types=1);

namespace App\GraphQL\Type\User;

use App\Domain\Profile\Profile;
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
                    'resolve' => static fn (Profile $user) => $user->getId(),
                ],
                'accountId' => [
                    'type' => Type::id(),
                    'resolve' => static fn (Profile $user) => $user->getAccount()?->getId(),
                ],
                'username' => [
                    'type' => Type::string(),
                    'resolve' => static fn (Profile $user) => $user->getAccount()?->getUsername(),
                ],
                'role' => [
                    'type' => $typeRegistry->userRole(),
                    'resolve' => static fn (Profile $user) => $user->getAccount()?->getRole(),
                ],
                'salutation' => [
                    'type' => Type::string(),
                    'resolve' => static fn (Profile $user) => $user->getSalutation(),
                ],
                'pronouns' => [
                    'type' => Type::string(),
                    'resolve' => static fn (Profile $user) => $user->getPronouns(),
                ],
                'genderIdentity' => [
                    'type' => Type::string(),
                    'resolve' => static fn (Profile $user) => $user->getGenderIdentity(),
                ],
                'firstName' => [
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => static fn (Profile $user) => $user->getFirstName(),
                ],
                'middleName' => [
                    'type' => Type::string(),
                    'resolve' => static fn (Profile $user) => $user->getMiddleName(),
                ],
                'lastName' => [
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => static fn (Profile $user) => $user->getLastName(),
                ],
                'email' => [
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => static fn (Profile $user) => $user->getEmail(),
                ],
                'phoneNumber' => [
                    'type' => Type::string(),
                    'resolve' => static fn (Profile $user) => $user->getPhoneNumber(),
                ],
                'createdAt' => [
                    'type' => Type::nonNull($typeRegistry->dateTime()),
                    'resolve' => static fn (Profile $user) => $user->getCreatedAt(),
                ],
                'updatedAt' => [
                    'type' => Type::nonNull($typeRegistry->dateTime()),
                    'resolve' => static fn (Profile $user) => $user->getUpdatedAt(),
                ],
            ],
        ]);
    }
}
