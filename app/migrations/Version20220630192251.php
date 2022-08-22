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
            id INT UNSIGNED AUTO_INCREMENT NOT NULL, 
            name VARCHAR(64) NOT NULL, 
            path VARCHAR(255) NOT NULL, 
            roles VARCHAR(255) DEFAULT NULL, 
            ips VARCHAR(255) DEFAULT NULL, 
            host VARCHAR(255) DEFAULT NULL, 
            methods VARCHAR(255) DEFAULT NULL, 
            allow SMALLINT DEFAULT 1 NOT NULL, 
            sort SMALLINT DEFAULT 0 NOT NULL, 
            active TINYINT(1) DEFAULT 1 NOT NULL, 
            created_at DATETIME NOT NULL DEFAULT current_timestamp(), 
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), 
            INDEX sort (sort),
            INDEX path (path),
            INDEX active (active),
            INDEX host (host),
            INDEX allow (allow),
            INDEX name (name), 
            PRIMARY KEY(id)
        ) ENGINE = InnoDB COMMENT = \'\';
        ');

        $this->addSql('CREATE TABLE website (
            id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL, 
            code VARCHAR(32) NOT NULL, 
            name VARCHAR(32) NOT NULL, 
            default_group_id INT NOT NULL, 
            sort SMALLINT DEFAULT 0 NOT NULL, 
            active tinyint DEFAULT 1 NOT NULL, 
            created_at DATETIME NOT NULL DEFAULT current_timestamp(), 
            updated_at DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), 
            deleted_at DATETIME DEFAULT NULL,
            INDEX active (active),
            INDEX default_group_id (default_group_id),
            INDEX sort (sort), 
            UNIQUE INDEX code (code), 
            PRIMARY KEY(id)
        ) ENGINE = InnoDB COMMENT = \'\' ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE access_control');
                        
        $this->addSql('DROP TABLE website');
    }
}
