<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250625063852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__setting AS SELECT id, value FROM setting
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE setting
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE setting ("key" VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY("key"))
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO setting ("key", value) SELECT id, value FROM __temp__setting
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__setting
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__setting AS SELECT "key", value FROM setting
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE setting
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE setting (id VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO setting (id, value) SELECT "key", value FROM __temp__setting
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__setting
        SQL);
    }
}
