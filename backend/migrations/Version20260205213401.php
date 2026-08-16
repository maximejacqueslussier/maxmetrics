<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260205213401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Drop the password from the User schema. Will be added through a SecurityUser adapter.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "user" DROP password');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "user" ADD password VARCHAR(256) NOT NULL');
    }
}
