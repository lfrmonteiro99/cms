<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230412134453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__parameter_value AS SELECT id, content_parameter_id, value, section_parameter_type FROM parameter_value');
        $this->addSql('DROP TABLE parameter_value');
        $this->addSql('CREATE TABLE parameter_value (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content_parameter_id INTEGER NOT NULL, value VARCHAR(255) NOT NULL, section_parameter_type VARCHAR(255) NOT NULL, CONSTRAINT FK_6DB2A2B878DED769 FOREIGN KEY (content_parameter_id) REFERENCES content_parameter (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO parameter_value (id, content_parameter_id, value, section_parameter_type) SELECT id, content_parameter_id, value, section_parameter_type FROM __temp__parameter_value');
        $this->addSql('DROP TABLE __temp__parameter_value');
        $this->addSql('CREATE INDEX IDX_6DB2A2B878DED769 ON parameter_value (content_parameter_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE menu');
        $this->addSql('CREATE TEMPORARY TABLE __temp__parameter_value AS SELECT id, content_parameter_id, value, section_parameter_type FROM parameter_value');
        $this->addSql('DROP TABLE parameter_value');
        $this->addSql('CREATE TABLE parameter_value (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content_parameter_id INTEGER NOT NULL, value VARCHAR(255) NOT NULL, section_parameter_type VARCHAR(255) DEFAULT \'"1"\' NOT NULL, CONSTRAINT FK_6DB2A2B878DED769 FOREIGN KEY (content_parameter_id) REFERENCES content_parameter (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO parameter_value (id, content_parameter_id, value, section_parameter_type) SELECT id, content_parameter_id, value, section_parameter_type FROM __temp__parameter_value');
        $this->addSql('DROP TABLE __temp__parameter_value');
        $this->addSql('CREATE INDEX IDX_6DB2A2B878DED769 ON parameter_value (content_parameter_id)');
    }
}
