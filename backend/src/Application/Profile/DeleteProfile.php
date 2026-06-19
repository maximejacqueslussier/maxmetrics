<?php

declare(strict_types=1);

namespace App\Application\Profile;

use App\Domain\Profile\Profile;
use App\Domain\Profile\ProfileNotFoundException;
use App\Domain\Profile\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class DeleteProfile
{
    public function __construct(
        private ProfileRepository $repository,
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator,
    ) {
    }

    public function execute(int $id): Profile
    {
        $profile = $this->repository->find($id);

        if (!$profile) {
            throw new ProfileNotFoundException(
                $this->translator->trans('app.application.deleteProfile.profileNotFoundException', ['{{ id }}' => $id]),
            );
        }

        $this->entityManager->remove($profile);
        $this->entityManager->flush();

        return $profile;
    }
}
