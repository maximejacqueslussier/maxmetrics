<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use DateTime;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

final readonly class RefreshTokenCookieManager
{
    public const string COOKIE_NAME = 'refresh_token';

    public function __construct(
        private string $path = '/',
        private bool $isSecure = true,
        private bool $httpOnly = true,
    ) {
    }

    public function create(Response $response, string $rawRefreshToken, DateTime $expiresAt): void
    {
        $cookie = Cookie::create(self::COOKIE_NAME)
            ->withValue($rawRefreshToken)
            ->withExpires($expiresAt)
            ->withPath($this->path)
            ->withSecure($this->isSecure)
            ->withHttpOnly($this->httpOnly)
            ->withSameSite(Cookie::SAMESITE_STRICT);

        $response->headers->setCookie($cookie);
    }

    public function clear(Response $response): void
    {
        $response->headers->clearCookie(
            self::COOKIE_NAME,
            $this->path,
            null,
            $this->isSecure,
            $this->httpOnly,
            Cookie::SAMESITE_STRICT,
        );
    }
}
