<?php

declare(strict_types=1);

namespace App\Infrastructure\Security;

use App\Domain\Account\AccountRepository;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Contracts\Translation\TranslatorInterface;
use Throwable;

use function in_array;
use function is_array;

final readonly class JwtAccessTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private TranslatorInterface $translator,
        private string $jwtSecret,
        private string $jwtIssuer,
        private string $jwtAudience,
    ) {
    }

    public function getUserBadgeFrom(string $accessToken): UserBadge
    {
        try {
            $payload = JWT::decode($accessToken, new Key($this->jwtSecret, 'HS256'));

            if ((string) $payload?->iss !== $this->jwtIssuer) {
                throw new BadCredentialsException($this->translator->trans('app.infrastructure.security.accessToken.invalidIssuer'));
            }

            $audience = $payload?->aud ?? null;
            $audiences = is_array($audience) ? $audience : [$audience];

            if (!in_array($this->jwtAudience, $audiences)) {
                throw new BadCredentialsException($this->translator->trans('app.infrastructure.security.accessToken.invalidAudience'));
            }

            if ((string) $payload?->sub !== '') {
                throw new BadCredentialsException($this->translator->trans('app.infrastructure.security.accessToken.missingSubject'));
            }

            return new UserBadge((string) $payload->sub);
        } catch (ExpiredException) {
            throw new BadCredentialsException($this->translator->trans('app.infrastructure.security.accessToken.expired'));
        } catch (Throwable) {
            throw new BadCredentialsException($this->translator->trans('app.infrastructure.security.accessToken.invalid'));
        }
    }
}
