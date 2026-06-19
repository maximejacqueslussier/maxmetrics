<?php

declare(strict_types=1);

namespace App\GraphQL\Type\Profile;

use App\Domain\Profile\Profile;
use App\GraphQL\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class ProfileType extends ObjectType
{
    public function __construct(
        TypeRegistry $typeRegistry,
    ) {
        parent::__construct([
            'name' => 'Profile',
            'fields' => [
                'id' => [
                    'type' => Type::nonNull(Type::id()),
                    'resolve' => static fn (Profile $profile) => $profile->getId(),
                ],
                'salutation' => [
                    'type' => Type::string(),
                    'resolve' => static fn (Profile $profile) => $profile->getSalutation(),
                ],
                'pronouns' => [
                    'type' => Type::string(),
                    'resolve' => static fn (Profile $profile) => $profile->getPronouns(),
                ],
                'genderIdentity' => [
                    'type' => Type::string(),
                    'resolve' => static fn (Profile $profile) => $profile->getGenderIdentity(),
                ],
                'firstName' => [
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => static fn (Profile $profile) => $profile->getFirstName(),
                ],
                'middleName' => [
                    'type' => Type::string(),
                    'resolve' => static fn (Profile $profile) => $profile->getMiddleName(),
                ],
                'lastName' => [
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => static fn (Profile $profile) => $profile->getLastName(),
                ],
                'email' => [
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => static fn (Profile $profile) => $profile->getEmail(),
                ],
                'phoneNumber' => [
                    'type' => Type::string(),
                    'resolve' => static fn (Profile $profile) => $profile->getPhoneNumber(),
                ],
                'createdAt' => [
                    'type' => Type::nonNull($typeRegistry->dateTime()),
                    'resolve' => static fn (Profile $profile) => $profile->getCreatedAt(),
                ],
                'updatedAt' => [
                    'type' => Type::nonNull($typeRegistry->dateTime()),
                    'resolve' => static fn (Profile $profile) => $profile->getUpdatedAt(),
                ],
            ],
        ]);
    }
}
