<?php

declare(strict_types=1);

namespace App\Application\Authentication;

use App\Domain\User\UserRepository;
use App\Infrastructure\Authentication\AccessTokenIssuer;
use DateTime;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class Login
{
    public function __construct(
        private UserRepository $repository,
        private AccessTokenIssuer $accessTokenIssuer,
        private TranslatorInterface $translator,
        private UserPasswordHasherInterface $passwordHasher,
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
            'accessToken' => $accessToken,
            'expiresAt' => $expiresAt,
        ] = $this->accessTokenIssuer->issue($user);

        return new LoginResult($user, $accessToken, (new DateTime())->setTimestamp($expiresAt));
    }
}
