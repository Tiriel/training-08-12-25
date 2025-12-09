<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251209154751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conference (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, accessible BOOLEAN NOT NULL, prerequisites CLOB DEFAULT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE organization (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, presentation CLOB NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE volunteering (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE conference');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE volunteering');
    }
}
