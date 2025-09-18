<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250918031854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Recreate user_request to add status column with default pending for existing rows';
    }

    public function up(Schema $schema): void
    {
        // sauvegarde des données existantes
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_request AS SELECT id, product_id, name, tel, email, message, date_created FROM user_request');

        // suppression de l'ancienne table
        $this->addSql('DROP TABLE user_request');

        // création de la nouvelle table avec la colonne status NOT NULL DEFAULT \'pending\'
        $this->addSql(
            'CREATE TABLE user_request (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                product_id INTEGER DEFAULT NULL,
                name VARCHAR(255) NOT NULL,
                tel VARCHAR(64) DEFAULT NULL,
                email VARCHAR(255) DEFAULT NULL,
                message CLOB DEFAULT NULL,
                date_created DATETIME NOT NULL --(DC2Type:datetime_immutable)
                , date_closed DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
                , note CLOB DEFAULT NULL,
                status VARCHAR(255) NOT NULL DEFAULT \'pending\',
                CONSTRAINT FK_639A91954584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE
            )'
        );

        // remise des données, on fournit la valeur par défaut 'pending' pour l'ancienne ligne
        $this->addSql(
            'INSERT INTO user_request (id, product_id, name, tel, email, message, date_created, status)
             SELECT id, product_id, name, tel, email, message, date_created, \'pending\' FROM __temp__user_request'
        );

        // nettoyage et index
        $this->addSql('DROP TABLE __temp__user_request');
        $this->addSql('CREATE INDEX IDX_639A91954584665A ON user_request (product_id)');
    }

    public function down(Schema $schema): void
    {
        // reverse: recréer l'ancienne structure sans status
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_request AS SELECT id, product_id, name, tel, email, message, date_created FROM user_request');
        $this->addSql('DROP TABLE user_request');
        $this->addSql(
            'CREATE TABLE user_request (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                product_id INTEGER DEFAULT NULL,
                name VARCHAR(255) NOT NULL,
                tel VARCHAR(64) DEFAULT NULL,
                email VARCHAR(255) DEFAULT NULL,
                message CLOB DEFAULT NULL,
                date_created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
                CONSTRAINT FK_639A91954584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE
            )'
        );
        $this->addSql('INSERT INTO user_request (id, product_id, name, tel, email, message, date_created) SELECT id, product_id, name, tel, email, message, date_created FROM __temp__user_request');
        $this->addSql('DROP TABLE __temp__user_request');
        $this->addSql('CREATE INDEX IDX_639A91954584665A ON user_request (product_id)');
    }
}
