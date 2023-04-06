<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406084324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__content_parameter AS SELECT id, content_id_id, code, type, created_at, deleted_at, section_type FROM content_parameter');
        $this->addSql('DROP TABLE content_parameter');
        $this->addSql('CREATE TABLE content_parameter (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content_id_id INTEGER NOT NULL, code VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, section_type VARCHAR(255) NOT NULL, CONSTRAINT FK_1A70D9139487CA85 FOREIGN KEY (content_id_id) REFERENCES content (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO content_parameter (id, content_id_id, code, type, created_at, deleted_at, section_type) SELECT id, content_id_id, code, type, created_at, deleted_at, section_type FROM __temp__content_parameter');
        $this->addSql('DROP TABLE __temp__content_parameter');
        $this->addSql('CREATE INDEX IDX_1A70D9139487CA85 ON content_parameter (content_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE content_parameter ADD COLUMN text VARCHAR(255) NOT NULL');
    }
}
