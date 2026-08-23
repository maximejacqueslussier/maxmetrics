<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260628000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Enforce unique usernames and email addresses';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE UNIQUE INDEX UNIQ_USER_USERNAME ON "user" (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_USER_EMAIL ON "user" (email)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX UNIQ_USER_USERNAME');
        $this->addSql('DROP INDEX UNIQ_USER_EMAIL');
    }
}
