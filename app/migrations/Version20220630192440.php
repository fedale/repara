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
            id SMALLSERIAL PRIMARY KEY NOT NULL,
            name VARCHAR(255) DEFAULT NULL,
            INDEX name (name),
            PRIMARY KEY(id)
        ) ENGINE = InnoDB ');

        $this->addSql('CREATE TABLE customer (
            id SERIAL PRIMARY KEY NOT NULL,
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
            UNIQUE INDEX email (email),
            UNIQUE INDEX username (username),
            UNIQUE INDEX code (code),
            INDEX type_id (type_id),
            INDEX active (active),
            PRIMARY KEY(id),
            CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `customer_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE customer_attachment (
            id SERIAL PRIMARY KEY NOT NULL,
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
            INDEX created_at (created_at),
            INDEX active (active),
            INDEX size (size),
            INDEX type_2 (type),
            INDEX name (name),
            INDEX filename (filename),
            INDEX path (path),
            INDEX type (type),
            INDEX stuff_id (customer_id),
            INDEX updated_at (updated_at),
            PRIMARY KEY(id),
            CONSTRAINT `customer_attachment_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE = InnoDB');        
        
        $this->addSql('CREATE TABLE customer_location (
            id SERIAL PRIMARY KEY NOT NULL,
            customer_id INT NOT NULL,
            name VARCHAR(128) NOT NULL,
            address VARCHAR(64) NOT NULL,
            zipcode VARCHAR(8) DEFAULT NULL,
            city VARCHAR(64) NOT NULL,
            country VARCHAR(32) DEFAULT \'Italia\' NOT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            INDEX city (city),
            INDEX active (active),
            INDEX name (address),
            INDEX zipcode (zipcode),
            INDEX updated_at (updated_at),
            INDEX created_at (created_at),
            INDEX customer_id (customer_id),
            PRIMARY KEY(id),
            CONSTRAINT `customer_location_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE = InnoDB');

        $this->addSql('CREATE TABLE customer_contact (
            id SERIAL PRIMARY KEY NOT NULL,
            customer_location_id INT DEFAULT NULL,
            firstname VARCHAR(64) NOT NULL,
            lastname VARCHAR(64) NOT NULL,
            phone VARCHAR(32) DEFAULT NULL,
            email VARCHAR(32) DEFAULT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            INDEX active (active),
            INDEX updated_at (updated_at),
            INDEX firstname (firstname),
            UNIQUE INDEX phone (phone, customer_location_id),
            INDEX customer_location_id (customer_location_id),
            INDEX created_at (created_at),
            UNIQUE INDEX email (email, customer_location_id),
            INDEX lastname (lastname),
            PRIMARY KEY(id),
            CONSTRAINT `customer_contact_ibfk_1` FOREIGN KEY (`customer_location_id`) REFERENCES `customer_location` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE = InnoDB');


        $this->addSql('CREATE TABLE customer_location_place (
            id SERIAL PRIMARY KEY NOT NULL,
            customer_location_id INT NOT NULL,
            name VARCHAR(64) NOT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            INDEX created_at (created_at),
            INDEX updated_at (updated_at),
            INDEX name (name),
            INDEX active (active),
            INDEX customer_location_id (customer_location_id),
            PRIMARY KEY(id),
            CONSTRAINT `customer_location_place_ibfk_1` FOREIGN KEY (`customer_location_id`) REFERENCES `customer_location` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE customer_location_place_asset (
            id SERIAL PRIMARY KEY NOT NULL,
            name VARCHAR(64) NOT NULL,
            code VARCHAR(64) NOT NULL,
            customer_location_place_id INT NOT NULL,
            asset_id INT NOT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            INDEX updated_at (updated_at),
            INDEX active (active),
            INDEX name (name),
            INDEX asset_id (asset_id),
            INDEX created_at (created_at),
            UNIQUE INDEX code (code),
            PRIMARY KEY(id),
            CONSTRAINT `customer_location_place_asset_ibfk_1` FOREIGN KEY (`customer_location_place_id`) REFERENCES `customer_location_place` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `customer_location_place_asset_ibfk_2` FOREIGN KEY (`asset_id`) REFERENCES `asset` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE customer_location_place_asset_attachment (
            id SERIAL PRIMARY KEY NOT NULL,
            customer_location_place_asset_id INT DEFAULT NULL,
            name VARCHAR(255) NOT NULL,
            type VARCHAR(32) NOT NULL,
            size INT NOT NULL,
            path VARCHAR(128) NOT NULL,
            filename VARCHAR(128) NOT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            INDEX created_at (created_at),
            INDEX active (active),
            INDEX size (size),
            INDEX type_2 (type),
            INDEX name (name),
            INDEX filename (filename),
            INDEX path (path),
            INDEX type (type),
            INDEX stuff_id (customer_location_place_asset_id),
            INDEX updated_at (updated_at),
            PRIMARY KEY(id)
        ) ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE customer_profile (
            id SERIAL PRIMARY KEY NOT NULL,
            customer_id INT NOT NULL,
            firstname VARCHAR(255) DEFAULT NULL,
            lastname VARCHAR(64) NOT NULL,
            public_email VARCHAR(255) DEFAULT NULL,
            gravatar_email VARCHAR(255) DEFAULT NULL,
            gravatar_id VARCHAR(32) DEFAULT NULL,
            location VARCHAR(255) DEFAULT NULL,
            website VARCHAR(255) DEFAULT NULL,
            bio TEXT DEFAULT NULL,
            timezone VARCHAR(40) DEFAULT NULL,
            setting LONGTEXT DEFAULT NULL COMMENT \'settings preferences\',
            PRIMARY KEY(id),
            UNIQUE INDEX(customer_id),
            CONSTRAINT `customer_profile_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE = InnoDB');

        $this->addSql('CREATE TABLE customer_group (
            id SERIAL PRIMARY KEY NOT NULL,
            name VARCHAR(255) DEFAULT NULL,
            INDEX name (name),
            PRIMARY KEY(id)
        ) ENGINE = InnoDB');

        $this->addSql('CREATE TABLE customer_group_assigned (
            id SERIAL PRIMARY KEY NOT NULL,
            customer_id INT NOT NULL,
            customer_group_id INT NOT NULL,
            PRIMARY KEY(id),
            CONSTRAINT `customer_customer_group_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `customer_customer_group_ibfk_2` FOREIGN KEY (`customer_group_id`) REFERENCES `customer_group` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE = InnoDB');

        $this->addSql('CREATE TABLE customer_role (
            id SMALLSERIAL PRIMARY KEY NOT NULL,
            name VARCHAR(64) NOT NULL,
            slug VARCHAR(64) NOT NULL,
            code VARCHAR(64) NOT NULL,
            INDEX name (name),
            UNIQUE INDEX slug (slug),
            UNIQUE INDEX code (code),
            PRIMARY KEY(id)
        ) ENGINE = InnoDB');

        $this->addSql('CREATE TABLE customer_role_assigned (
            customer_id INT NOT NULL,
            customer_role_id SMALLINT NOT NULL,
            INDEX FK_D95AB405A76ED398 (customer_role_id),
            INDEX IDX_CFC787FBA76ED396 (customer_id),
            PRIMARY KEY(customer_id, customer_role_id),
            CONSTRAINT `customer_customer_role_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `customer_customer_role_ibfk_2` FOREIGN KEY (`customer_role_id`) REFERENCES `customer_role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE = InnoDB');
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
