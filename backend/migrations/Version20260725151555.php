<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260725151555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add a date of birth to users';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "user" ADD date_of_birth TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "user" DROP date_of_birth');
    }
}
