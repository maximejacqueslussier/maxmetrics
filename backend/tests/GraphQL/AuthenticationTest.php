<?php

declare(strict_types=1);

namespace App\Tests\GraphQL;

use App\Tests\Helper\AuthenticationTrait;
use App\Tests\Helper\DatabaseResetTrait;
use App\Tests\Helper\UserSeederTrait;

final class AuthenticationTest extends GraphQLTestCase
{
    use AuthenticationTrait;
    use DatabaseResetTrait;
    use UserSeederTrait;

    public function testLogin(): void
    {
        $query = <<<'GRAPHQL'
            mutation Login($input: LoginInput!) {
                login(input: $input) {
                    accessToken
                    expiresAt
                }
            }
        GRAPHQL;

        $responseBody = $this->graphql($query, [
            'input' => [
                'username' => 'user',
                'password' => 'password',
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertArrayNotHasKey('errors', $responseBody);
        $this->assertArrayHasKey('accessToken', $responseBody['data']['login']);
        $this->assertArrayHasKey('expiresAt', $responseBody['data']['login']);
    }

    public function testLogout(): void
    {
        $query = <<<'GRAPHQL'
            mutation Logout {
                logout {
                    success
                }
            }
        GRAPHQL;

        $responseBody = $this->graphql($query);

        $this->assertResponseIsSuccessful();
        $this->assertArrayNotHasKey('errors', $responseBody);
        $this->assertArrayHasKey('success', $responseBody['data']['logout']);
    }

    public function testRefreshToken(): void
    {
        $this->login();

        $query = <<<'GRAPHQL'
            mutation RefreshToken {
                refreshToken {
                    accessToken
                    expiresAt
                }
            }
        GRAPHQL;

        $responseBody = $this->graphql($query);

        $this->assertResponseIsSuccessful();
        $this->assertArrayNotHasKey('errors', $responseBody);
        $this->assertArrayHasKey('accessToken', $responseBody['data']['refreshToken']);
        $this->assertArrayHasKey('expiresAt', $responseBody['data']['refreshToken']);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->resetDatabase();
        $this->seedUser();
    }
}
