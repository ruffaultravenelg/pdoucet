<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250916164452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__depeche AS SELECT id, text, date FROM depeche');
        $this->addSql('DROP TABLE depeche');
        $this->addSql('CREATE TABLE depeche (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, text VARCHAR(2040) NOT NULL, date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO depeche (id, text, date) SELECT id, text, date FROM __temp__depeche');
        $this->addSql('DROP TABLE __temp__depeche');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depeche ADD COLUMN is_positive BOOLEAN NOT NULL');
    }
}
