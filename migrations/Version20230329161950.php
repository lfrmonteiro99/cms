<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329161950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE content (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE content_parameter (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content_id_id INTEGER NOT NULL, code VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, CONSTRAINT FK_1A70D9139487CA85 FOREIGN KEY (content_id_id) REFERENCES content (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_1A70D9139487CA85 ON content_parameter (content_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE content_parameter');
    }
}
