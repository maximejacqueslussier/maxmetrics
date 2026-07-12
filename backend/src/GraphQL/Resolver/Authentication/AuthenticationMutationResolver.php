<?php

declare(strict_types=1);

namespace App\GraphQL\Resolver\Authentication;

use App\Application\Authentication\Login;
use App\Application\Authentication\RotateRefreshToken;
use App\GraphQL\HttpContext;
use App\Infrastructure\Http\RefreshTokenCookieManager;

final readonly class AuthenticationMutationResolver
{
    public function __construct(
        private Login $login,
        private RotateRefreshToken $rotateRefreshToken,
        private RefreshTokenCookieManager $refreshTokenCookieManager,
    ) {
    }

    public function login(mixed $root, array $args, HttpContext $context): array
    {
        $input = $args['input'];

        $result = $this->login->execute(
            $input['username'],
            $input['password'],
        );

        $context->getResponse()->headers->setCookie(
            $this->refreshTokenCookieManager->create(
                $result->getRawRefreshToken(),
                $result->getRefreshTokenExpiresAt(),
            ),
        );

        return [
            'user' => $result->getUser(),
            'accessToken' => $result->getAccessToken(),
            'expiresAt' => $result->getAccessTokenExpiresAt(),
        ];
    }

    public function refreshToken(mixed $root, array $args, HttpContext $context): array
    {
        $rawToken = $context->getRequest()->cookies->get(RefreshTokenCookieManager::COOKIE_NAME);
        $result = $this->rotateRefreshToken->execute($rawToken);

        $context->getResponse()->headers->setCookie(
            $this->refreshTokenCookieManager->create(
                $result->getRawRefreshToken(),
                $result->getRefreshTokenExpiresAt(),
            ),
        );

        return [
            'accessToken' => $result->getAccessToken(),
            'expiresAt' => $result->getAccessTokenExpiresAt(),
        ];
    }
}
