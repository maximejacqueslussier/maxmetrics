<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260116143255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adding email, phoneNumber and password to the User schema';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "user" ADD email VARCHAR(256) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD phone_number VARCHAR(64) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD password VARCHAR(256) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "user" DROP password');
        $this->addSql('ALTER TABLE "user" DROP phone_number');
        $this->addSql('ALTER TABLE "user" DROP email');
    }
}
