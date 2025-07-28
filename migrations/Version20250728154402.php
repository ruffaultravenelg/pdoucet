<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250728154402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__index_link AS SELECT id, page_id, name, image, url FROM index_link');
        $this->addSql('DROP TABLE index_link');
        $this->addSql('CREATE TABLE index_link (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, page_id INTEGER DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, image VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_9D2C41A2C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO index_link (id, page_id, name, image, url) SELECT id, page_id, name, image, url FROM __temp__index_link');
        $this->addSql('DROP TABLE __temp__index_link');
        $this->addSql('CREATE INDEX IDX_9D2C41A2C4663E4 ON index_link (page_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__index_link AS SELECT id, page_id, name, image, url FROM index_link');
        $this->addSql('DROP TABLE index_link');
        $this->addSql('CREATE TABLE index_link (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, page_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, CONSTRAINT FK_9D2C41A2C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO index_link (id, page_id, name, image, url) SELECT id, page_id, name, image, url FROM __temp__index_link');
        $this->addSql('DROP TABLE __temp__index_link');
        $this->addSql('CREATE INDEX IDX_9D2C41A2C4663E4 ON index_link (page_id)');
    }
}
