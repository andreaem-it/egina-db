<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190318105856 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tipo_articoli (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guests (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type INT NOT NULL, location VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prenotazioni (id INT AUTO_INCREMENT NOT NULL, user VARCHAR(255) NOT NULL, date DATETIME NOT NULL, motivation VARCHAR(255) NOT NULL, item VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articoli (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type INT DEFAULT NULL, dateadd DATETIME NOT NULL, is_avaiable TINYINT(1) NOT NULL, codice VARCHAR(255) DEFAULT NULL, descrizione LONGTEXT DEFAULT NULL, dotazioni LONGTEXT DEFAULT NULL, danni VARCHAR(255) DEFAULT NULL, lastuser VARCHAR(255) DEFAULT NULL, lastmovement DATETIME DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, motivation VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestiti (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, item INT NOT NULL, guest VARCHAR(255) NOT NULL, location VARCHAR(255) DEFAULT NULL, motivation VARCHAR(255) DEFAULT NULL, status INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tipo_articoli');
        $this->addSql('DROP TABLE guests');
        $this->addSql('DROP TABLE prenotazioni');
        $this->addSql('DROP TABLE articoli');
        $this->addSql('DROP TABLE prestiti');
        $this->addSql('DROP TABLE user');
    }
}
