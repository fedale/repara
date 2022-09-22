<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630192440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Customer tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE customer_type (
            id SMALLSERIAL NOT NULL,
            name VARCHAR(255) DEFAULT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX ON customer_type (name)');
        

        $this->addSql('CREATE TABLE customer (
            id SERIAL NOT NULL,
            code VARCHAR(64) NOT NULL,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(60) NOT NULL,
            unconfirmed_email VARCHAR(255) DEFAULT NULL,
            registration_ip VARCHAR(45) DEFAULT NULL,
            type_id SMALLINT DEFAULT 1 NOT NULL,
            confirmed_at TIMESTAMP DEFAULT NULL,
            last_login_at TIMESTAMP DEFAULT NULL,
            blocked_at TIMESTAMP DEFAULT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE UNIQUE INDEX ON customer (email)');
        $this->addSql('CREATE UNIQUE INDEX ON customer (username)');
        $this->addSql('CREATE UNIQUE INDEX ON customer (code)');
        $this->addSql('CREATE INDEX ON customer (type_id)');
        $this->addSql('CREATE INDEX ON customer (active)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT customer_ibfk_1 FOREIGN KEY (type_id) REFERENCES customer_type (id) ON DELETE NO ACTION ON UPDATE NO ACTION');
        
        
        $this->addSql('CREATE TABLE customer_attachment (
            id SERIAL NOT NULL,
            customer_id INT NOT NULL,
            name VARCHAR(255) NOT NULL,
            type VARCHAR(32) NOT NULL,
            size INT NOT NULL,
            path VARCHAR(128) NOT NULL,
            filename VARCHAR(128) NOT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX ON customer_attachment  (active)');
        $this->addSql('CREATE INDEX ON customer_attachment (size)');
        $this->addSql('CREATE INDEX ON customer_attachment (type)');
        $this->addSql('CREATE INDEX ON customer_attachment (name)');
        $this->addSql('CREATE INDEX ON customer_attachment (filename)');
        $this->addSql('CREATE INDEX ON customer_attachment (path)');
        $this->addSql('CREATE INDEX ON customer_attachment (type)');
        $this->addSql('CREATE INDEX ON customer_attachment (customer_id)');
        $this->addSql('ALTER TABLE customer_attachment ADD CONSTRAINT customer_attachment_ibfk_1 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE NO ACTION ON UPDATE NO ACTION');
        
        $this->addSql('CREATE TABLE customer_location (
            id SERIAL NOT NULL,
            customer_id INT NOT NULL CHECK (customer_id > 0),
            name VARCHAR(128) NOT NULL,
            address VARCHAR(64) NOT NULL,
            zipcode VARCHAR(8) DEFAULT NULL,
            city VARCHAR(64) NOT NULL,
            country VARCHAR(32) NOT NULL DEFAULT \'Italia\',
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX ON customer_location (city)');
        $this->addSql('CREATE INDEX ON customer_location (active)');
        $this->addSql('CREATE INDEX ON customer_location (address)');
        $this->addSql('CREATE INDEX ON customer_location (zipcode)');
        $this->addSql('CREATE INDEX ON customer_location (updated_at)');
        $this->addSql('CREATE INDEX ON customer_location (created_at)');
        $this->addSql('CREATE INDEX ON customer_location (customer_id)');
        $this->addSql('ALTER TABLE customer_location ADD CONSTRAINT customer_location_ibfk_1 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE NO ACTION ON UPDATE NO ACTION');

        $this->addSql('CREATE TABLE customer_contact (
            id SERIAL NOT NULL,
            customer_location_id INT DEFAULT NULL CHECK (customer_location_id > 0),
            firstname VARCHAR(64) NOT NULL,
            lastname VARCHAR(64) NOT NULL,
            phone VARCHAR(32) DEFAULT NULL,
            email VARCHAR(32) DEFAULT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX ON customer_contact (active)');
        $this->addSql('CREATE INDEX ON customer_contact (updated_at)');
        $this->addSql('CREATE INDEX ON customer_contact (firstname)');
        $this->addSql('CREATE INDEX ON customer_contact (customer_location_id)');
        $this->addSql('CREATE INDEX ON customer_contact (created_at)');
        $this->addSql('CREATE INDEX ON customer_contact (lastname)');
        $this->addSql('CREATE UNIQUE INDEX ON customer_contact (phone, customer_location_id)');
        $this->addSql('CREATE UNIQUE INDEX ON customer_contact (email, customer_location_id)');
        $this->addSql('ALTER TABLE customer_contact ADD CONSTRAINT customer_contact_ibfk_1 FOREIGN KEY (customer_location_id) REFERENCES customer_location (id) ON DELETE NO ACTION ON UPDATE NO ACTION');

        $this->addSql('CREATE TABLE customer_location_place (
            id SERIAL NOT NULL,
            customer_location_id INT NOT NULL CHECK (customer_location_id > 0),
            name VARCHAR(64) NOT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX ON customer_location_place (created_at)');
        $this->addSql('CREATE INDEX ON customer_location_place (updated_at)');
        $this->addSql('CREATE INDEX ON customer_location_place (name)');
        $this->addSql('CREATE INDEX ON customer_location_place (active)');
        $this->addSql('CREATE INDEX ON customer_location_place (customer_location_id)');
        $this->addSql('ALTER TABLE customer_location_place ADD CONSTRAINT customer_location_place_ibfk_1 FOREIGN KEY (customer_location_id) REFERENCES customer_location (id) ON DELETE NO ACTION ON UPDATE NO ACTION');
        
        $this->addSql('CREATE TABLE customer_location_place_asset (
            id SERIAL NOT NULL,
            name VARCHAR(64) NOT NULL,
            code VARCHAR(64) NOT NULL,
            customer_location_place_id INT NOT NULL CHECK (customer_location_place_id > 0),
            asset_id INT NOT NULL CHECK (asset_id > 0),
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX ON customer_location_place_asset (updated_at)');
        $this->addSql('CREATE INDEX ON customer_location_place_asset (active)');
        $this->addSql('CREATE INDEX ON customer_location_place_asset (name)');
        $this->addSql('CREATE INDEX ON customer_location_place_asset (asset_id)');
        $this->addSql('CREATE INDEX ON customer_location_place_asset (created_at)');
        $this->addSql('CREATE UNIQUE INDEX ON customer_location_place_asset (code)');
        $this->addSql('ALTER TABLE customer_location_place_asset ADD CONSTRAINT customer_location_place_asset_ibfk_1 FOREIGN KEY (customer_location_place_id) REFERENCES customer_location_place (id) ON DELETE NO ACTION ON UPDATE NO ACTION');
        $this->addSql('ALTER TABLE customer_location_place_asset ADD CONSTRAINT customer_location_place_asset_ibfk_2 FOREIGN KEY (asset_id) REFERENCES asset (id) ON DELETE NO ACTION ON UPDATE NO ACTION');
        
        $this->addSql('CREATE TABLE customer_location_place_asset_attachment (
            id SERIAL NOT NULL,
            customer_location_place_asset_id INT DEFAULT NULL CHECK (customer_location_place_asset_id > 0),
            name VARCHAR(255) NOT NULL,
            type VARCHAR(32) NOT NULL,
            size INT NOT NULL,
            path VARCHAR(128) NOT NULL,
            filename VARCHAR(128) NOT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX ON customer_location_place_asset_attachment (created_at)');
        $this->addSql('CREATE INDEX ON customer_location_place_asset_attachment (active)');
        $this->addSql('CREATE INDEX ON customer_location_place_asset_attachment (size)');
        $this->addSql('CREATE INDEX ON customer_location_place_asset_attachment (type)');
        $this->addSql('CREATE INDEX ON customer_location_place_asset_attachment (name)');
        $this->addSql('CREATE INDEX ON customer_location_place_asset_attachment (filename)');
        $this->addSql('CREATE INDEX ON customer_location_place_asset_attachment (path)');
        $this->addSql('CREATE INDEX ON customer_location_place_asset_attachment (type)');
        $this->addSql('CREATE INDEX ON customer_location_place_asset_attachment (customer_location_place_asset_id)');
        $this->addSql('CREATE INDEX ON customer_location_place_asset_attachment (updated_at)');
        
        $this->addSql('CREATE TABLE customer_profile (
            id SERIAL NOT NULL,
            customer_id INT NOT NULL CHECK (customer_id > 0),
            firstname VARCHAR(255) DEFAULT NULL,
            lastname VARCHAR(64) NOT NULL,
            public_email VARCHAR(255) DEFAULT NULL,
            gravatar_email VARCHAR(255) DEFAULT NULL,
            gravatar_id VARCHAR(32) DEFAULT NULL,
            location VARCHAR(255) DEFAULT NULL,
            website VARCHAR(255) DEFAULT NULL,
            bio TEXT DEFAULT NULL,
            timezone VARCHAR(40) DEFAULT NULL,
            setting TEXT DEFAULT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE UNIQUE INDEX ON customer_profile (customer_id)');
        $this->addSql('ALTER TABLE customer_profile ADD CONSTRAINT customer_profile_ibfk_1 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE NO ACTION ON UPDATE NO ACTION');


        $this->addSql('CREATE TABLE customer_group (
            id SERIAL NOT NULL,
            name VARCHAR(255) DEFAULT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX ON customer_group (name)');

        $this->addSql('CREATE TABLE customer_group_assigned (
            id SERIAL NOT NULL,
            customer_id INT NOT NULL CHECK (customer_id > 0),
            customer_group_id INT NOT NULL CHECK (customer_group_id > 0),
            PRIMARY KEY(id)
        )');
        $this->addSql('ALTER TABLE customer_group_assigned ADD CONSTRAINT customer_customer_group_ibfk_1 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE NO ACTION ON UPDATE NO ACTION');
        $this->addSql('ALTER TABLE customer_group_assigned ADD CONSTRAINT customer_customer_group_ibfk_2 FOREIGN KEY (customer_group_id) REFERENCES customer_group (id) ON DELETE NO ACTION ON UPDATE NO ACTION');

        $this->addSql('CREATE TABLE customer_role (
            id SMALLSERIAL NOT NULL,
            name VARCHAR(64) NOT NULL,
            slug VARCHAR(64) NOT NULL,
            code VARCHAR(64) NOT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX ON customer_role (name)');
        $this->addSql('CREATE UNIQUE INDEX ON customer_role (slug)');
        $this->addSql('CREATE UNIQUE INDEX ON customer_role (code)');

        $this->addSql('CREATE TABLE customer_role_assigned (
            customer_id INT NOT NULL CHECK (customer_id > 0),
            customer_role_id SMALLINT NOT NULL CHECK (customer_role_id > 0),
            PRIMARY KEY(customer_id, customer_role_id)
        )');
        $this->addSql('CREATE INDEX ON customer_role_assigned (customer_role_id)');
        $this->addSql('CREATE INDEX ON customer_role_assigned (customer_id)');
        $this->addSql('ALTER TABLE customer_role_assigned ADD CONSTRAINT customer_customer_role_ibfk_1 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE NO ACTION ON UPDATE NO ACTION');
        $this->addSql('ALTER TABLE customer_role_assigned ADD CONSTRAINT customer_customer_role_ibfk_2 FOREIGN KEY (customer_role_id) REFERENCES customer_role (id) ON DELETE NO ACTION ON UPDATE NO ACTION');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE customer_profile');
        
        $this->addSql('DROP TABLE customer_attachment');
        
        $this->addSql('DROP TABLE customer_contact');
        
        $this->addSql('DROP TABLE customer_location_place_asset_attachment');
        
        $this->addSql('DROP TABLE customer_location_place_asset');
        
        $this->addSql('DROP TABLE customer_location_place');
        
        $this->addSql('DROP TABLE customer_location');
        
        $this->addSql('DROP TABLE customer_group_assigned');
        
        $this->addSql('DROP TABLE customer_group');
        
        $this->addSql('DROP TABLE customer_role_assigned'); # *_assigned before related tables

        $this->addSql('DROP TABLE customer_role');
        
        $this->addSql('DROP TABLE customer');

        $this->addSql('DROP TABLE customer_type');
    }
}
