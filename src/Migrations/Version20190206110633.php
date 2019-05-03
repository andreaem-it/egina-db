<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190206110633 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__articoli AS SELECT id, name, dateadd, is_avaiable, codice, descrizione, dotazioni, danni, type FROM articoli');
        $this->addSql('DROP TABLE articoli');
        $this->addSql('CREATE TABLE articoli (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, dateadd DATETIME NOT NULL, is_avaiable BOOLEAN NOT NULL, codice VARCHAR(255) DEFAULT NULL COLLATE BINARY, descrizione CLOB DEFAULT NULL COLLATE BINARY, dotazioni CLOB DEFAULT NULL COLLATE BINARY, danni VARCHAR(255) DEFAULT NULL COLLATE BINARY, type INTEGER DEFAULT NULL, lastuser INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO articoli (id, name, dateadd, is_avaiable, codice, descrizione, dotazioni, danni, type) SELECT id, name, dateadd, is_avaiable, codice, descrizione, dotazioni, danni, type FROM __temp__articoli');
        $this->addSql('DROP TABLE __temp__articoli');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__articoli AS SELECT id, name, type, dateadd, is_avaiable, codice, descrizione, dotazioni, danni FROM articoli');
        $this->addSql('DROP TABLE articoli');
        $this->addSql('CREATE TABLE articoli (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, dateadd DATETIME NOT NULL, is_avaiable BOOLEAN NOT NULL, codice VARCHAR(255) DEFAULT NULL, descrizione CLOB DEFAULT NULL, dotazioni CLOB DEFAULT NULL, danni VARCHAR(255) DEFAULT NULL, type CLOB DEFAULT NULL COLLATE BINARY --(DC2Type:array)
        )');
        $this->addSql('INSERT INTO articoli (id, name, type, dateadd, is_avaiable, codice, descrizione, dotazioni, danni) SELECT id, name, type, dateadd, is_avaiable, codice, descrizione, dotazioni, danni FROM __temp__articoli');
        $this->addSql('DROP TABLE __temp__articoli');
    }
}
