<?php

declare(strict_types=1);

namespace App\GraphQL\Resolver\Authentication;

use App\Domain\User\User;
use App\GraphQL\Authorization\UnauthenticatedException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class AuthenticationQueryResolver
{
    public function __construct(
        private Security $security,
        private TranslatorInterface $translator,
    ) {
    }

    public function me(): User
    {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            throw new UnauthenticatedException(
                $this->translator->trans('app.graphql.resolver.authentication.unauthenticatedException'),
            );
        }

        return $user;
    }
}
