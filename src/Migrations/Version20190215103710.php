<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190215103710 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__prenotazioni AS SELECT id, date, motivation, item FROM prenotazioni');
        $this->addSql('DROP TABLE prenotazioni');
        $this->addSql('CREATE TABLE prenotazioni (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, date DATETIME NOT NULL, motivation VARCHAR(255) NOT NULL COLLATE BINARY, item VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_F12DF054A76ED395 FOREIGN KEY (user_id) REFERENCES guests (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO prenotazioni (id, date, motivation, item) SELECT id, date, motivation, item FROM __temp__prenotazioni');
        $this->addSql('DROP TABLE __temp__prenotazioni');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F12DF054A76ED395 ON prenotazioni (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_F12DF054A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__prenotazioni AS SELECT id, date, motivation, item FROM prenotazioni');
        $this->addSql('DROP TABLE prenotazioni');
        $this->addSql('CREATE TABLE prenotazioni (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATETIME NOT NULL, motivation VARCHAR(255) NOT NULL, item VARCHAR(255) NOT NULL, user INTEGER NOT NULL)');
        $this->addSql('INSERT INTO prenotazioni (id, date, motivation, item) SELECT id, date, motivation, item FROM __temp__prenotazioni');
        $this->addSql('DROP TABLE __temp__prenotazioni');
    }
}
