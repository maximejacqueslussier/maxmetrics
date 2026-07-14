<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260703224648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create refresh tokens';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE refresh_token (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, token_hash VARCHAR(64) NOT NULL, expires_at DATETIME NOT NULL, revoked_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, replaced_by_id INTEGER DEFAULT NULL, user_id INTEGER NOT NULL, CONSTRAINT FK_C74F21959AC69B54 FOREIGN KEY (replaced_by_id) REFERENCES refresh_token (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C74F2195A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C74F2195B3BC57DA ON refresh_token (token_hash)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C74F21959AC69B54 ON refresh_token (replaced_by_id)');
        $this->addSql('CREATE INDEX IDX_C74F2195A76ED395 ON refresh_token (user_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE refresh_token');
    }
}
