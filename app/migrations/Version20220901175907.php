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
        $this->addSql('INSERT INTO setting VALUES (1, "fedale", "app", "myInt", "1", "int", 1);');
        $this->addSql('INSERT INTO setting VALUES (2, "fedale", "app", "myInt2", "2", "int", 1);');
        $this->addSql('INSERT INTO setting VALUES (3, "fedale", "app", "myInt3", "3", "int", 1);');
        $this->addSql('INSERT INTO setting VALUES (4, "fedale", "app", "myInt4", "4", "int", 1);');
        $this->addSql('INSERT INTO setting VALUES (5, "fedale", "app", "myInt5", "5", "int", 1);');
        $this->addSql('INSERT INTO setting VALUES (6, "fedale", "app", "superAdmin", "1", "bool", 1);');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE setting;');
    }
}
