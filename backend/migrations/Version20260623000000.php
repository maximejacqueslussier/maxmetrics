<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260623000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Merge profile and account into a single user table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE user (' .
            'id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ' .
            'username VARCHAR(255) DEFAULT NULL, roles CLOB NOT NULL, password VARCHAR(255) DEFAULT NULL, ' .
            'salutation VARCHAR(64) DEFAULT NULL, pronouns VARCHAR(64) DEFAULT NULL, ' .
            'gender_identity VARCHAR(64) DEFAULT NULL, first_name VARCHAR(128) NOT NULL, ' .
            'middle_name VARCHAR(128) DEFAULT NULL, last_name VARCHAR(128) NOT NULL, ' .
            'email VARCHAR(256) NOT NULL, phone_number VARCHAR(64) DEFAULT NULL, ' .
            'created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)'
        );
        $this->addSql(
            'INSERT INTO user (' .
            'id, username, roles, password, salutation, pronouns, gender_identity, first_name, ' .
            'middle_name, last_name, email, phone_number, created_at, updated_at' .
            ') SELECT ' .
            'p.id, a.username, COALESCE(a.roles, \'["ROLE_USER"]\'), a.password, p.salutation, p.pronouns, ' .
            'p.gender_identity, p.first_name, p.middle_name, p.last_name, p.email, p.phone_number, ' .
            'p.created_at, p.updated_at ' .
            'FROM profile p LEFT JOIN account a ON a.id = p.account_id'
        );
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE account');
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE account (' .
            'id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, ' .
            'roles CLOB NOT NULL, password VARCHAR(255) NOT NULL)'
        );
        $this->addSql(
            'INSERT INTO account (id, username, roles, password) ' .
            'SELECT id, username, roles, password FROM user ' .
            'WHERE username IS NOT NULL AND password IS NOT NULL'
        );
        $this->addSql(
            'CREATE TABLE profile (' .
            'id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, salutation VARCHAR(64) DEFAULT NULL, ' .
            'pronouns VARCHAR(64) DEFAULT NULL, gender_identity VARCHAR(64) DEFAULT NULL, ' .
            'first_name VARCHAR(128) NOT NULL, middle_name VARCHAR(128) DEFAULT NULL, ' .
            'last_name VARCHAR(128) NOT NULL, email VARCHAR(256) NOT NULL, ' .
            'phone_number VARCHAR(64) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, ' .
            'account_id INTEGER DEFAULT NULL, ' .
            'CONSTRAINT FK_8157AA0F9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) ' .
            'NOT DEFERRABLE INITIALLY IMMEDIATE)'
        );
        $this->addSql(
            'INSERT INTO profile (' .
            'id, salutation, pronouns, gender_identity, first_name, middle_name, last_name, email, ' .
            'phone_number, created_at, updated_at, account_id' .
            ') SELECT ' .
            'id, salutation, pronouns, gender_identity, first_name, middle_name, last_name, email, ' .
            'phone_number, created_at, updated_at, ' .
            'CASE WHEN username IS NOT NULL AND password IS NOT NULL THEN id ELSE NULL END ' .
            'FROM user'
        );
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8157AA0F9B6B5FBA ON profile (account_id)');
        $this->addSql('DROP TABLE user');
    }
}
