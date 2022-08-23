<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220823092248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE customer_group ADD slug VARCHAR(255) NOT NULL AFTER name');
        $this->addSql('ALTER TABLE customer_group ADD sort SMALLINT NOT NULL DEFAULT 0 AFTER slug');
        $this->addSql('UPDATE customer_group SET slug = CONCAT("slug-", id)');
        $this->addSql('ALTER TABLE customer_group ADD UNIQUE KEY slug (slug)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE customer_group DROP KEY slug');
        $this->addSql('ALTER TABLE customer_group DROP slug');
        $this->addSql('ALTER TABLE customer_group DROP sort');
    }
}
