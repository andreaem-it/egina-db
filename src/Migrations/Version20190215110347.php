<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190215110347 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_F12DF054A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__prenotazioni AS SELECT id, user_id, date, motivation, item FROM prenotazioni');
        $this->addSql('DROP TABLE prenotazioni');
        $this->addSql('CREATE TABLE prenotazioni (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, date DATETIME NOT NULL, motivation VARCHAR(255) NOT NULL COLLATE BINARY, item VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_F12DF054A76ED395 FOREIGN KEY (user_id) REFERENCES guests (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO prenotazioni (id, user_id, date, motivation, item) SELECT id, user_id, date, motivation, item FROM __temp__prenotazioni');
        $this->addSql('DROP TABLE __temp__prenotazioni');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F12DF054A76ED395 ON prenotazioni (user_id)');
        $this->addSql('DROP INDEX IDX_4D11BCB271179CD6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__guests AS SELECT id, name_id, type, location FROM guests');
        $this->addSql('DROP TABLE guests');
        $this->addSql('CREATE TABLE guests (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name_id INTEGER DEFAULT NULL, type INTEGER NOT NULL, location VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_4D11BCB271179CD6 FOREIGN KEY (name_id) REFERENCES articoli (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO guests (id, name_id, type, location) SELECT id, name_id, type, location FROM __temp__guests');
        $this->addSql('DROP TABLE __temp__guests');
        $this->addSql('CREATE INDEX IDX_4D11BCB271179CD6 ON guests (name_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_4D11BCB271179CD6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__guests AS SELECT id, name_id, type, location FROM guests');
        $this->addSql('DROP TABLE guests');
        $this->addSql('CREATE TABLE guests (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name_id INTEGER DEFAULT NULL, type INTEGER NOT NULL, location VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO guests (id, name_id, type, location) SELECT id, name_id, type, location FROM __temp__guests');
        $this->addSql('DROP TABLE __temp__guests');
        $this->addSql('CREATE INDEX IDX_4D11BCB271179CD6 ON guests (name_id)');
        $this->addSql('DROP INDEX UNIQ_F12DF054A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__prenotazioni AS SELECT id, user_id, date, motivation, item FROM prenotazioni');
        $this->addSql('DROP TABLE prenotazioni');
        $this->addSql('CREATE TABLE prenotazioni (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, date DATETIME NOT NULL, motivation VARCHAR(255) NOT NULL, item VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO prenotazioni (id, user_id, date, motivation, item) SELECT id, user_id, date, motivation, item FROM __temp__prenotazioni');
        $this->addSql('DROP TABLE __temp__prenotazioni');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F12DF054A76ED395 ON prenotazioni (user_id)');
    }
}
