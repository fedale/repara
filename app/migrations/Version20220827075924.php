<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220827075924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adding user roles hierarchy in User and Customer entities';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user_role_hierarchy (
            parent SMALLINT NOT NULL CHECK (parent > 0), 
            child SMALLINT NOT NULL CHECK (child > 0), 
            PRIMARY KEY (parent, child),
            CONSTRAINT FK_1799CA265DB75758 FOREIGN KEY (parent) REFERENCES user_role (id) ON DELETE CASCADE,
            CONSTRAINT FK_1799CA26445207D9 FOREIGN KEY (child) REFERENCES user_role (id) ON DELETE CASCADE
        )');
        $this->addSql('CREATE INDEX ON user_role_hierarchy (parent)');
        $this->addSql('CREATE INDEX ON user_role_hierarchy (child)');
        
        $this->addSql('CREATE TABLE customer_role_hierarchy (
            parent SMALLINT NOT NULL CHECK (parent > 0), 
            child SMALLINT NOT NULL CHECK (child > 0), 
            PRIMARY KEY (parent, child),
            CONSTRAINT FK_1799CA265DB75759 FOREIGN KEY (parent) REFERENCES customer_role (id) ON DELETE CASCADE,
            CONSTRAINT FK_1799CA26445207D0 FOREIGN KEY (child) REFERENCES customer_role (id) ON DELETE CASCADE
        )');
        $this->addSql('CREATE INDEX ON customer_role_hierarchy (parent)');
        $this->addSql('CREATE INDEX ON customer_role_hierarchy (child)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE customer_role_hierarchy DROP CONSTRAINT FK_1799CA265DB75759');
        $this->addSql('ALTER TABLE customer_role_hierarchy DROP CONSTRAINT FK_1799CA26445207D0');
        $this->addSql('DROP TABLE customer_role_hierarchy');

        $this->addSql('ALTER TABLE user_role_hierarchy DROP CONSTRAINT FK_1799CA265DB75758');
        $this->addSql('ALTER TABLE user_role_hierarchy DROP CONSTRAINT FK_1799CA26445207D9');
        $this->addSql('DROP TABLE user_role_hierarchy');
    }
}
