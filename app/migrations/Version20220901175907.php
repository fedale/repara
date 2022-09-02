<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220901175907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        return;
        // this up() migration is auto-generated, please modify it to your needs
        
        $this->addSql('INSERT INTO setting VALUES (1, "general", "myInt", "1", 1);');
        $this->addSql('INSERT INTO setting VALUES (2, "general", "myInt2", "2", 1);');
        $this->addSql('INSERT INTO setting VALUES (3, "general", "myInt3", "3", 1);');
        $this->addSql('INSERT INTO setting VALUES (4, "general", "myInt4", "4", 1);');
        $this->addSql('INSERT INTO setting VALUES (5, "general", "myInt5", "5", 1);');
        $this->addSql('INSERT INTO setting VALUES (6, "general", "superAdmin", "Danilo Di Moia", 1);');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE setting;');
    }
}
