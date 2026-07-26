<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use App\Application\User\CreateUser;
use App\Domain\User\User;
use DateTime;

trait UserSeederTrait
{
    protected function seedAdmin(
        string $username = 'admin',
        string $password = 'password',
        string $role = 'ROLE_ADMIN',
        ?string $salutation = null,
        ?string $pronouns = null,
        ?string $genderIdentity = null,
        string $firstName = 'Test',
        ?string $middleName = null,
        string $lastName = 'Admin',
        string $email = 'admin@example.com',
        ?string $phoneNumber = null,
        ?DateTime $dateOfBirth = null,
    ): User {
        return $this->seedUser(
            $username,
            $password,
            $role,
            $salutation,
            $pronouns,
            $genderIdentity,
            $firstName,
            $middleName,
            $lastName,
            $email,
            $phoneNumber,
            $dateOfBirth,
        );
    }

    protected function seedUser(
        string $username = 'user',
        string $password = 'password',
        string $role = 'ROLE_USER',
        ?string $salutation = null,
        ?string $pronouns = null,
        ?string $genderIdentity = null,
        string $firstName = 'Test',
        ?string $middleName = null,
        string $lastName = 'User',
        string $email = 'user@example.com',
        ?string $phoneNumber = null,
        ?DateTime $dateOfBirth = null,
    ): User {
        return static::getContainer()->get(CreateUser::class)->execute(
            $username,
            $password,
            $role,
            $salutation,
            $pronouns,
            $genderIdentity,
            $firstName,
            $middleName,
            $lastName,
            $email,
            $phoneNumber,
            $dateOfBirth,
        );
    }
}
