<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260725151555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD COLUMN date_of_birth DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username, roles, password, salutation, pronouns, gender_identity, first_name, middle_name, last_name, email, phone_number, created_at, updated_at FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, roles CLOB NOT NULL, password VARCHAR(255) DEFAULT NULL, salutation VARCHAR(64) DEFAULT NULL, pronouns VARCHAR(64) DEFAULT NULL, gender_identity VARCHAR(64) DEFAULT NULL, first_name VARCHAR(128) NOT NULL, middle_name VARCHAR(128) DEFAULT NULL, last_name VARCHAR(128) NOT NULL, email VARCHAR(256) NOT NULL, phone_number VARCHAR(64) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO user (id, username, roles, password, salutation, pronouns, gender_identity, first_name, middle_name, last_name, email, phone_number, created_at, updated_at) SELECT id, username, roles, password, salutation, pronouns, gender_identity, first_name, middle_name, last_name, email, phone_number, created_at, updated_at FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_USER_USERNAME ON user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_USER_EMAIL ON user (email)');
    }
}
