<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630192434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Asset tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE asset (
            id SMALLSERIAL PRIMARY KEY NOT NULL,
            name VARCHAR(128) NOT NULL,
            slug VARCHAR(100) NOT NULL,
            model_id SMALLINT DEFAULT NULL CHECK (model_id > 0),
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL
            )'
        );

        $this->addSql('CREATE INDEX ON asset (updated_at)');
        $this->addSql('CREATE INDEX ON asset (active)');
        $this->addSql('CREATE INDEX ON asset (model_id)');
        $this->addSql('CREATE INDEX ON asset (created_at)');
        $this->addSql('CREATE INDEX ON asset (name)');
        $this->addSql('CREATE UNIQUE INDEX ON asset (slug)');
        
        $this->addSql('CREATE TABLE asset_attachment (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL,
            asset_id INT UNSIGNED DEFAULT NULL,
            type VARCHAR(32) NOT NULL,
            size INT UNSIGNED NOT NULL,
            path VARCHAR(128) NOT NULL,
            filename VARCHAR(128) NOT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            INDEX created_at (created_at),
            INDEX active (active),
            INDEX filename (filename),
            INDEX path (path),
            INDEX name (name),
            INDEX updated_at (updated_at),
            INDEX type (type),
            INDEX stuff_id (asset_id),
            INDEX size (size),
            UNIQUE INDEX slug (slug),
            PRIMARY KEY(id)
        ) ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE asset_brand (
            id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
            name VARCHAR(128) NOT NULL,
            slug VARCHAR(128) NOT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            INDEX active (active),
            INDEX created_at (created_at),
            INDEX updated_at (updated_at),
            INDEX name (name),
            UNIQUE INDEX slug (slug),
            PRIMARY KEY(id)
        ) ENGINE = InnoDB ');
        
        $this->addSql('CREATE TABLE asset_model (
            id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
            name VARCHAR(64) NOT NULL,
            slug VARCHAR(64) NOT NULL,
            brand_id SMALLINT UNSIGNED DEFAULT NULL,
            type_id SMALLINT NOT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            INDEX type_id (type_id),
            INDEX created_at (created_at),
            INDEX active (active),
            INDEX brand_id (brand_id),
            INDEX updated_at (updated_at),
            INDEX name (name),
            UNIQUE INDEX slug (slug),
            PRIMARY KEY(id)
        ) ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE asset_type (
            id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
            name VARCHAR(64) NOT NULL,
            slug VARCHAR(64) NOT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            INDEX active (active),
            INDEX created_at (created_at),
            INDEX updated_at (updated_at),
            INDEX name (name),
            UNIQUE INDEX slug (slug),
            PRIMARY KEY (id)
        ) ENGINE = InnoDB');

        $this->addSql('CREATE TABLE asset_category (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            name VARCHAR(128) NOT NULL,
            description TEXT DEFAULT NULL,
            slug VARCHAR(128) NOT NULL,
            lft INT UNSIGNED DEFAULT NULL,
            rgt INT UNSIGNED DEFAULT NULL,
            parent_id INT UNSIGNED DEFAULT NULL,
            root INT UNSIGNED DEFAULT NULL,
            lvl INT UNSIGNED DEFAULT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            PRIMARY KEY (id),
            INDEX name (name),
            UNIQUE INDEX slug (slug),
            INDEX lft (lft),
            INDEX rgt (rgt),
            INDEX parent_id (parent_id),
            INDEX root (root),
            INDEX lvl (lvl),
            INDEX active (active),
            CONSTRAINT `asset_category_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `asset_category` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
        )');
        
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE asset_attachment');

        $this->addSql('DROP TABLE asset');   

        $this->addSql('DROP TABLE asset_model');

        $this->addSql('DROP TABLE asset_brand');
        
        $this->addSql('DROP TABLE asset_type'); 

        $this->addSql('DROP TABLE asset_category');   
    }
}