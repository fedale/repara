<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Create the setting table for fedale/setting-bundle.
 */
final class Version20260625076000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create setting table (fedale/setting-bundle)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE setting_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE setting (id INT NOT NULL, tenant_id INT NOT NULL, name VARCHAR(255) NOT NULL, value TEXT NOT NULL, type VARCHAR(20) DEFAULT \'string\' NOT NULL, active BOOLEAN DEFAULT true NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_setting_tenant_active ON setting (tenant_id, active)');
        $this->addSql('CREATE UNIQUE INDEX uniq_setting_tenant_name ON setting (tenant_id, name)');
        $this->addSql('COMMENT ON COLUMN setting.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN setting.updated_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE setting_id_seq CASCADE');
        $this->addSql('DROP TABLE setting');
    }
}
