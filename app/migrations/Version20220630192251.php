<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630192251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'General tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE access_control (
            id SMALLSERIAL PRIMARY KEY NOT NULL, 
            name VARCHAR(64) NOT NULL, 
            path VARCHAR(255) NOT NULL, 
            roles VARCHAR(255) DEFAULT NULL, 
            ips VARCHAR(255) DEFAULT NULL, 
            host VARCHAR(255) DEFAULT NULL, 
            methods VARCHAR(255) DEFAULT NULL, 
            allow SMALLINT DEFAULT 1 NOT NULL, 
            sort SMALLINT DEFAULT 0 NOT NULL, 
            active BOOLEAN DEFAULT TRUE NOT NULL, 
            created_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP, 
            updated_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP
            )
        ');
        $this->addSql('CREATE TRIGGER set_updated_at
            BEFORE UPDATE ON access_control
            FOR EACH ROW
            EXECUTE PROCEDURE trigger_set_update();
        ');
            
        $this->addSql('CREATE INDEX ON access_control (sort)');
        $this->addSql('CREATE INDEX ON access_control (path)');
        $this->addSql('CREATE INDEX ON access_control (active)');
        $this->addSql('CREATE INDEX ON access_control (host)');
        $this->addSql('CREATE INDEX ON access_control (allow)');
        $this->addSql('CREATE INDEX ON access_control (name)');

        $this->addSql('CREATE TABLE website (
            id SMALLSERIAL PRIMARY KEY NOT NULL, 
            code VARCHAR(32) NOT NULL, 
            name VARCHAR(32) NOT NULL, 
            default_group_id SMALLINT NOT NULL, 
            sort SMALLINT DEFAULT 0 NOT NULL, 
            active BOOLEAN DEFAULT TRUE NOT NULL, 
            created_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP, 
            updated_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP, 
            deleted_at timestamptz DEFAULT NULL
        )');
        $this->addSql('CREATE TRIGGER set_updated_at
            BEFORE UPDATE ON website
            FOR EACH ROW
            EXECUTE PROCEDURE trigger_set_update();
        ');
            
        $this->addSql('CREATE INDEX ON website (active)');
        $this->addSql('CREATE INDEX ON website (default_group_id)');
        $this->addSql('CREATE INDEX ON website (sort)');
        $this->addSql('CREATE UNIQUE INDEX ON website (code)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE access_control');                        
        $this->addSql('DROP TABLE website');
    }
}