<?php

declare(strict_types=1);

namespace App\Application\Authentication;

use App\Domain\Authentication\RefreshTokenFactory;
use App\Domain\User\UserRepository;
use App\Infrastructure\Authentication\JwtIssuer;
use App\Infrastructure\Authentication\RefreshTokenIssuer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class Login
{
    public function __construct(
        private UserRepository $repository,
        private JwtIssuer $jwtIssuer,
        private RefreshTokenIssuer $refreshTokenIssuer,
        private TranslatorInterface $translator,
        private UserPasswordHasherInterface $passwordHasher,
        private RefreshTokenFactory $refreshTokenFactory,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function execute(string $username, string $plainPassword): LoginResult
    {
        $user = $this->repository->findOneByUsername($username);

        if (!$user) {
            throw new BadCredentialsException($this->translator->trans('app.application.login.badCredentials'));
        }

        if (!$this->passwordHasher->isPasswordValid($user, $plainPassword)) {
            throw new BadCredentialsException($this->translator->trans('app.application.login.badCredentials'));
        }

        [
            'rawToken' => $rawToken,
            'hashedToken' => $hashedToken,
        ] = $this->refreshTokenIssuer->issue();

        $refreshToken = $this->refreshTokenFactory->create($hashedToken, $user);
        $this->entityManager->persist($refreshToken);
        $this->entityManager->flush();

        [
            'accessToken' => $accessToken,
            'expiresAt' => $expiresAt,
        ] = $this->jwtIssuer->issue($user);

        return new LoginResult(
            $accessToken,
            $expiresAt,
            $rawToken,
            $refreshToken->getExpiresAt()
        );
    }
}
