<?php

declare(strict_types=1);

namespace App\GraphQL\Resolver\Account;

use App\Application\Account\UpdateEmail;
use App\Application\Account\UpdatePassword;
use App\Application\Account\UpdateProfile;
use App\Application\Account\UpdateUsername;
use App\Domain\User\User;
use App\GraphQL\Authorization\UnauthenticatedException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class AccountMutationResolver
{
    public function __construct(
        private Security $security,
        private TranslatorInterface $translator,
        private UpdateUsername $updateUsername,
        private UpdateEmail $updateEmail,
        private UpdatePassword $updatePassword,
        private UpdateProfile $updateProfile,
    ) {
    }

    public function updateUsername(mixed $root, array $args): array
    {
        $user = $this->getUser();
        $input = $args['input'];

        $this->updateUsername->execute($user, $input['username']);

        return [
            'user' => $user,
        ];
    }

    public function updateEmail(mixed $root, array $args): array
    {
        $user = $this->getUser();
        $input = $args['input'];

        $this->updateEmail->execute($user, $input['email']);

        return [
            'user' => $user,
        ];
    }

    public function updatePassword(mixed $root, array $args): array
    {
        $user = $this->getUser();
        $input = $args['input'];

        $this->updatePassword->execute($user, $input['password']);

        return ['success' => true];
    }

    public function updateProfile(mixed $root, array $args): array
    {
        $user = $this->getUser();
        $input = $args['input'];

        $changedFields = $this->updateProfile->execute(
            $user,
            $input['salutation'] ?? null,
            $input['pronouns'] ?? null,
            $input['genderIdentity'] ?? null,
            $input['phoneNumber'] ?? null,
        );

        return [
            'user' => $user,
            'changedFields' => $changedFields,
        ];
    }

    private function getUser(): User
    {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            throw new UnauthenticatedException(
                $this->translator->trans('app.graphql.resolver.account.unauthenticatedException'),
            );
        }

        return $user;
    }
}
