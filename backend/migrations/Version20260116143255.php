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
        $this->addSql('ALTER TABLE user ADD COLUMN email VARCHAR(256) NOT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN phone_number VARCHAR(64) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN password VARCHAR(256) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS ' .
        'SELECT id, salutation, pronouns, gender_identity, first_name, middle_name, last_name ' .
        'FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (' .
        'id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ' .
        'salutation VARCHAR(64) DEFAULT NULL, ' .
        'pronouns VARCHAR(64) DEFAULT NULL, ' .
        'gender_identity VARCHAR(64) DEFAULT NULL, ' .
        'first_name VARCHAR(128) NOT NULL, ' .
        'middle_name VARCHAR(128) DEFAULT NULL, ' .
        'last_name VARCHAR(128) NOT NULL)');
        $this->addSql('INSERT INTO user (' .
        'id, salutation, pronouns, gender_identity, first_name, middle_name, last_name' .
        ') SELECT id, salutation, pronouns, gender_identity, first_name, middle_name, last_name ' .
        'FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }
}
