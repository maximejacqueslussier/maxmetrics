<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Entity\User;
use App\Repository\UserRepository;
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

    /**
     * Deletes an existing User.
     * Returns the deleted User ID.
     *
     * @param int $id
     *
     * @return \App\Entity\User
     */
    public function execute(int $id): User
    {
        $user = $this->repository->find($id);

        if (!$user) {
            throw new UserNotFoundException(
                $this->translator->trans('app.application.deleteUser.userNotFoundException'),
            );
        }

        $this->entityManager->remove($user);

        return $user;
    }
}
