<?php

declare(strict_types=1);

namespace App\Tests\Helper;

trait AuthenticationTrait
{
    protected function login(
        string $username = 'user',
        string $password = 'password',
    ): string {
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
                'username' => $username,
                'password' => $password,
            ],
        ]);

        return $responseBody['data']['login']['accessToken'] ?? '';
    }
}
