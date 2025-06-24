<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250624064219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__article AS SELECT id, title, subtitle, date_created, date_modifed, tags, content, author, visible FROM article
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE article
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, date_created DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , date_modifed DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , tags VARCHAR(255) NOT NULL, content CLOB NOT NULL, author VARCHAR(255) NOT NULL, visible BOOLEAN NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO article (id, title, subtitle, date_created, date_modifed, tags, content, author, visible) SELECT id, title, subtitle, date_created, date_modifed, tags, content, author, visible FROM __temp__article
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__article
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__depeche AS SELECT id, text, is_positive, date FROM depeche
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE depeche
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE depeche (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, text VARCHAR(2040) NOT NULL, is_positive BOOLEAN NOT NULL, date DATETIME NOT NULL --(DC2Type:datetime_immutable)
            )
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO depeche (id, text, is_positive, date) SELECT id, text, is_positive, date FROM __temp__depeche
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__depeche
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__journey AS SELECT id, date, location, description, address, lo, la FROM journey
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE journey
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE journey (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATE NOT NULL --(DC2Type:date_immutable)
            , location VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, lo DOUBLE PRECISION DEFAULT NULL, la DOUBLE PRECISION DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO journey (id, date, location, description, address, lo, la) SELECT id, date, location, description, address, lo, la FROM __temp__journey
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__journey
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE page ADD COLUMN header_image VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE page ADD COLUMN slug VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__messenger_messages AS SELECT id, body, headers, queue_name, created_at, available_at, delivered_at FROM messenger_messages
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            )
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO messenger_messages (id, body, headers, queue_name, created_at, available_at, delivered_at) SELECT id, body, headers, queue_name, created_at, available_at, delivered_at FROM __temp__messenger_messages
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__messenger_messages
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__article AS SELECT id, title, subtitle, date_created, date_modifed, tags, content, author, visible FROM article
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE article
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, date_created DATETIME NOT NULL, date_modifed DATETIME NOT NULL, tags VARCHAR(255) NOT NULL, content CLOB NOT NULL, author VARCHAR(255) NOT NULL, visible BOOLEAN NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO article (id, title, subtitle, date_created, date_modifed, tags, content, author, visible) SELECT id, title, subtitle, date_created, date_modifed, tags, content, author, visible FROM __temp__article
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__article
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__depeche AS SELECT id, text, is_positive, date FROM depeche
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE depeche
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE depeche (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, text VARCHAR(2040) NOT NULL, is_positive BOOLEAN NOT NULL, date DATETIME NOT NULL --(DC2Type:datetime_immutable)
            )
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO depeche (id, text, is_positive, date) SELECT id, text, is_positive, date FROM __temp__depeche
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__depeche
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__journey AS SELECT id, date, location, description, address, lo, la FROM journey
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE journey
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE journey (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATE NOT NULL --(DC2Type:date_immutable)
            , location VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, lo DOUBLE PRECISION DEFAULT NULL, la DOUBLE PRECISION DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO journey (id, date, location, description, address, lo, la) SELECT id, date, location, description, address, lo, la FROM __temp__journey
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__journey
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__messenger_messages AS SELECT id, body, headers, queue_name, created_at, available_at, delivered_at FROM messenger_messages
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO messenger_messages (id, body, headers, queue_name, created_at, available_at, delivered_at) SELECT id, body, headers, queue_name, created_at, available_at, delivered_at FROM __temp__messenger_messages
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__messenger_messages
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
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__page AS SELECT id, name, subtitle, content, creation_date, last_modification_date FROM page
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE page
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE page (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, subtitle VARCHAR(1020) DEFAULT NULL, content CLOB NOT NULL, creation_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , last_modification_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
            )
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO page (id, name, subtitle, content, creation_date, last_modification_date) SELECT id, name, subtitle, content, creation_date, last_modification_date FROM __temp__page
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__page
        SQL);
    }
}
