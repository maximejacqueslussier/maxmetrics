<?php

declare(strict_types=1);

namespace App\Tests\GraphQL;

use App\Tests\Helper\AuthenticationTrait;
use App\Tests\Helper\DatabaseResetTrait;
use App\Tests\Helper\UserSeederTrait;

final class UserTest extends GraphQLTestCase
{
    use AuthenticationTrait;
    use DatabaseResetTrait;
    use UserSeederTrait;

    private string $accessToken;

    public function testGetUser(): void
    {
        $query = <<<'GRAPHQL'
            query GetUser($id: ID!) {
                users(
                    first: 1
                    filter: { ids: [$id] }
                ) {
                    edges {
                        node {
                            id
                            username
                            role
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
                }
            }
        GRAPHQL;

        $responseBody = $this->graphql($query, [
            'id' => 1,
        ], null, $this->accessToken);

        $this->assertResponseIsSuccessful();
        $this->assertArrayNotHasKey('errors', $responseBody);
        $this->assertArrayHasKey('edges', $responseBody['data']['users']);
        $this->assertArrayHasKey('node', $responseBody['data']['users']['edges'][0]);
        $this->assertArrayHasKey('id', $responseBody['data']['users']['edges'][0]['node']);
        $this->assertArrayHasKey('username', $responseBody['data']['users']['edges'][0]['node']);
        $this->assertArrayHasKey('role', $responseBody['data']['users']['edges'][0]['node']);
        $this->assertArrayHasKey('salutation', $responseBody['data']['users']['edges'][0]['node']);
        $this->assertArrayHasKey('pronouns', $responseBody['data']['users']['edges'][0]['node']);
        $this->assertArrayHasKey('genderIdentity', $responseBody['data']['users']['edges'][0]['node']);
        $this->assertArrayHasKey('firstName', $responseBody['data']['users']['edges'][0]['node']);
        $this->assertArrayHasKey('middleName', $responseBody['data']['users']['edges'][0]['node']);
        $this->assertArrayHasKey('lastName', $responseBody['data']['users']['edges'][0]['node']);
        $this->assertArrayHasKey('email', $responseBody['data']['users']['edges'][0]['node']);
        $this->assertArrayHasKey('phoneNumber', $responseBody['data']['users']['edges'][0]['node']);
        $this->assertArrayHasKey('dateOfBirth', $responseBody['data']['users']['edges'][0]['node']);
    }

    public function testListUsers(): void
    {
        $query = <<<'GRAPHQL'
            query ListUsers(
                $first: Int
                $after: String
                $orderBy: [UserOrderByInput!]
                $filter: UserFilterInput
            ) {
                users(
                    first: $first
                    after: $after
                    orderBy: $orderBy
                    filter: $filter
                ) {
                    edges {
                        node {
                            id
                            username
                            role
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
                    pageInfo {
                        hasPreviousPage
                        hasNextPage
                        startCursor
                        endCursor
                    }
                }
            }
        GRAPHQL;

        $responseBody = $this->graphql($query, [], null, $this->accessToken);

        $this->assertResponseIsSuccessful();
        $this->assertArrayNotHasKey('errors', $responseBody);
        $this->assertArrayHasKey('edges', $responseBody['data']['users']);
        $this->assertArrayHasKey('node', $responseBody['data']['users']['edges'][0]);
        $this->assertArrayHasKey('node', $responseBody['data']['users']['edges'][1]);
        $this->assertArrayHasKey('pageInfo', $responseBody['data']['users']);
        $this->assertArrayHasKey('hasPreviousPage', $responseBody['data']['users']['pageInfo']);
        $this->assertArrayHasKey('hasNextPage', $responseBody['data']['users']['pageInfo']);
        $this->assertArrayHasKey('startCursor', $responseBody['data']['users']['pageInfo']);
        $this->assertArrayHasKey('endCursor', $responseBody['data']['users']['pageInfo']);
    }

    public function testCreateUser(): void
    {
        $query = <<<'GRAPHQL'
            mutation CreateUser($input: CreateUserInput!) {
                createUser(input: $input) {
                    user {
                        id
                    }
                }
            }
        GRAPHQL;

        $responseBody = $this->graphql($query, [
            'input' => [
                'username' => 'user2',
                'password' => 'password',
                'role' => 'ROLE_USER',
                'firstName' => 'Test',
                'lastName' => 'User',
                'email' => 'user2@example.com',
            ],
        ], null, $this->accessToken);

        $this->assertResponseIsSuccessful();
        $this->assertArrayNotHasKey('errors', $responseBody);
        $this->assertArrayHasKey('user', $responseBody['data']['createUser']);
        $this->assertArrayHasKey('id', $responseBody['data']['createUser']['user']);
    }

    public function testUpdateUser(): void
    {
        $query = <<<'GRAPHQL'
            mutation UpdateUser($id: ID!, $input: UpdateUserInput!) {
                updateUser(id: $id, input: $input) {
                    user {
                        id
                        role
                    }
                    changedFields
                }
            }
        GRAPHQL;

        $responseBody = $this->graphql($query, [
            'id' => 1,
            'input' => [
                'role' => 'ROLE_ADMIN',
            ],
        ], null, $this->accessToken);

        $this->assertResponseIsSuccessful();
        $this->assertArrayNotHasKey('errors', $responseBody);
        $this->assertArrayHasKey('user', $responseBody['data']['updateUser']);
        $this->assertArrayHasKey('id', $responseBody['data']['updateUser']['user']);
        $this->assertArrayHasKey('role', $responseBody['data']['updateUser']['user']);
        $this->assertArrayHasKey('changedFields', $responseBody['data']['updateUser']);
        $this->assertSame(['role'], $responseBody['data']['updateUser']['changedFields']);
    }

    public function testDeleteUser(): void
    {
        $query = <<<'GRAPHQL'
            mutation DeleteUser($id: ID!) {
                deleteUser(id: $id) {
                    deletedUserId
                }
            }
        GRAPHQL;

        $responseBody = $this->graphql($query, [
            'id' => 1,
        ], null, $this->accessToken);

        $this->assertResponseIsSuccessful();
        $this->assertArrayNotHasKey('errors', $responseBody);
        $this->assertArrayHasKey('deletedUserId', $responseBody['data']['deleteUser']);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->resetDatabase();
        $this->seedUser();
        $this->seedAdmin();
        $this->accessToken = $this->login('admin');
    }
}
