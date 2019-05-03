<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190205163306 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE articoli ADD COLUMN dotazioni CLOB DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__articoli AS SELECT id, name, type, dateadd, is_avaiable, codice, descrizione FROM articoli');
        $this->addSql('DROP TABLE articoli');
        $this->addSql('CREATE TABLE articoli (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, dateadd DATETIME NOT NULL, is_avaiable BOOLEAN NOT NULL, codice VARCHAR(255) DEFAULT NULL, descrizione CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO articoli (id, name, type, dateadd, is_avaiable, codice, descrizione) SELECT id, name, type, dateadd, is_avaiable, codice, descrizione FROM __temp__articoli');
        $this->addSql('DROP TABLE __temp__articoli');
    }
}
