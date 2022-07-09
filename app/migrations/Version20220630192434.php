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
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            model_id SMALLINT UNSIGNED DEFAULT NULL,
            name VARCHAR(100) NOT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at DATETIME NOT NULL DEFAULT current_timestamp(),
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            deleted_at DATETIME DEFAULT NULL,
            INDEX updated_at (updated_at),
            INDEX active (active),
            INDEX model_id (model_id),
            INDEX created_at (created_at),
            INDEX name (name),
            PRIMARY KEY(id)
        ) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE asset_attachment (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            asset_id INT UNSIGNED DEFAULT NULL,
            name VARCHAR(255) NOT NULL,
            type VARCHAR(32) NOT NULL,
            size INT UNSIGNED NOT NULL,
            path VARCHAR(128) NOT NULL,
            filename VARCHAR(128) NOT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at DATETIME NOT NULL DEFAULT current_timestamp(),
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            deleted_at DATETIME DEFAULT NULL,
            INDEX created_at (created_at),
            INDEX active (active),
            INDEX filename (filename),
            INDEX path (path),
            INDEX name (name),
            INDEX updated_at (updated_at),
            INDEX type (type),
            INDEX stuff_id (asset_id),
            INDEX size (size),
            PRIMARY KEY(id)
        ) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE asset_brand (
            id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
            name VARCHAR(100) NOT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at DATETIME NOT NULL DEFAULT current_timestamp(),
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            deleted_at DATETIME DEFAULT NULL,
            INDEX active (active),
            INDEX created_at (created_at),
            INDEX updated_at (updated_at),
            INDEX name (name),
            PRIMARY KEY(id)
        ) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE asset_model (
            id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
            brand_id SMALLINT UNSIGNED DEFAULT NULL,
            name VARCHAR(32) NOT NULL,
            type_id SMALLINT NOT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at DATETIME NOT NULL DEFAULT current_timestamp(),
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            deleted_at DATETIME DEFAULT NULL,
            INDEX type_id (type_id),
            INDEX created_at (created_at),
            INDEX active (active),
            INDEX brand_id (brand_id),
            INDEX updated_at (updated_at),
            INDEX name (name),
            PRIMARY KEY(id)
        ) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE asset_type (
            id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
            name VARCHAR(64) NOT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at DATETIME NOT NULL DEFAULT current_timestamp(),
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            deleted_at DATETIME DEFAULT NULL,
            INDEX active (active),
            INDEX created_at (created_at),
            INDEX updated_at (updated_at),
            INDEX name (name),
            PRIMARY KEY(id)
        ) ENGINE = InnoDB COMMENT = \'\' ');
        
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE asset_attachment');

        $this->addSql('DROP TABLE asset');   

        $this->addSql('DROP TABLE asset_model');

        $this->addSql('DROP TABLE asset_brand');
        
        $this->addSql('DROP TABLE asset_type');   
    }
}