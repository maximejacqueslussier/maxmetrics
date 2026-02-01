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
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, salutation, pronouns, gender_identity, first_name, middle_name, last_name, email, phone_number FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, salutation VARCHAR(64) DEFAULT NULL, pronouns VARCHAR(64) DEFAULT NULL, gender_identity VARCHAR(64) DEFAULT NULL, first_name VARCHAR(128) NOT NULL, middle_name VARCHAR(128) DEFAULT NULL, last_name VARCHAR(128) NOT NULL, email VARCHAR(256) NOT NULL, phone_number VARCHAR(64) DEFAULT NULL)');
        $this->addSql('INSERT INTO user (id, salutation, pronouns, gender_identity, first_name, middle_name, last_name, email, phone_number) SELECT id, salutation, pronouns, gender_identity, first_name, middle_name, last_name, email, phone_number FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD COLUMN password VARCHAR(256) NOT NULL');
    }
}
