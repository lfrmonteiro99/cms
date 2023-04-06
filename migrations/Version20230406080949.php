<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406080949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__parameter_value AS SELECT id FROM parameter_value');
        $this->addSql('DROP TABLE parameter_value');
        $this->addSql('CREATE TABLE parameter_value (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content_parameter_id INTEGER NOT NULL, CONSTRAINT FK_6DB2A2B878DED769 FOREIGN KEY (content_parameter_id) REFERENCES content_parameter (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO parameter_value (id) SELECT id FROM __temp__parameter_value');
        $this->addSql('DROP TABLE __temp__parameter_value');
        $this->addSql('CREATE INDEX IDX_6DB2A2B878DED769 ON parameter_value (content_parameter_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__parameter_value AS SELECT id FROM parameter_value');
        $this->addSql('DROP TABLE parameter_value');
        $this->addSql('CREATE TABLE parameter_value (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('INSERT INTO parameter_value (id) SELECT id FROM __temp__parameter_value');
        $this->addSql('DROP TABLE __temp__parameter_value');
    }
}
