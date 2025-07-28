<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250728114959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, date_created DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , date_modifed DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , tags VARCHAR(255) DEFAULT NULL, content CLOB NOT NULL, author VARCHAR(255) NOT NULL, visible BOOLEAN NOT NULL, visit_count INTEGER DEFAULT 0 NOT NULL)');
        $this->addSql('CREATE TABLE contact_information (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('CREATE TABLE content (id VARCHAR(100) NOT NULL, content VARCHAR(2040) NOT NULL, type VARCHAR(16) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE depeche (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, text VARCHAR(2040) NOT NULL, is_positive BOOLEAN NOT NULL, date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE TABLE friend (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, fullname VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, avatar_filename VARCHAR(255) DEFAULT NULL, website_url VARCHAR(255) DEFAULT NULL, facebook_url VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE heart_pic (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, text VARCHAR(1020) DEFAULT NULL, image VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE index_link (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE journey (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATE NOT NULL --(DC2Type:date_immutable)
        , location VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, lo DOUBLE PRECISION DEFAULT NULL, la DOUBLE PRECISION DEFAULT NULL)');
        $this->addSql('CREATE TABLE page (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, subtitle VARCHAR(1020) DEFAULT NULL, content CLOB NOT NULL, creation_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , last_modification_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , header_image VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE setting ("key" VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY("key"))');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE contact_information');
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE depeche');
        $this->addSql('DROP TABLE friend');
        $this->addSql('DROP TABLE heart_pic');
        $this->addSql('DROP TABLE index_link');
        $this->addSql('DROP TABLE journey');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE setting');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
