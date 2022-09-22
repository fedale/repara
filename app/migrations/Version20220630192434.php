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
            active BOOLEAN DEFAULT TRUE NOT NULL,
            created_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at timestamptz DEFAULT NULL
            )'
        );
        $this->addSql('CREATE INDEX ON asset (updated_at)');
        $this->addSql('CREATE INDEX ON asset (active)');
        $this->addSql('CREATE INDEX ON asset (model_id)');
        $this->addSql('CREATE INDEX ON asset (created_at)');
        $this->addSql('CREATE INDEX ON asset (name)');
        $this->addSql('CREATE UNIQUE INDEX ON asset (slug)');
        $this->addSql('CREATE TRIGGER set_updated_at
            BEFORE UPDATE ON asset
            FOR EACH ROW
            EXECUTE PROCEDURE trigger_set_update();
        ');
        
        $this->addSql('CREATE TABLE asset_attachment (
            id SERIAL PRIMARY KEY NOT NULL,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL,
            asset_id INT DEFAULT NULL CHECK(asset_id > 0),
            type VARCHAR(32) NOT NULL,
            size INT  NOT NULL CHECK(size > 0),
            path VARCHAR(128) NOT NULL,
            filename VARCHAR(128) NOT NULL,
            active BOOLEAN DEFAULT TRUE NOT NULL,
            created_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at timestamptz DEFAULT NULL
            )'
        );
        $this->addSql('CREATE INDEX ON asset_attachment (created_at)');
        $this->addSql('CREATE INDEX ON asset_attachment (active)');
        $this->addSql('CREATE INDEX ON asset_attachment (filename)');
        $this->addSql('CREATE INDEX ON asset_attachment (path)');
        $this->addSql('CREATE INDEX ON asset_attachment (name)');
        $this->addSql('CREATE INDEX ON asset_attachment (updated_at)');
        $this->addSql('CREATE INDEX ON asset_attachment (type)');
        $this->addSql('CREATE INDEX ON asset_attachment (asset_id)');
        $this->addSql('CREATE INDEX ON asset_attachment (size)');
        $this->addSql('CREATE UNIQUE INDEX ON asset_attachment (slug)');
        $this->addSql('CREATE TRIGGER set_updated_at
            BEFORE UPDATE ON asset_attachment
            FOR EACH ROW
            EXECUTE PROCEDURE trigger_set_update();
        ');

        $this->addSql('CREATE TABLE asset_brand (
            id SMALLSERIAL PRIMARY KEY NOT NULL,
            name VARCHAR(128) NOT NULL,
            slug VARCHAR(128) NOT NULL,
            active BOOLEAN DEFAULT TRUE NOT NULL,
            created_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at timestamptz DEFAULT NULL
            )'
        );
        $this->addSql('CREATE INDEX ON asset_brand (active)');
        $this->addSql('CREATE INDEX ON asset_brand (created_at)');
        $this->addSql('CREATE INDEX ON asset_brand (updated_at)');
        $this->addSql('CREATE INDEX ON asset_brand (name)');
        $this->addSql('CREATE UNIQUE INDEX ON asset_brand (slug)');
        $this->addSql('CREATE TRIGGER set_updated_at
            BEFORE UPDATE ON asset_brand
            FOR EACH ROW
            EXECUTE PROCEDURE trigger_set_update();
        ');
        
        $this->addSql('CREATE TABLE asset_model (
            id SMALLSERIAL PRIMARY KEY NOT NULL,
            name VARCHAR(64) NOT NULL,
            slug VARCHAR(64) NOT NULL,
            brand_id SMALLINT DEFAULT NULL,
            type_id SMALLINT NOT NULL,
            active BOOLEAN DEFAULT TRUE NOT NULL,
            created_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at timestamptz DEFAULT NULL
            )'
        );
        $this->addSql('CREATE INDEX ON asset_model (type_id)');
        $this->addSql('CREATE INDEX ON asset_model (created_at)');
        $this->addSql('CREATE INDEX ON asset_model (active)');
        $this->addSql('CREATE INDEX ON asset_model (brand_id)');
        $this->addSql('CREATE INDEX ON asset_model (updated_at)');
        $this->addSql('CREATE INDEX ON asset_model (name)');
        $this->addSql('CREATE UNIQUE INDEX ON asset_model (slug)');
        $this->addSql('CREATE TRIGGER set_updated_at
            BEFORE UPDATE ON asset_model
            FOR EACH ROW
            EXECUTE PROCEDURE trigger_set_update();
        ');
        
        $this->addSql('CREATE TABLE asset_type (
            id SMALLSERIAL PRIMARY KEY NOT NULL,
            name VARCHAR(64) NOT NULL,
            slug VARCHAR(64) NOT NULL,
            active BOOLEAN DEFAULT TRUE NOT NULL,
            created_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at timestamptz DEFAULT NULL
            )'
        );
        $this->addSql('CREATE TRIGGER set_updated_at
            BEFORE UPDATE ON asset_type
            FOR EACH ROW
            EXECUTE PROCEDURE trigger_set_update();
        ');
        
        $this->addSql('CREATE INDEX ON asset_type (active)');
        $this->addSql('CREATE INDEX ON asset_type (created_at)');
        $this->addSql('CREATE INDEX ON asset_type (updated_at)');
        $this->addSql('CREATE INDEX ON asset_type (name)');
        $this->addSql('CREATE UNIQUE INDEX ON asset_type (slug)');

        $this->addSql('CREATE TABLE asset_category (
            id SERIAL PRIMARY KEY NOT NULL,
            name VARCHAR(128) NOT NULL,
            description TEXT DEFAULT NULL,
            slug VARCHAR(128) NOT NULL,
            lft INT DEFAULT NULL,
            rgt INT DEFAULT NULL,
            parent_id INT DEFAULT NULL,
            root INT DEFAULT NULL,
            lvl INT DEFAULT NULL,
            active BOOLEAN DEFAULT TRUE NOT NULL,
            created_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at timestamptz DEFAULT NULL
            )'
        );
        $this->addSql('CREATE INDEX ON asset_category (name)');
        $this->addSql('CREATE UNIQUE INDEX ON asset_category (slug)');
        $this->addSql('CREATE INDEX ON asset_category (lft)');
        $this->addSql('CREATE INDEX ON asset_category (rgt)');
        $this->addSql('CREATE INDEX ON asset_category (parent_id)');
        $this->addSql('CREATE INDEX ON asset_category (root)');
        $this->addSql('CREATE INDEX ON asset_category (lvl)');
        $this->addSql('CREATE INDEX ON asset_category (active)');
        $this->addSql('ALTER TABLE asset_category ADD CONSTRAINT asset_category_fk_1 FOREIGN KEY (parent_id) REFERENCES asset_category (id) ON DELETE CASCADE ON UPDATE NO ACTION');
        $this->addSql('CREATE TRIGGER set_updated_at
            BEFORE UPDATE ON asset_category
            FOR EACH ROW
            EXECUTE PROCEDURE trigger_set_update();
        ');
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