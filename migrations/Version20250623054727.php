<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250623054727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, date_created DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , date_modifed DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , tags VARCHAR(255) NOT NULL, content CLOB NOT NULL, author VARCHAR(255) NOT NULL, visible BOOLEAN NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE content (id VARCHAR(100) NOT NULL, content VARCHAR(2040) NOT NULL, type VARCHAR(16) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE depeche (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, text VARCHAR(2040) NOT NULL, is_positive BOOLEAN NOT NULL, date DATETIME NOT NULL --(DC2Type:datetime_immutable)
            )
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE friend (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, fullname VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, avatar_filename VARCHAR(255) DEFAULT NULL, website_url VARCHAR(255) DEFAULT NULL, facebook_url VARCHAR(255) DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE heart_pic (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, text VARCHAR(1020) DEFAULT NULL, image VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE index_link (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE journey (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATE NOT NULL --(DC2Type:date_immutable)
            , location VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, lo DOUBLE PRECISION DEFAULT NULL, la DOUBLE PRECISION DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            )
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE article
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE content
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE depeche
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE friend
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE heart_pic
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE index_link
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE journey
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
