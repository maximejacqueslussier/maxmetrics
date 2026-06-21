<?php

declare(strict_types=1);

namespace App\Application\User;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class DeleteUser
{
    public function __construct(
        private UserRepository $repository,
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator,
    ) {
    }

    public function execute(int $id): void
    {
        $user = $this->repository->findUser($id);

        if (!$user) {
            throw new UserNotFoundException(
                $this->translator->trans('app.application.deleteUser.userNotFoundException', ['{{ id }}' => $id]),
            );
        }

        $account = $user->getAccount();

        $this->entityManager->wrapInTransaction(function () use ($user, $account): void {
            $this->entityManager->remove($user);

            if ($account !== null) {
                $this->entityManager->remove($account);
            }
        });
    }
}
