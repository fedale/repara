<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630192739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user
        (id INT UNSIGNED AUTO_INCREMENT NOT NULL,
        username VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(60) NOT NULL,
        confirmed_at INT DEFAULT NULL,
        unconfirmed_email VARCHAR(255) DEFAULT NULL,
        blocked_at INT DEFAULT NULL,
        registration_ip VARCHAR(45) DEFAULT NULL,
        type_id SMALLINT UNSIGNED DEFAULT 1,
        active tinyint DEFAULT 1 NOT NULL,
        created_at DATETIME NOT NULL DEFAULT current_timestamp(),
        updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        deleted_at DATETIME DEFAULT NULL,
        last_login_at DATETIME DEFAULT NULL,
        UNIQUE INDEX email (email),
        INDEX type_id (type_id),
        INDEX active (active),
        UNIQUE INDEX username (username),
        PRIMARY KEY(id)
        ) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE user_assigned_customer
        (id INT AUTO_INCREMENT NOT NULL,
        user_id INT UNSIGNED NOT NULL,
        customer_id INT UNSIGNED NOT NULL,
        customer_location_id INT UNSIGNED DEFAULT NULL,
        customer_location_place_id INT UNSIGNED DEFAULT NULL,
        customer_location_place_asset_id INT UNSIGNED DEFAULT NULL,
        active tinyint DEFAULT 1 NOT NULL,
        created_at DATETIME NOT NULL DEFAULT current_timestamp(),
        updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        deleted_at DATETIME DEFAULT NULL,
        INDEX customer_location_place_asset (customer_location_place_asset_id),
        INDEX active (active),
        INDEX updated_at (updated_at),
        INDEX customer_id (customer_id),
        INDEX customer_location_place (customer_location_place_id),
        INDEX user_id (user_id),
        UNIQUE INDEX customer_id_2 (customer_id,
        customer_location_id,
        customer_location_place_id,
        customer_location_place_asset_id,
        user_id),
        INDEX created_at (created_at),
        INDEX customer_location (customer_location_id),
        PRIMARY KEY(id)
        ) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE user_attachment
        (id INT UNSIGNED AUTO_INCREMENT NOT NULL,
        user_id INT UNSIGNED DEFAULT NULL,
        name VARCHAR(255) NOT NULL,
        type VARCHAR(32) NOT NULL,
        size INT UNSIGNED NOT NULL,
        path VARCHAR(128) NOT NULL,
        filename VARCHAR(128) NOT NULL,
        active tinyint DEFAULT 1 NOT NULL,
        created_at DATETIME NOT NULL DEFAULT current_timestamp(),
        updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        deleted_at DATETIME DEFAULT NULL,
        INDEX stuff_id (user_id),
        INDEX updated_at (updated_at),
        INDEX created_at (created_at),
        INDEX active (active),
        INDEX size (size),
        INDEX type_2 (type),
        INDEX name (name),
        INDEX filename (filename),
        INDEX path (path),
        INDEX type (type),
        PRIMARY KEY(id)
        ) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE user_group
        (id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
        name VARCHAR(32) NOT NULL,
        code VARCHAR(32) NOT NULL,
        PRIMARY KEY(id)
        ) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE user_profile (user_id INT UNSIGNED NOT NULL,
        firstname VARCHAR(255) DEFAULT NULL,
        lastname VARCHAR(64) DEFAULT NULL,
        public_email VARCHAR(255) DEFAULT NULL,
        gravatar_email VARCHAR(255) DEFAULT NULL,
        gravatar_id VARCHAR(32) DEFAULT NULL,
        location VARCHAR(255) DEFAULT NULL,
        website VARCHAR(255) DEFAULT NULL,
        bio TEXT DEFAULT NULL,
        timezone VARCHAR(40) DEFAULT NULL,
        setting LONGTEXT DEFAULT NULL COMMENT \'settings like notifications\',
        PRIMARY KEY(user_id)
        ) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE user_role
        (id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
        name VARCHAR(64) NOT NULL,
        code VARCHAR(64) NOT NULL,
        INDEX name (name),
        UNIQUE INDEX code (code),
        PRIMARY KEY(id)
        ) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE user_role_assigned (user_id INT UNSIGNED NOT NULL,
        role_id SMALLINT UNSIGNED NOT NULL,
        INDEX FK_D95AB405A76ED397 (role_id),
        INDEX IDX_CFC787FBA76ED395 (user_id),
        PRIMARY KEY(user_id, role_id)
        ) DEFAULT COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE user');
        
        $this->addSql('DROP TABLE user_assigned_customer');
        
        $this->addSql('DROP TABLE user_attachment');
        
        $this->addSql('DROP TABLE user_group');
        
        $this->addSql('DROP TABLE user_profile');
        
        $this->addSql('DROP TABLE user_role');
        
        $this->addSql('DROP TABLE user_role_assigned');

    }
}
