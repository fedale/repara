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
            id SMALLSERIAL PRIMARY KEY NOT NULL,
            name VARCHAR(128) NOT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            INDEX active (active),
            INDEX created_at (created_at),
            INDEX updated_at (updated_at),
            INDEX name (name),
            PRIMARY KEY(id)
        ) ENGINE = InnoDB');

        $this->addSql('CREATE TABLE project (
            id SERIAL PRIMARY KEY NOT NULL,
            code VARCHAR(32) NOT NULL,
            name VARCHAR(128) NOT NULL,
            description TEXT DEFAULT NULL,
            datetime_start TIMESTAMP DEFAULT NULL,
            datetime_end TIMESTAMP DEFAULT NULL,
            state enum("requested", "rejected", "approved", "current", "dead", "completed", "on_hold", "signed") NOT NULL COMMENT \'DC2Type::ProjectTaskStateType\', 
            budget NUMERIC(15, 2) DEFAULT NULL,
            color CHAR(6) DEFAULT NULL,
            priority TINYINT(1) NOT NULL,
            type_id SMALLINT NOT NULL,
            visible TINYINT(1) DEFAULT 1 NOT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            finished_at TIMESTAMP DEFAULT NULL,
            INDEX name (name),
            INDEX updated_at (updated_at),
            INDEX color (color),
            INDEX datetime_start (datetime_start),
            INDEX active (active),
            INDEX priority (priority),
            INDEX datetime_end (datetime_end),
            INDEX visible (visible),
            INDEX state (state),
            UNIQUE INDEX code (code),
            INDEX created_at (created_at),
            INDEX budget (budget),
            PRIMARY KEY(id),
            CONSTRAINT `project_type_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `project_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE project_activity (
            id SERIAL PRIMARY KEY NOT NULL,
            name VARCHAR(128) NOT NULL,
            TIMESTAMP DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            user_id INT NOT NULL,
            project_id INT NOT NULL,
            INDEX name (name),
            INDEX user_id (user_id),
            INDEX project_id (project_id),
            PRIMARY KEY(id),
            CONSTRAINT `project_activity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `project_activity_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE = InnoDB');

        $this->addSql('CREATE TABLE project_milestone (
            id SERIAL PRIMARY KEY NOT NULL,
            name VARCHAR(32) NOT NULL,
            expiration_date TIMESTAMP NOT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL,
            INDEX active (active),
            INDEX name (name),
            PRIMARY KEY(id)
        ) ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE project_activity');
      
        $this->addSql('DROP TABLE project_milestone');        
        
        $this->addSql('DROP TABLE project');
     
        $this->addSql('DROP TABLE project_type');
    }
}
