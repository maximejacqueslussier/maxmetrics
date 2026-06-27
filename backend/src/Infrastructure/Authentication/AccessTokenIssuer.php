<?php

namespace App\Infrastructure\Authentication;

use Symfony\Component\Security\Core\User\UserInterface;

interface AccessTokenIssuer
{
    public function issue(UserInterface $user): array;
}