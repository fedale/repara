<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630192480 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Tasks tables';
    }

    public function up(Schema $schema): void
    {
        
        $this->addSql('CREATE TABLE project_milestone_task (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            milestone_id INT UNSIGNED NOT NULL,
            task_id INT UNSIGNED NOT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at DATETIME NOT NULL DEFAULT current_timestamp(),
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            deleted_at DATETIME DEFAULT NULL,
            INDEX task_it (task_id),
            INDEX active (active),
            INDEX milestone_it (milestone_id),
            PRIMARY KEY(id
        ) ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE project_task (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            customer_id INT UNSIGNED DEFAULT NULL,
            project_id INT UNSIGNED DEFAULT NULL,
            type_id SMALLINT UNSIGNED DEFAULT NULL,
            customer_location_place_asset_id INT UNSIGNED DEFAULT NULL,
            name VARCHAR(128) NOT NULL,
            description TEXT DEFAULT NULL,
            status VARCHAR(32) NOT NULL,
            asset_type VARCHAR(8) DEFAULT \'N/A\' NOT NULL COMMENT \'Update with assetType value\',
            priority SMALLINT NOT NULL,
            visible SMALLINT DEFAULT 1 NOT NULL,
            finished_at DATETIME DEFAULT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at DATETIME NOT NULL DEFAULT current_timestamp(),
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            deleted_at DATETIME DEFAULT NULL,
            INDEX status (status),
            INDEX active (active),
            INDEX project_id (project_id),
            INDEX visible (visible),
            INDEX created_on (created_at),
            INDEX place_id (customer_id),
            INDEX customer_location_place_asset_id (customer_location_place_asset_id),
            INDEX updated_at (updated_at),
            INDEX type_id (type_id),
            INDEX name (name),
            INDEX stuff_type (asset_type),
            INDEX priority (priority),
            PRIMARY KEY(id
        ) ENGINE = InnoDB');
 
        $this->addSql('CREATE TABLE project_task_activity (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            name VARCHAR(128) NOT NULL,
            datetime DATETIME NOT NULL DEFAULT current_timestamp(),
            user_id INT UNSIGNED NOT NULL,
            project_task_id INT UNSIGNE NOT NULL,
            INDEX name (name),
            INDEX user_id (user_id),
            INDEX project_task_id (project_task_id),
            PRIMARY KEY(id),
            CONSTRAINT `project_task_activity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `project_task_activity_ibfk_2` FOREIGN KEY (`project_task_id`) REFERENCES `project_task` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE = InnoDB');

        $this->addSql('CREATE TABLE project_task_assigned (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            user_id INT UNSIGNED NOT NULL,
            task_id INT UNSIGNED NOT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at DATETIME NOT NULL DEFAULT current_timestamp(),
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            deleted_at DATETIME DEFAULT NULL,
            INDEX created_at (created_at),
            INDEX updated_at (updated_at),
            INDEX task_item_id (task_id),
            INDEX active (active),
            INDEX user_id (user_id),
            PRIMARY KEY(id
        ) ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE project_task_attachment (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            user_id INT UNSIGNED DEFAULT NULL,
            project_task_id INT UNSIGNED DEFAULT NULL,
            name VARCHAR(255) NOT NULL,
            type VARCHAR(32) DEFAULT \'image\' NOT NULL,
            size INT UNSIGNED NOT NULL,
            path VARCHAR(128) NOT NULL,
            filename VARCHAR(128) NOT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at DATETIME NOT NULL DEFAULT current_timestamp(),
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            deleted_at DATETIME DEFAULT NULL,
            INDEX created_at (created_at),
            INDEX active (active),
            INDEX user_id (user_id),
            INDEX type_3 (type),
            INDEX size (size),
            INDEX name (name),
            INDEX filename (filename),
            INDEX path (path),
            INDEX project_task_id (project_task_id),
            INDEX updated_at (updated_at),
            PRIMARY KEY(id
        ) ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE project_task_item (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            name VARCHAR(255) NOT NULL,
            description TEXT DEFAULT NULL,
            difficulty TINYINT(1) NOT NULL,
            value CHAR(1) DEFAULT NULL,
            datetime_start DATETIME DEFAULT NULL,
            datetime_end DATETIME DEFAULT NULL,
            task_id INT UNSIGNED NOT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at DATETIME NOT NULL DEFAULT current_timestamp(),
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            deleted_at DATETIME DEFAULT NULL,
            INDEX difficulty (difficulty),
            INDEX updated_at (updated_at),
            INDEX task_id (task_id),
            INDEX active (active),
            INDEX value (value),
            INDEX datetime_end (datetime_end),
            INDEX datetime_start (datetime_start),
            INDEX name (name),
            INDEX created_at (created_at),
            PRIMARY KEY(id
        ) ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE project_task_item_assigned (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            user_id INT UNSIGNED DEFAULT NULL,
            task_item_id INT UNSIGNED DEFAULT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at DATETIME NOT NULL DEFAULT current_timestamp(),
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            deleted_at DATETIME DEFAULT NULL,
            INDEX created_at (created_at),
            INDEX updated_at (updated_at),
            INDEX task_item_id (task_item_id),
            INDEX active (active),
            INDEX user_id (user_id),
            PRIMARY KEY(id
        ) ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE project_task_template (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            name VARCHAR(128) NOT NULL,
            description MEDIUMTEXT DEFAULT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at DATETIME NOT NULL DEFAULT current_timestamp(),
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            deleted_at DATETIME DEFAULT NULL,
            INDEX active (active),
            INDEX created_at (created_at),
            INDEX updated_at (updated_at),
            INDEX name (name),
            PRIMARY KEY(id
        ) ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE project_task_template_item (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            task_id INT UNSIGNED DEFAULT NULL,
            name VARCHAR(255) NOT NULL,
            task_type_id SMALLINT UNSIGNED DEFAULT 1 NOT NULL,
            sort SMALLINT NOT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at DATETIME NOT NULL DEFAULT current_timestamp(),
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            deleted_at DATETIME DEFAULT NULL,
            INDEX created_at (created_at),
            INDEX active (active),
            INDEX updated_at (updated_at),
            INDEX task_id (task_id),
            INDEX sort (sort),
            INDEX task_type_id (task_type_id),
            INDEX name (name),
            PRIMARY KEY(id
        ) ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE project_task_type (
            id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
            name VARCHAR(128) NOT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at DATETIME NOT NULL DEFAULT current_timestamp(),
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            deleted_at DATETIME DEFAULT NULL,
            INDEX active (active),
            INDEX created_at (created_at),
            INDEX updated_at (updated_at),
            INDEX name (name),
            PRIMARY KEY(id
        ) ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE project_milestone_task');
        
        $this->addSql('DROP TABLE project_task_activity');
        
        $this->addSql('DROP TABLE project_task');
        
        $this->addSql('DROP TABLE project_task_assigned');
        
        $this->addSql('DROP TABLE project_task_attachment');
        
        $this->addSql('DROP TABLE project_task_item');
        
        $this->addSql('DROP TABLE project_task_item_assigned');
        
        $this->addSql('DROP TABLE project_task_template');
        
        $this->addSql('DROP TABLE project_task_template_item');
        
        $this->addSql('DROP TABLE project_task_type');        

    }
}