<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190214095442 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__prestiti AS SELECT id, date, item, guest, location, motivation, status FROM prestiti');
        $this->addSql('DROP TABLE prestiti');
        $this->addSql('CREATE TABLE prestiti (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATETIME NOT NULL, guest INTEGER NOT NULL, location VARCHAR(255) DEFAULT NULL COLLATE BINARY, motivation VARCHAR(255) DEFAULT NULL COLLATE BINARY, status INTEGER DEFAULT NULL, item VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO prestiti (id, date, item, guest, location, motivation, status) SELECT id, date, item, guest, location, motivation, status FROM __temp__prestiti');
        $this->addSql('DROP TABLE __temp__prestiti');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__prestiti AS SELECT id, date, item, guest, location, motivation, status FROM prestiti');
        $this->addSql('DROP TABLE prestiti');
        $this->addSql('CREATE TABLE prestiti (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATETIME NOT NULL, guest INTEGER NOT NULL, location VARCHAR(255) DEFAULT NULL, motivation VARCHAR(255) DEFAULT NULL, status INTEGER DEFAULT NULL, item INTEGER NOT NULL)');
        $this->addSql('INSERT INTO prestiti (id, date, item, guest, location, motivation, status) SELECT id, date, item, guest, location, motivation, status FROM __temp__prestiti');
        $this->addSql('DROP TABLE __temp__prestiti');
    }
}
