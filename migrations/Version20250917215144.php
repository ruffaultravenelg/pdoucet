<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250917215144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // 1. Créer une table temporaire avec la nouvelle colonne
        $this->addSql('CREATE TABLE __temp__user_request (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            product_id INTEGER DEFAULT NULL,
            name VARCHAR(255) NOT NULL,
            tel VARCHAR(64) DEFAULT NULL,
            email VARCHAR(255) DEFAULT NULL,
            message CLOB DEFAULT NULL,
            date_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            CONSTRAINT FK_639A91954584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        )');

        // 2. Copier les anciennes données dans la nouvelle table, avec date_created initialisé à CURRENT_TIMESTAMP
        $this->addSql("INSERT INTO __temp__user_request (id, product_id, name, tel, email, message, date_created)
                    SELECT id, product_id, name, tel, email, message, strftime('%Y-%m-%d %H:%M:%S', 'now')
                    FROM user_request");

        // 3. Supprimer l’ancienne table
        $this->addSql('DROP TABLE user_request');

        // 4. Renommer la table temporaire en user_request
        $this->addSql('ALTER TABLE __temp__user_request RENAME TO user_request');

        // 5. Recréer l’index
        $this->addSql('CREATE INDEX IDX_639A91954584665A ON user_request (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_request AS SELECT id, product_id, name, tel, email, message FROM user_request');
        $this->addSql('DROP TABLE user_request');
        $this->addSql('CREATE TABLE user_request (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, product_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, tel VARCHAR(64) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, message CLOB DEFAULT NULL, CONSTRAINT FK_639A91954584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_request (id, product_id, name, tel, email, message) SELECT id, product_id, name, tel, email, message FROM __temp__user_request');
        $this->addSql('DROP TABLE __temp__user_request');
        $this->addSql('CREATE INDEX IDX_639A91954584665A ON user_request (product_id)');
    }
}
