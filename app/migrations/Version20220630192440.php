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
        return 'Project tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE project (id INT UNSIGNED AUTO_INCREMENT NOT NULL, code VARCHAR(32) NOT NULL, name VARCHAR(128) NOT NULL, description TEXT DEFAULT NULL, datetime_start DATETIME DEFAULT NULL, datetime_end DATETIME DEFAULT NULL, status VARCHAR(32) DEFAULT \'\'\'0\'\'\' NOT NULL, budget NUMERIC(15, 2) DEFAULT NULL, color CHAR(6) DEFAULT NULL, priority TINYINT(1) NOT NULL, visible TINYINT(1) DEFAULT 1 NOT NULL, created_by INT UNSIGNED NOT NULL, active tinyint DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL DEFAULT current_timestamp(), updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), deleted_at DATETIME DEFAULT NULL, finished_at DATETIME DEFAULT NULL, INDEX name (name), INDEX updated_at (updated_at), INDEX color (color), INDEX datetime_start (datetime_start), INDEX active (active), INDEX priority (priority), INDEX datetime_end (datetime_end), INDEX visible (visible), INDEX created_by (created_by), INDEX status (status), UNIQUE INDEX code (code), INDEX created_at (created_at), INDEX budget (budget), PRIMARY KEY(id)) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE project_milestone (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(32) NOT NULL, expiration_date DATETIME NOT NULL, active tinyint DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL DEFAULT current_timestamp(), updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), deleted_at DATETIME DEFAULT NULL, INDEX active (active), INDEX name (name), PRIMARY KEY(id)) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE project_milestone_task (id INT UNSIGNED AUTO_INCREMENT NOT NULL, milestone_id INT UNSIGNED NOT NULL, task_id INT UNSIGNED NOT NULL, active tinyint DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL DEFAULT current_timestamp(), updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), deleted_at DATETIME DEFAULT NULL, INDEX task_it (task_id), INDEX active (active), INDEX milestone_it (milestone_id), PRIMARY KEY(id)) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE project_task (id INT UNSIGNED AUTO_INCREMENT NOT NULL, customer_id INT UNSIGNED DEFAULT NULL, project_id INT UNSIGNED DEFAULT NULL, type_id SMALLINT UNSIGNED DEFAULT NULL, customer_location_place_asset_id INT UNSIGNED DEFAULT NULL, name VARCHAR(128) NOT NULL, description TEXT DEFAULT NULL, status VARCHAR(32) NOT NULL, asset_type VARCHAR(8) DEFAULT \'N/A\' NOT NULL COMMENT \'Update with assetType value\', priority SMALLINT NOT NULL, visible SMALLINT DEFAULT 1 NOT NULL, created_by INT NOT NULL, finished_at DATETIME DEFAULT NULL, active tinyint DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL DEFAULT current_timestamp(), updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), deleted_at DATETIME DEFAULT NULL, INDEX status (status), INDEX active (active), INDEX created_by (created_by), INDEX project_id (project_id), INDEX visible (visible), INDEX created_on (created_at), INDEX place_id (customer_id), INDEX customer_location_place_asset_id (customer_location_place_asset_id), INDEX updated_at (updated_at), INDEX type_id (type_id), INDEX name (name), INDEX stuff_type (asset_type), INDEX priority (priority), PRIMARY KEY(id)) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE project_task_assigned (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT UNSIGNED NOT NULL, task_id INT UNSIGNED NOT NULL, active tinyint DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL DEFAULT current_timestamp(), updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), deleted_at DATETIME DEFAULT NULL, INDEX created_at (created_at), INDEX updated_at (updated_at), INDEX task_item_id (task_id), INDEX active (active), INDEX user_id (user_id), PRIMARY KEY(id)) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE project_task_attachment (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT UNSIGNED DEFAULT NULL, project_task_id INT UNSIGNED DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(32) DEFAULT \'image\' NOT NULL, size INT UNSIGNED NOT NULL, path VARCHAR(128) NOT NULL, filename VARCHAR(128) NOT NULL, active tinyint DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL DEFAULT current_timestamp(), updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), deleted_at DATETIME DEFAULT NULL, INDEX created_at (created_at), INDEX active (active), INDEX user_id (user_id), INDEX type_3 (type), INDEX size (size), INDEX name (name), INDEX filename (filename), INDEX path (path), INDEX project_task_id (project_task_id), INDEX updated_at (updated_at), PRIMARY KEY(id)) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE project_task_item (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, difficulty TINYINT(1) NOT NULL, value CHAR(1) DEFAULT NULL, datetime_start DATETIME DEFAULT NULL, datetime_end DATETIME DEFAULT NULL, task_id INT UNSIGNED NOT NULL, active tinyint DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL DEFAULT current_timestamp(), updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), deleted_at DATETIME DEFAULT NULL, INDEX difficulty (difficulty), INDEX updated_at (updated_at), INDEX task_id (task_id), INDEX active (active), INDEX value (value), INDEX datetime_end (datetime_end), INDEX datetime_start (datetime_start), INDEX name (name), INDEX created_at (created_at), PRIMARY KEY(id)) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE project_task_item_assigned (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT UNSIGNED DEFAULT NULL, task_item_id INT UNSIGNED DEFAULT NULL, active tinyint DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL DEFAULT current_timestamp(), updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), deleted_at DATETIME DEFAULT NULL, INDEX created_at (created_at), INDEX updated_at (updated_at), INDEX task_item_id (task_item_id), INDEX active (active), INDEX user_id (user_id), PRIMARY KEY(id)) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE project_task_template (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, description MEDIUMTEXT DEFAULT NULL, active tinyint DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL DEFAULT current_timestamp(), updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), deleted_at DATETIME DEFAULT NULL, INDEX active (active), INDEX created_at (created_at), INDEX updated_at (updated_at), INDEX name (name), PRIMARY KEY(id)) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE project_task_template_item (id INT UNSIGNED AUTO_INCREMENT NOT NULL, task_id INT UNSIGNED DEFAULT NULL, name VARCHAR(255) NOT NULL, task_type_id SMALLINT UNSIGNED DEFAULT 1 NOT NULL, sort SMALLINT NOT NULL, active tinyint DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL DEFAULT current_timestamp(), updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), deleted_at DATETIME DEFAULT NULL, INDEX created_at (created_at), INDEX active (active), INDEX updated_at (updated_at), INDEX task_id (task_id), INDEX sort (sort), INDEX task_type_id (task_type_id), INDEX name (name), PRIMARY KEY(id)) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE project_task_type (id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, active tinyint DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL DEFAULT current_timestamp(), updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), deleted_at DATETIME DEFAULT NULL, INDEX active (active), INDEX created_at (created_at), INDEX updated_at (updated_at), INDEX name (name), PRIMARY KEY(id)) ENGINE = InnoDB COMMENT = \'\' ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE project');
        
        $this->addSql('DROP TABLE project_milestone');
        
        $this->addSql('DROP TABLE project_milestone_task');
        
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
