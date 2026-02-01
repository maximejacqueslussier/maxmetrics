<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260206145648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds created_at and updated_at columns';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, salutation, pronouns, gender_identity, first_name, middle_name, last_name, email, phone_number FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, salutation VARCHAR(64) DEFAULT NULL, pronouns VARCHAR(64) DEFAULT NULL, gender_identity VARCHAR(64) DEFAULT NULL, first_name VARCHAR(128) NOT NULL, middle_name VARCHAR(128) DEFAULT NULL, last_name VARCHAR(128) NOT NULL, email VARCHAR(256) NOT NULL, phone_number VARCHAR(64) DEFAULT NULL, created_at DATETIME NOT NULL DEFAULT (CURRENT_TIMESTAMP), updated_at DATETIME NOT NULL DEFAULT (CURRENT_TIMESTAMP))');
        $this->addSql('INSERT INTO user (id, salutation, pronouns, gender_identity, first_name, middle_name, last_name, email, phone_number, created_at, updated_at) SELECT id, salutation, pronouns, gender_identity, first_name, middle_name, last_name, email, phone_number, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE TRIGGER trig_user_au_timestamps AFTER UPDATE ON user FOR EACH ROW WHEN NEW.updated_at = OLD.updated_at BEGIN UPDATE user SET updated_at = CURRENT_TIMESTAMP WHERE id = NEW.id; END');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TRIGGER IF EXISTS trig_user_au_timestamps');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, salutation, pronouns, gender_identity, first_name, middle_name, last_name, email, phone_number FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, salutation VARCHAR(64) DEFAULT NULL, pronouns VARCHAR(64) DEFAULT NULL, gender_identity VARCHAR(64) DEFAULT NULL, first_name VARCHAR(128) NOT NULL, middle_name VARCHAR(128) DEFAULT NULL, last_name VARCHAR(128) NOT NULL, email VARCHAR(256) NOT NULL, phone_number VARCHAR(64) DEFAULT NULL)');
        $this->addSql('INSERT INTO user (id, salutation, pronouns, gender_identity, first_name, middle_name, last_name, email, phone_number) SELECT id, salutation, pronouns, gender_identity, first_name, middle_name, last_name, email, phone_number FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }
}
