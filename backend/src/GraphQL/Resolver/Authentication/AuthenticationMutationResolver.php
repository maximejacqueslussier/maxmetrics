<?php

declare(strict_types=1);

namespace App\GraphQL\Resolver\Authentication;

use App\Application\Authentication\Login;

final readonly class AuthenticationMutationResolver
{
    public function __construct(
        private Login $login,
    ) {
    }

    public function login(mixed $root, array $args): array
    {
        $input = $args['input'];

        $result = $this->login->execute(
            $input['username'],
            $input['password'],
        );

        return [
            'user' => $result->getUser(),
            'accessToken' => $result->getAccessToken(),
            'expiresAt' => $result->getExpiresAt(),
        ];
    }
}
