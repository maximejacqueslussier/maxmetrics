<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use DateTime;
use Symfony\Component\HttpFoundation\Cookie;

final readonly class RefreshTokenCookieManager
{
    public const string COOKIE_NAME = 'refresh_token';

    public function __construct(
        private string $path = '/',
        private bool $isSecure = true,
        private bool $httpOnly = true,
    ) {
    }

    public function create(string $rawRefreshToken, DateTime $expiresAt): Cookie
    {
        return Cookie::create(self::COOKIE_NAME)
                ->withValue($rawRefreshToken)
                ->withExpires($expiresAt)
                ->withPath($this->path)
                ->withSecure($this->isSecure)
                ->withHttpOnly($this->httpOnly)
                ->withSameSite(Cookie::SAMESITE_STRICT);
    }
}