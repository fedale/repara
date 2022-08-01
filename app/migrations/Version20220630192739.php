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
        return 'Tasks tables';
    }

    public function up(Schema $schema): void
    {        
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
            PRIMARY KEY(id)
        ) ENGINE = InnoDB');

        $this->addSql('CREATE TABLE project_task (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            customer_id INT UNSIGNED DEFAULT NULL,
            project_id INT UNSIGNED DEFAULT NULL,
            type_id SMALLINT UNSIGNED DEFAULT NULL,
            customer_location_place_asset_id INT UNSIGNED DEFAULT NULL,
            name VARCHAR(128) NOT NULL,
            description TEXT DEFAULT NULL,
            state enum("requested", "rejected", "approved", "current", "dead", "completed", "on_hold", "signed") NOT NULL COMMENT \'DC2Type::ProjectTaskStateType\', 
            asset_type VARCHAR(8) DEFAULT \'N/A\' NOT NULL COMMENT \'Update with assetType value\',
            priority enum("low", "normal", "high") NOT NULL COMMENT \'DC2Type::ProjectTaskPriorityType\', 
            visible SMALLINT DEFAULT 1 NOT NULL,
            finished_at DATETIME DEFAULT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at DATETIME NOT NULL DEFAULT current_timestamp(),
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            deleted_at DATETIME DEFAULT NULL,
            INDEX state (state),
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
            PRIMARY KEY(id),
            CONSTRAINT `project_task_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `project_task_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `project_task_ibfk_3` FOREIGN KEY (`type_id`) REFERENCES `project_task_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE = InnoDB');
 
        $this->addSql('CREATE TABLE project_task_activity (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            name VARCHAR(128) NOT NULL,
            datetime DATETIME NOT NULL DEFAULT current_timestamp(),
            user_id INT UNSIGNED NOT NULL,
            project_task_id INT UNSIGNED NOT NULL,
            INDEX name (name),
            INDEX user_id (user_id),
            INDEX project_task_id (project_task_id),
            PRIMARY KEY(id),
            CONSTRAINT `project_task_activity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `project_task_activity_ibfk_2` FOREIGN KEY (`project_task_id`) REFERENCES `project_task` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE = InnoDB');

        $this->addSql('CREATE TABLE project_task_user_assigned (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            user_id INT UNSIGNED NOT NULL,
            project_task_id INT UNSIGNED NOT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at DATETIME NOT NULL DEFAULT current_timestamp(),
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            deleted_at DATETIME DEFAULT NULL,
            INDEX created_at (created_at),
            INDEX updated_at (updated_at),
            INDEX project_task_id (project_task_id),
            INDEX active (active),
            INDEX user_id (user_id),
            PRIMARY KEY(id),
            CONSTRAINT `project_task_user_assigned_ibfk_1` FOREIGN KEY (`project_task_id`) REFERENCES `project_task` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `project_task_user_assigned_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
            INDEX type (type),
            INDEX size (size),
            INDEX name (name),
            INDEX filename (filename),
            INDEX path (path),
            INDEX project_task_id (project_task_id),
            INDEX updated_at (updated_at),
            PRIMARY KEY(id),
            CONSTRAINT `project_task_attachment_ibfk_1` FOREIGN KEY (`project_task_id`) REFERENCES `project_task` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `project_task_attachment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE = InnoDB');

        $this->addSql('CREATE TABLE project_task_tag (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL, 
            name VARCHAR(255) NOT NULL, 
            PRIMARY KEY(id)
        ) ENGINE = InnoDB');

        $this->addSql('CREATE TABLE project_task_tag_assigned (
            project_task_id INT UNSIGNED NOT NULL, 
            project_task_tag_id INT UNSIGNED NOT NULL, 
            INDEX IDX_87F3F1931BA80DE3 (project_task_id), 
            INDEX IDX_87F3F19349B41039 (project_task_tag_id), 
            PRIMARY KEY(project_task_id, project_task_tag_id),
            CONSTRAINT `project_task_tag_assigned_ibfk_1` FOREIGN KEY (`project_task_id`) REFERENCES `project_task` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `project_task_tag_assigned_ibfk_2` FOREIGN KEY (`project_task_tag_id`) REFERENCES `project_task_tag` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE = InnoDB');

        $this->addSql('CREATE TABLE project_task_milestone (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            project_milestone_id INT UNSIGNED NOT NULL,
            project_task_id INT UNSIGNED NOT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at DATETIME NOT NULL DEFAULT current_timestamp(),
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            deleted_at DATETIME DEFAULT NULL,
            INDEX project_task_it (project_task_id),
            INDEX active (active),
            INDEX project_milestone_it (project_milestone_id),
            PRIMARY KEY(id),
            CONSTRAINT `project_task_milestone_ibfk_1` FOREIGN KEY (`project_milestone_id`) REFERENCES `project_milestone` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `project_task_milestone_ibfk_2` FOREIGN KEY (`project_task_id`) REFERENCES `project_task` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE project_task_item (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            name VARCHAR(255) NOT NULL,
            description TEXT DEFAULT NULL,
            difficulty TINYINT(1) NOT NULL,
            value CHAR(1) DEFAULT NULL,
            -- "type" field to add to refer to task item type
            datetime_start DATETIME DEFAULT NULL,
            datetime_end DATETIME DEFAULT NULL,
            project_task_id INT UNSIGNED NOT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at DATETIME NOT NULL DEFAULT current_timestamp(),
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            deleted_at DATETIME DEFAULT NULL,
            INDEX difficulty (difficulty),
            INDEX updated_at (updated_at),
            INDEX project_task_id (project_task_id),
            INDEX active (active),
            INDEX value (value),
            INDEX datetime_end (datetime_end),
            INDEX datetime_start (datetime_start),
            INDEX name (name),
            INDEX created_at (created_at),
            PRIMARY KEY(id),
            CONSTRAINT `project_task_item_ibfk_1` FOREIGN KEY (`project_task_id`) REFERENCES `project_task` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE project_task_item_assigned (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            user_id INT UNSIGNED DEFAULT NULL,
            project_task_item_id INT UNSIGNED DEFAULT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at DATETIME NOT NULL DEFAULT current_timestamp(),
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            deleted_at DATETIME DEFAULT NULL,
            INDEX created_at (created_at),
            INDEX updated_at (updated_at),
            INDEX project_task_item_id (project_task_item_id),
            INDEX active (active),
            INDEX user_id (user_id),
            PRIMARY KEY(id),
            CONSTRAINT `project_task_item_assigned_ibfk_1` FOREIGN KEY (`project_task_item_id`) REFERENCES `project_task_item` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `project_task_item_assigned_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
            PRIMARY KEY(id)
        ) ENGINE = InnoDB');
        
        // check task_id if refers to project_task or to project_task_template (I suppose latter)
        $this->addSql('CREATE TABLE project_task_item_template (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            name VARCHAR(255) NOT NULL,
            task_template_id INT UNSIGNED DEFAULT NULL,
            type_id SMALLINT UNSIGNED DEFAULT 1 NOT NULL COMMENT \'Item template type: string, number, widget, select combo\',
            sort SMALLINT NOT NULL,
            active tinyint DEFAULT 1 NOT NULL,
            created_at DATETIME NOT NULL DEFAULT current_timestamp(),
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            deleted_at DATETIME DEFAULT NULL,
            INDEX created_at (created_at),
            INDEX active (active),
            INDEX updated_at (updated_at),
            INDEX task_template_id (task_template_id),
            INDEX sort (sort),
            INDEX task_type_id (task_type_id),
            INDEX name (name),
            PRIMARY KEY(id),
            CONSTRAINT `project_task_item_template_ibfk_1` FOREIGN KEY (`task_template_id`) REFERENCES `project_task_template` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            -- CONSTRAINT `project_task_item_template_ibfk_2` FOREIGN KEY (`task_type_id`) REFERENCES `project_task_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE project_task_milestone');
        
        $this->addSql('DROP TABLE project_task_activity');
        
        $this->addSql('DROP TABLE project_task_user_assigned');
        
        $this->addSql('DROP TABLE project_task_attachment');
        
        $this->addSql('DROP TABLE project_task_template');
        
        $this->addSql('DROP TABLE project_task_tag_assigned');

        $this->addSql('DROP TABLE project_task_tag');
        
        $this->addSql('DROP TABLE project_task_item_assigned');
        
        $this->addSql('DROP TABLE project_task_item');
        
        $this->addSql('ALTER TABLE project_task drop foreign key project_task_ibfk_1');
        
        $this->addSql('ALTER TABLE project_task drop foreign key project_task_ibfk_2');
        
        $this->addSql('ALTER TABLE project_task drop foreign key project_task_ibfk_3');

        $this->addSql('DROP TABLE project_task_item_template');

        $this->addSql('DROP TABLE project_task_type');

        $this->addSql('DROP TABLE project_task');

    }
}