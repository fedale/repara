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
            id SMALLSERIAL NOT NULL,
            name VARCHAR(128) NOT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            PRIMARY KEY (id)
        )');
        $this->addSql('CREATE INDEX ON project_task_type (active)');
        $this->addSql('CREATE INDEX ON project_task_type (created_at)');
        $this->addSql('CREATE INDEX ON project_task_type (updated_at)');
        $this->addSql('CREATE INDEX ON project_task_type (name)');
        
        $this->addSql('CREATE TYPE priority AS ENUM (\'low\', \'normal\', \'high\')');
        $this->addSql('CREATE TABLE project_task (
            id SERIAL NOT NULL,
            customer_id INT DEFAULT NULL CHECK (customer_id > 0),
            project_id INT DEFAULT NULL CHECK (project_id > 0),
            type_id SMALLINT DEFAULT NULL CHECK (type_id > 0),
            customer_location_place_asset_id INT DEFAULT NULL CHECK (customer_location_place_asset_id > 0),
            name VARCHAR(128) NOT NULL,
            description TEXT DEFAULT NULL,
            state state NOT NULL, 
            asset_type VARCHAR(8) DEFAULT \'N/A\' NOT NULL,
            priority priority NOT NULL, 
            visible SMALLINT DEFAULT 1 NOT NULL,
            finished_at TIMESTAMP DEFAULT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            PRIMARY KEY (id),
            CONSTRAINT project_task_ibfk_1 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT project_task_ibfk_2 FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT project_task_ibfk_3 FOREIGN KEY (type_id) REFERENCES project_task_type (id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )');
        $this->addSql('COMMENT ON COLUMN project_task.state IS \'DC2Type::ProjectTaskStateType\'');
        $this->addSql('COMMENT ON COLUMN project_task.asset_type IS \'Update with assetType value\'');
        $this->addSql('COMMENT ON COLUMN project_task.priority IS \'DC2Type::ProjectTaskPriorityType\'');
        $this->addSql('CREATE INDEX ON project_task (state)');
        $this->addSql('CREATE INDEX ON project_task (active)');
        $this->addSql('CREATE INDEX ON project_task (project_id)');
        $this->addSql('CREATE INDEX ON project_task (visible)');
        $this->addSql('CREATE INDEX ON project_task (created_at)');
        $this->addSql('CREATE INDEX ON project_task (customer_id)');
        $this->addSql('CREATE INDEX ON project_task (customer_location_place_asset_id)');
        $this->addSql('CREATE INDEX ON project_task (updated_at)');
        $this->addSql('CREATE INDEX ON project_task (type_id)');
        $this->addSql('CREATE INDEX ON project_task (name)');
        $this->addSql('CREATE INDEX ON project_task (asset_type)');
        $this->addSql('CREATE INDEX ON project_task (priority)');
 
        $this->addSql('CREATE TABLE project_task_activity (
            id SERIAL NOT NULL,
            name VARCHAR(128) NOT NULL,
            timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            user_id INT NOT NULL CHECK (user_id > 0),
            project_task_id INT NOT NULL CHECK (project_task_id > 0),
            PRIMARY KEY (id),
            CONSTRAINT project_task_activity_ibfk_1 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT project_task_activity_ibfk_2 FOREIGN KEY (project_task_id) REFERENCES project_task (id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )');
        $this->addSql('CREATE INDEX ON project_task_activity (name)');
        $this->addSql('CREATE INDEX ON project_task_activity (user_id)');
        $this->addSql('CREATE INDEX ON project_task_activity (project_task_id)');

        $this->addSql('CREATE TABLE project_task_user_assigned (
            id SERIAL NOT NULL,
            user_id INT NOT NULL CHECK (user_id > 0),
            project_task_id INT NOT NULL CHECK (project_task_id > 0),
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            PRIMARY KEY (id),
            CONSTRAINT project_task_user_assigned_ibfk_1 FOREIGN KEY (project_task_id) REFERENCES project_task (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT project_task_user_assigned_ibfk_2 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )');
        $this->addSql('CREATE INDEX ON project_task_user_assigned (created_at)');
        $this->addSql('CREATE INDEX ON project_task_user_assigned (updated_at)');
        $this->addSql('CREATE INDEX ON project_task_user_assigned (project_task_id)');
        $this->addSql('CREATE INDEX ON project_task_user_assigned (active)');
        $this->addSql('CREATE INDEX ON project_task_user_assigned (user_id)');
        
        $this->addSql('CREATE TABLE project_task_attachment (
            id SERIAL NOT NULL,
            user_id INT DEFAULT NULL CHECK (user_id > 0),
            project_task_id INT DEFAULT NULL CHECK (project_task_id > 0),
            name VARCHAR(255) NOT NULL,
            type VARCHAR(32) DEFAULT \'image\' NOT NULL,
            size INT NOT NULL,
            path VARCHAR(128) NOT NULL,
            filename VARCHAR(128) NOT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            PRIMARY KEY (id),
            CONSTRAINT project_task_attachment_ibfk_1 FOREIGN KEY (project_task_id) REFERENCES project_task (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT project_task_attachment_ibfk_2 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )');
        $this->addSql('CREATE INDEX ON project_task_attachment (created_at)');
        $this->addSql('CREATE INDEX ON project_task_attachment (active)');
        $this->addSql('CREATE INDEX ON project_task_attachment (user_id)');
        $this->addSql('CREATE INDEX ON project_task_attachment (type)');
        $this->addSql('CREATE INDEX ON project_task_attachment (size)');
        $this->addSql('CREATE INDEX ON project_task_attachment (name)');
        $this->addSql('CREATE INDEX ON project_task_attachment (filename)');
        $this->addSql('CREATE INDEX ON project_task_attachment (path)');
        $this->addSql('CREATE INDEX ON project_task_attachment (project_task_id)');
        $this->addSql('CREATE INDEX ON project_task_attachment (updated_at)');

        $this->addSql('CREATE TABLE project_task_tag (
            id SERIAL NOT NULL, 
            name VARCHAR(255) NOT NULL, 
            PRIMARY KEY (id)
        )');

        $this->addSql('CREATE TABLE project_task_tag_assigned (
            project_task_id INT NOT NULL CHECK (project_task_id > 0),
            project_task_tag_id INT NOT NULL CHECK (project_task_tag_id > 0),
            PRIMARY KEY (project_task_id, project_task_tag_id),
            CONSTRAINT project_task_tag_assigned_ibfk_1 FOREIGN KEY (project_task_id) REFERENCES project_task (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT project_task_tag_assigned_ibfk_2 FOREIGN KEY (project_task_tag_id) REFERENCES project_task_tag (id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )');
        $this->addSql('CREATE INDEX ON project_task_tag_assigned (project_task_id)');
        $this->addSql('CREATE INDEX ON project_task_tag_assigned (project_task_tag_id)');
            
        $this->addSql('CREATE TABLE project_task_milestone (
            id SERIAL NOT NULL,
            project_milestone_id INT NOT NULL CHECK (project_milestone_id > 0),
            project_task_id INT NOT NULL CHECK (project_task_id > 0),
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            PRIMARY KEY (id),
            CONSTRAINT project_task_milestone_ibfk_1 FOREIGN KEY (project_milestone_id) REFERENCES project_milestone (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT project_task_milestone_ibfk_2 FOREIGN KEY (project_task_id) REFERENCES project_task (id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )');
        $this->addSql('CREATE INDEX ON project_task_milestone (project_task_id)');
        $this->addSql('CREATE INDEX ON project_task_milestone (active)');
        $this->addSql('CREATE INDEX ON project_task_milestone (project_milestone_id)');
            
        $this->addSql('CREATE TABLE project_task_item (
            id SERIAL NOT NULL,
            name VARCHAR(255) NOT NULL,
            description TEXT DEFAULT NULL,
            difficulty SMALLINT NOT NULL,
            value CHAR(1) DEFAULT NULL,
            -- "type" field to add to refer to task item type
            datetime_start TIMESTAMP DEFAULT NULL,
            datetime_end TIMESTAMP DEFAULT NULL,
            project_task_id INT NOT NULL CHECK (project_task_id > 0),
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            PRIMARY KEY (id),
            CONSTRAINT project_task_item_ibfk_1 FOREIGN KEY (project_task_id) REFERENCES project_task (id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )');
        $this->addSql('CREATE INDEX ON project_task_item (difficulty)');
        $this->addSql('CREATE INDEX ON project_task_item (updated_at)');
        $this->addSql('CREATE INDEX ON project_task_item (project_task_id)');
        $this->addSql('CREATE INDEX ON project_task_item (active)');
        $this->addSql('CREATE INDEX ON project_task_item (value)');
        $this->addSql('CREATE INDEX ON project_task_item (datetime_end)');
        $this->addSql('CREATE INDEX ON project_task_item (datetime_start)');
        $this->addSql('CREATE INDEX ON project_task_item (name)');
        $this->addSql('CREATE INDEX ON project_task_item (created_at)');
        
        $this->addSql('CREATE TABLE project_task_item_assigned (
            id SERIAL NOT NULL,
            user_id INT DEFAULT NULL CHECK (user_id > 0),
            project_task_item_id INT DEFAULT NULL CHECK (project_task_item_id > 0),
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            PRIMARY KEY (id),
            CONSTRAINT project_task_item_assigned_ibfk_1 FOREIGN KEY (project_task_item_id) REFERENCES project_task_item (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT project_task_item_assigned_ibfk_2 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )');
        $this->addSql('CREATE INDEX ON project_task_item_assigned (created_at)');
        $this->addSql('CREATE INDEX ON project_task_item_assigned (updated_at)');
        $this->addSql('CREATE INDEX ON project_task_item_assigned (project_task_item_id)');
        $this->addSql('CREATE INDEX ON project_task_item_assigned (active)');
        $this->addSql('CREATE INDEX ON project_task_item_assigned (user_id)');
        
        $this->addSql('CREATE TABLE project_task_template (
            id SERIAL NOT NULL,
            name VARCHAR(128) NOT NULL,
            description TEXT DEFAULT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            PRIMARY KEY (id)
        )');
        $this->addSql('CREATE INDEX ON project_task_template (active)');
        $this->addSql('CREATE INDEX ON project_task_template (created_at)');
        $this->addSql('CREATE INDEX ON project_task_template (updated_at)');
        $this->addSql('CREATE INDEX ON project_task_template (name)');
        
        // check task_id if refers to project_task or to project_task_template (I suppose latter)
        $this->addSql('CREATE TABLE project_task_item_template (
            id SERIAL NOT NULL,
            name VARCHAR(255) NOT NULL,
            task_template_id INT DEFAULT NULL CHECK (task_template_id > 0),
            task_type_id SMALLINT DEFAULT 1 NOT NULL CHECK (task_type_id > 0),
            sort SMALLINT NOT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            PRIMARY KEY (id),
            CONSTRAINT project_task_item_template_ibfk_1 FOREIGN KEY (task_template_id) REFERENCES project_task_template (id) ON DELETE NO ACTION ON UPDATE NO ACTION
            -- CONSTRAINT project_task_item_template_ibfk_2 FOREIGN KEY (task_type_id) REFERENCES project_task_type (id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )');
        $this->addSql('COMMENT ON COLUMN project_task_item_template.task_type_id IS \'Item template type: string, number, widget, select combo\'');
        $this->addSql('CREATE INDEX ON project_task_item_template (created_at)');
        $this->addSql('CREATE INDEX ON project_task_item_template (active)');
        $this->addSql('CREATE INDEX ON project_task_item_template (updated_at)');
        $this->addSql('CREATE INDEX ON project_task_item_template (task_template_id)');
        $this->addSql('CREATE INDEX ON project_task_item_template (sort)');
        $this->addSql('CREATE INDEX ON project_task_item_template (task_type_id)');
        $this->addSql('CREATE INDEX ON project_task_item_template (name)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE project_task_milestone');
        
        $this->addSql('DROP TABLE project_task_activity');
        
        $this->addSql('DROP TABLE project_task_user_assigned');
        
        $this->addSql('DROP TABLE project_task_attachment');
        
        $this->addSql('DROP TABLE project_task_tag_assigned');

        $this->addSql('DROP TABLE project_task_tag');
        
        $this->addSql('DROP TABLE project_task_item_assigned');
        
        $this->addSql('DROP TABLE project_task_item');
        
        $this->addSql('ALTER TABLE project_task drop foreign key project_task_ibfk_1');
        
        $this->addSql('ALTER TABLE project_task drop foreign key project_task_ibfk_2');
        
        $this->addSql('ALTER TABLE project_task drop foreign key project_task_ibfk_3');

        $this->addSql('DROP TABLE project_task_item_template');

        $this->addSql('DROP TABLE project_task_template');

        $this->addSql('DROP TABLE project_task_type');

        $this->addSql('DROP TABLE project_task');

    }
}