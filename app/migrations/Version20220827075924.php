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
        $this->addSql('
            CREATE TABLE user_role_hierarchy (
                parent SMALLINT UNSIGNED NOT NULL, 
                child SMALLINT UNSIGNED NOT NULL, 
                INDEX IDX_1799CA265DB75757 (parent), 
                INDEX IDX_1799CA26445207D8 (parent), 
                PRIMARY KEY(parent, child)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        $this->addSql('ALTER TABLE user_role_hierarchy ADD CONSTRAINT FK_1799CA265DB75758 FOREIGN KEY (parent) REFERENCES user_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_role_hierarchy ADD CONSTRAINT FK_1799CA26445207D9 FOREIGN KEY (child) REFERENCES user_role (id) ON DELETE CASCADE');

        $this->addSql('
            CREATE TABLE customer_role_hierarchy (
                parent SMALLINT UNSIGNED NOT NULL, 
                child SMALLINT UNSIGNED NOT NULL, 
                INDEX IDX_1799CA265DB75757 (parent), 
                INDEX IDX_1799CA26445207D8 (parent), 
                PRIMARY KEY(parent, child)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        $this->addSql('ALTER TABLE customer_role_hierarchy ADD CONSTRAINT FK_1799CA265DB75759 FOREIGN KEY (parent) REFERENCES customer_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer_role_hierarchy ADD CONSTRAINT FK_1799CA26445207D0 FOREIGN KEY (child) REFERENCES customer_role (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE customer_role_hierarchy DROP FOREIGN KEY FK_1799CA265DB75759');
        $this->addSql('ALTER TABLE customer_role_hierarchy DROP FOREIGN KEY FK_1799CA26445207D0');
        $this->addSql('DROP TABLE customer_role_hierarchy');

        $this->addSql('ALTER TABLE user_role_hierarchy DROP FOREIGN KEY FK_1799CA265DB75758');
        $this->addSql('ALTER TABLE user_role_hierarchy DROP FOREIGN KEY FK_1799CA26445207D9');
        $this->addSql('DROP TABLE user_role_hierarchy');
    }
}
