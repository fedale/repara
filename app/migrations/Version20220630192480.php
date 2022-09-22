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
        return 'Project tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE project_type (
            id SMALLSERIAL NOT NULL,
            name VARCHAR(128) NOT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at timestamptz DEFAULT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX ON project_type (active)');
        $this->addSql('CREATE INDEX ON project_type (created_at)');
        $this->addSql('CREATE INDEX ON project_type (updated_at)');
        $this->addSql('CREATE INDEX ON project_type (name)');
        $this->addSql('CREATE TRIGGER set_updated_at
            BEFORE UPDATE ON project_type
            FOR EACH ROW
            EXECUTE PROCEDURE trigger_set_update();
        ');

        $this->addSql('CREATE TYPE state AS ENUM (\'requested\', \'rejected\', \'approved\', \'current\', \'dead\', \'completed\', \'on_hold\', \'signed\')');
        $this->addSql('CREATE TABLE project (
            id SERIAL NOT NULL,
            code VARCHAR(32) NOT NULL,
            name VARCHAR(128) NOT NULL,
            description TEXT DEFAULT NULL,
            datetime_start TIMESTAMP DEFAULT NULL,
            datetime_end TIMESTAMP DEFAULT NULL,
            state state NOT NULL, 
            budget NUMERIC(15, 2) DEFAULT NULL,
            color CHAR(6) DEFAULT NULL,
            priority SMALLINT NOT NULL,
            type_id SMALLINT NOT NULL CHECK (type_id > 0),
            visible SMALLINT DEFAULT 1 NOT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at timestamptz DEFAULT NULL,
            finished_at timestamptz DEFAULT NULL,
            PRIMARY KEY(id),
            CONSTRAINT project_type_ibfk_1 FOREIGN KEY (type_id) REFERENCES project_type (id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )');
        $this->addSql('COMMENT ON COLUMN project.state IS \'DC2Type::ProjectTaskStateType\'');
        $this->addSql('CREATE INDEX ON project (name)');
        $this->addSql('CREATE INDEX ON project (updated_at)');
        $this->addSql('CREATE INDEX ON project (color)');
        $this->addSql('CREATE INDEX ON project (datetime_start)');
        $this->addSql('CREATE INDEX ON project (active)');
        $this->addSql('CREATE INDEX ON project (priority)');
        $this->addSql('CREATE INDEX ON project (datetime_end)');
        $this->addSql('CREATE INDEX ON project (visible)');
        $this->addSql('CREATE INDEX ON project (state)');
        $this->addSql('CREATE INDEX ON project (created_at)');
        $this->addSql('CREATE INDEX ON project (budget)');
        $this->addSql('CREATE UNIQUE INDEX ON project (code)');
        $this->addSql('CREATE TRIGGER set_updated_at
            BEFORE UPDATE ON project
            FOR EACH ROW
            EXECUTE PROCEDURE trigger_set_update();
        ');

        $this->addSql('CREATE TABLE project_activity (
            id SERIAL NOT NULL,
            name VARCHAR(128) NOT NULL,
            timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            user_id INT NOT NULL CHECK (user_id > 0),
            project_id INT NOT NULL CHECK (project_id > 0),
            PRIMARY KEY(id),
            CONSTRAINT project_activity_ibfk_1 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT project_activity_ibfk_2 FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )');
        $this->addSql('CREATE INDEX ON project_activity (name)');
        $this->addSql('CREATE INDEX ON project_activity (user_id)');
        $this->addSql('CREATE INDEX ON project_activity (project_id)');

        $this->addSql('CREATE TABLE project_milestone (
            id SERIAL NOT NULL,
            name VARCHAR(32) NOT NULL,
            expiration_date TIMESTAMP NOT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at timestamptz DEFAULT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX ON project_milestone (active)');
        $this->addSql('CREATE INDEX ON project_milestone (name)');
        $this->addSql('CREATE TRIGGER set_updated_at
            BEFORE UPDATE ON project_milestone
            FOR EACH ROW
            EXECUTE PROCEDURE trigger_set_update();
        ');
    }

    public function down(Schema $schema): void
    {
        
     
        $this->addSql('DROP TABLE project_activity');
      
        $this->addSql('DROP TABLE project_milestone');        
        
        $this->addSql('DROP TABLE project');
     
        $this->addSql('DROP TABLE project_type');

        $this->addSql('DROP TYPE state');
    }
}
