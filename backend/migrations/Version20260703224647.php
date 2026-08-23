<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260703224647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Require every user to have a username';
    }

    public function up(Schema $schema): void
    {
        $nullUsernameCount = (int) $this->connection->fetchOne(
            'SELECT COUNT(*) FROM "user" WHERE username IS NULL'
        );

        $this->abortIf(
            $nullUsernameCount > 0,
            'Cannot require usernames while users with a null username exist.'
        );

        $this->addSql('ALTER TABLE "user" ALTER username SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "user" ALTER username DROP NOT NULL');
    }
}
