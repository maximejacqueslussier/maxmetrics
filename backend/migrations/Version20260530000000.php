<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260530000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename the user profile table and timestamp trigger';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "user" RENAME TO profile');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE profile RENAME TO "user"');
    }
}
