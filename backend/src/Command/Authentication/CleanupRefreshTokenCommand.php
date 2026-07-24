<?php

declare(strict_types=1);

namespace App\Command\Authentication;

use App\Application\Authentication\CleanupRefreshToken;
use DateTime;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

#[AsCommand(
    name: 'app:authentication:cleanup-refresh-token',
    description: 'Cleans up the expired and revoked refresh tokens.',
)]
final readonly class CleanupRefreshTokenCommand
{
    public function __construct(
        private CleanupRefreshToken $cleanupRefreshToken,
    ) {
    }

    public function __invoke(SymfonyStyle $io): int
    {
        try {
            $io->title('Cleans up the expired and revoked refresh tokens');
            $this->cleanupRefreshToken->execute(new DateTime());
            $io->success('Cleanup completed');

            return Command::SUCCESS;
        } catch (Throwable $exception) {
            $io->error($exception->getMessage());

            return Command::FAILURE;
        }
    }
}
