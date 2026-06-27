<?php

namespace App\Infrastructure\Authentication;

use Symfony\Component\Security\Core\User\UserInterface;

interface TokenIssuer
{
    public function issue(UserInterface $user): array;
}