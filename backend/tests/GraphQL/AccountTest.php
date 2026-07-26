<?php

declare(strict_types=1);

namespace App\Tests\GraphQL;

use App\Tests\Helper\AuthenticationTrait;
use App\Tests\Helper\DatabaseResetTrait;
use App\Tests\Helper\UserSeederTrait;

final class AccountTest extends GraphQLTestCase
{
    use AuthenticationTrait;
    use DatabaseResetTrait;
    use UserSeederTrait;

    private string $accessToken;

    public function testMe(): void
    {
        $query = <<<'GRAPHQL'
            query Me {
                me {
                    id
                    username
                    salutation
                    pronouns
                    genderIdentity
                    firstName
                    middleName
                    lastName
                    email
                    phoneNumber
                    dateOfBirth
                    createdAt
                    updatedAt
                }
            }
        GRAPHQL;

        $responseBody = $this->graphql($query, [], null, $this->accessToken);

        $this->assertResponseIsSuccessful();
        $this->assertArrayNotHasKey('errors', $responseBody);
        $this->assertArrayHasKey('id', $responseBody['data']['me']);
        $this->assertArrayHasKey('username', $responseBody['data']['me']);
        $this->assertArrayHasKey('salutation', $responseBody['data']['me']);
        $this->assertArrayHasKey('pronouns', $responseBody['data']['me']);
        $this->assertArrayHasKey('genderIdentity', $responseBody['data']['me']);
        $this->assertArrayHasKey('firstName', $responseBody['data']['me']);
        $this->assertArrayHasKey('middleName', $responseBody['data']['me']);
        $this->assertArrayHasKey('lastName', $responseBody['data']['me']);
        $this->assertArrayHasKey('email', $responseBody['data']['me']);
        $this->assertArrayHasKey('phoneNumber', $responseBody['data']['me']);
        $this->assertArrayHasKey('dateOfBirth', $responseBody['data']['me']);
        $this->assertArrayHasKey('createdAt', $responseBody['data']['me']);
        $this->assertArrayHasKey('updatedAt', $responseBody['data']['me']);
    }

    public function testUpdateProfile(): void
    {
        $query = <<<'GRAPHQL'
            mutation UpdateProfile($input: UpdateProfileInput!) {
                updateProfile(input: $input) {
                    user {
                        id
                        username
                        salutation
                        pronouns
                        genderIdentity
                        firstName
                        middleName
                        lastName
                        email
                        phoneNumber
                        dateOfBirth
                        createdAt
                        updatedAt
                    }
                    changedFields
                }
            }
        GRAPHQL;

        $responseBody = $this->graphql($query, [
            'input' => [
                'salutation' => 'M.',
                'pronouns' => 'He/Him',
                'genderIdentity' => 'Male',
                'phoneNumber' => '(555) 555-5555',
                'dateOfBirth' => '2000/01/01',
            ],
        ], null, $this->accessToken);

        $this->assertResponseIsSuccessful();
        $this->assertArrayNotHasKey('errors', $responseBody);
        $this->assertArrayHasKey('user', $responseBody['data']['updateProfile']);
        $this->assertArrayHasKey('id', $responseBody['data']['updateProfile']['user']);
        $this->assertArrayHasKey('changedFields', $responseBody['data']['updateProfile']);
        $this->assertSame([
            'salutation',
            'pronouns',
            'genderIdentity',
            'phoneNumber',
            'dateOfBirth',
        ], $responseBody['data']['updateProfile']['changedFields']);
    }

    public function testUpdateEmail(): void
    {
        $query = <<<'GRAPHQL'
            mutation UpdateEmail($input: UpdateEmailInput!) {
                updateEmail(input: $input) {
                    user {
                        email
                    }
                }
            }
        GRAPHQL;

        $responseBody = $this->graphql($query, [
            'input' => [
                'email' => 'user@example.com',
            ],
        ], null, $this->accessToken);

        $this->assertResponseIsSuccessful();
        $this->assertArrayNotHasKey('errors', $responseBody);
        $this->assertArrayHasKey('user', $responseBody['data']['updateEmail']);
        $this->assertArrayNotHasKey('id', $responseBody['data']['updateEmail']['user']);
        $this->assertArrayHasKey('email', $responseBody['data']['updateEmail']['user']);
    }

    public function testUpdateUsername(): void
    {
        $query = <<<'GRAPHQL'
            mutation UpdateUsername($input: UpdateUsernameInput!) {
                updateUsername(input: $input) {
                    user {
                        username
                    }
                }
            }
        GRAPHQL;

        $responseBody = $this->graphql($query, [
            'input' => [
                'username' => 'user',
            ],
        ], null, $this->accessToken);

        $this->assertResponseIsSuccessful();
        $this->assertArrayNotHasKey('errors', $responseBody);
        $this->assertArrayHasKey('user', $responseBody['data']['updateUsername']);
        $this->assertArrayNotHasKey('id', $responseBody['data']['updateUsername']['user']);
        $this->assertArrayHasKey('username', $responseBody['data']['updateUsername']['user']);
    }

    public function testUpdatePassword(): void
    {
        $query = <<<'GRAPHQL'
            mutation UpdatePassword($input: UpdatePasswordInput!) {
                updatePassword(input: $input) {
                    success
                }
            }
        GRAPHQL;

        $responseBody = $this->graphql($query, [
            'input' => [
                'password' => 'password',
            ],
        ], null, $this->accessToken);

        $this->assertResponseIsSuccessful();
        $this->assertArrayNotHasKey('errors', $responseBody);
        $this->assertArrayHasKey('success', $responseBody['data']['updatePassword']);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->resetDatabase();
        $this->seedUser();
        $this->accessToken = $this->login();
    }
}
