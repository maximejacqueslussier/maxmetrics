<?php

declare(strict_types=1);

namespace App\GraphQL\Authorization;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class AuthorizationGuard
{
    public function __construct(
        private AuthorizationCheckerInterface $authorizationChecker,
        private TranslatorInterface $translator,
    ) {
    }

    public function requireUser(): void
    {
        $this->requireRole('ROLE_USER');
    }

    public function requireAdmin(): void
    {
        $this->requireRole('ROLE_ADMIN');
    }

    public function requireRole(string $role): void
    {
        if (!$this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new UnauthenticatedException(
                $this->translator->trans('app.graphql.authorization.unauthenticatedException'),
            );
        }

        if (!$this->authorizationChecker->isGranted($role)) {
            throw new ForbiddenException(
                $this->translator->trans('app.graphql.authorization.forbiddenException'),
            );
        }
    }
}
