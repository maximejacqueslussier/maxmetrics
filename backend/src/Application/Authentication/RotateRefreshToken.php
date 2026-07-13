<?php

declare(strict_types=1);

namespace App\Application\Authentication;

use App\Domain\Authentication\RefreshTokenFactory;
use App\Domain\Authentication\RefreshTokenRepository;
use App\Infrastructure\Authentication\JwtIssuer;
use App\Infrastructure\Authentication\RefreshTokenHasher;
use App\Infrastructure\Authentication\RefreshTokenIssuer;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class RotateRefreshToken
{
    public function __construct(
        private RefreshTokenHasher $refreshTokenHasher,
        private RefreshTokenFactory $refreshTokenFactory,
        private RefreshTokenIssuer $refreshTokenIssuer,
        private RefreshTokenRepository $repository,
        private JwtIssuer $jwtIssuer,
        private TranslatorInterface $translator,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function execute(?string $rawToken = null): RotateRefreshTokenResult
    {
        if ($rawToken === null || $rawToken === '') {
            throw new InvalidRefreshTokenException(
                $this->translator->trans('app.application.rotateRefreshToken.notFoundMessage'),
            );
        }

        $tokenHash = $this->refreshTokenHasher->hash($rawToken);
        $refreshToken = $this->repository->findOneByTokenHash($tokenHash);

        if (!$refreshToken) {
            throw new InvalidRefreshTokenException(
                $this->translator->trans('app.application.rotateRefreshToken.notFoundMessage'),
            );
        }

        $now = new DateTime();

        if ($refreshToken->getExpiresAt() <= $now) {
            throw new InvalidRefreshTokenException(
                $this->translator->trans('app.application.rotateRefreshToken.expiredMessage'),
            );
        }

        if ($refreshToken->getRevokedAt() !== null) {
            throw new InvalidRefreshTokenException(
                $this->translator->trans('app.application.rotateRefreshToken.revokedMessage'),
            );
        }

        if ($refreshToken->getReplacedBy() !== null) {
            throw new InvalidRefreshTokenException(
                $this->translator->trans('app.application.rotateRefreshToken.replacedMessage'),
            );
        }

        [
            'rawToken' => $rawToken,
            'hashedToken' => $hashedToken,
        ] = $this->refreshTokenIssuer->issue();

        $newRefreshToken = $this->refreshTokenFactory->create($hashedToken, $refreshToken->getUser());
        $refreshToken->replaceWith($newRefreshToken);

        $this->entityManager->persist($refreshToken);
        $this->entityManager->persist($newRefreshToken);
        $this->entityManager->flush();

        [
            'accessToken' => $accessToken,
            'expiresAt' => $expiresAt,
        ] = $this->jwtIssuer->issue($newRefreshToken->getUser());

        return new RotateRefreshTokenResult(
            $accessToken,
            $expiresAt,
            $rawToken,
            $newRefreshToken->getExpiresAt(),
        );
    }
}
