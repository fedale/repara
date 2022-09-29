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
        $this->addSql('INSERT INTO setting VALUES (1, "fedale", "app", "myName", "Danilo Di Moia DB", "string", 1);');
        $this->addSql('INSERT INTO setting VALUES (2, "fedale", "app", "myInt2", "2", "int", 1);');
        $this->addSql('INSERT INTO setting VALUES (3, "fedale", "app", "myInt3", "3", "int", 1);');
        $this->addSql('INSERT INTO setting VALUES (4, "fedale", "app", "myParam", "My value from database", "string", 1);');
        $this->addSql('INSERT INTO setting VALUES (5, "fedale", "app", "twig.default_path", "/twig/default_path/from/db", "string", 1);');
        $this->addSql('INSERT INTO setting VALUES (6, "fedale", "app", "anonymousAccess", "0", "bool", 1);');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE setting;');
    }
}
