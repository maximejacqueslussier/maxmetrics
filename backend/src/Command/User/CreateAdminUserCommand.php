<?php

declare(strict_types=1);

namespace App\Command\User;

use App\Application\User\CreateUser;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

use function array_pop;
use function array_shift;
use function preg_split;
use function sprintf;

#[AsCommand(
    name: 'app:user:create-admin-user',
    description: 'Creates a new admin user.',
)]
final readonly class CreateAdminUserCommand
{
    public function __construct(
        private CreateUser $createUser,
    ) {
    }

    public function __invoke(
        SymfonyStyle $io,
        #[Argument] string $username,
        #[Argument] string $plainPassword,
        #[Argument] string $fullName,
        #[Argument] string $email,
    ): int {
        $io->title('Create an admin user');
        $io->definitionList(
            ['username' => $username],
            ['fullName' => $fullName],
            ['email' => $email],
        );

        $names = preg_split('/\s+/', trim($fullName));
        $firstName = array_shift($names);
        $lastName = array_pop($names);
        $middleName = $names !== [] ? implode(' ', $names) : null;

        try {
            $adminUser = $this->createUser->execute(
                $username,
                $plainPassword,
                'ROLE_ADMIN',
                null,
                null,
                null,
                $firstName,
                $middleName,
                $lastName,
                $email,
                null,
                null,
            );

            $io->success(sprintf('Admin user "%s" has been successfully created.', $adminUser->getUsername()));

            return Command::SUCCESS;
        } catch (Throwable $exception) {
            $io->error($exception->getMessage());

            return Command::FAILURE;
        }
    }
}
