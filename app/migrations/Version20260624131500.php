<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * fedale/rbac-bundle: introduces the 4 RBAC tables (auth_rule / auth_item /
 * auth_item_child / auth_assignment) and drops the old permission_rule table
 * from the former access-control-voter-bundle.
 *
 * Surgical migration: touches ONLY the bundle's tables. Any drift on other demo
 * tables must be handled separately.
 */
final class Version20260624131500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'RBAC: create auth_rule/auth_item/auth_item_child/auth_assignment, drop permission_rule';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE auth_rule (name VARCHAR(64) NOT NULL, service_id VARCHAR(255) DEFAULT NULL, expression TEXT DEFAULT NULL, data JSON DEFAULT \'[]\' NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(name))');
        $this->addSql('COMMENT ON COLUMN auth_rule.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_rule.updated_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('CREATE TABLE auth_item (name VARCHAR(64) NOT NULL, rule_name VARCHAR(64) DEFAULT NULL, type VARCHAR(32) NOT NULL, description TEXT DEFAULT NULL, data JSON DEFAULT \'[]\' NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(name))');
        $this->addSql('CREATE INDEX IDX_313DC5AADE72171 ON auth_item (rule_name)');
        $this->addSql('CREATE INDEX idx_auth_item_type ON auth_item (type)');
        $this->addSql('COMMENT ON COLUMN auth_item.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_item.updated_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('CREATE TABLE auth_item_child (parent VARCHAR(64) NOT NULL, child VARCHAR(64) NOT NULL, PRIMARY KEY(parent, child))');
        $this->addSql('CREATE INDEX IDX_1611424D3D8E604F ON auth_item_child (parent)');
        $this->addSql('CREATE INDEX IDX_1611424D22B35429 ON auth_item_child (child)');

        $this->addSql('CREATE TABLE auth_assignment (user_id VARCHAR(255) NOT NULL, item_name VARCHAR(64) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(item_name, user_id))');
        $this->addSql('CREATE INDEX IDX_2EC0490E96133AFD ON auth_assignment (item_name)');
        $this->addSql('CREATE INDEX idx_auth_assignment_user ON auth_assignment (user_id)');
        $this->addSql('COMMENT ON COLUMN auth_assignment.created_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('ALTER TABLE auth_item ADD CONSTRAINT FK_313DC5AADE72171 FOREIGN KEY (rule_name) REFERENCES auth_rule (name) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE auth_item_child ADD CONSTRAINT FK_1611424D3D8E604F FOREIGN KEY (parent) REFERENCES auth_item (name) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE auth_item_child ADD CONSTRAINT FK_1611424D22B35429 FOREIGN KEY (child) REFERENCES auth_item (name) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE auth_assignment ADD CONSTRAINT FK_2EC0490E96133AFD FOREIGN KEY (item_name) REFERENCES auth_item (name) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('DROP SEQUENCE IF EXISTS permission_rule_id_seq CASCADE');
        $this->addSql('DROP TABLE IF EXISTS permission_rule');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE auth_assignment DROP CONSTRAINT FK_2EC0490E96133AFD');
        $this->addSql('ALTER TABLE auth_item DROP CONSTRAINT FK_313DC5AADE72171');
        $this->addSql('ALTER TABLE auth_item_child DROP CONSTRAINT FK_1611424D3D8E604F');
        $this->addSql('ALTER TABLE auth_item_child DROP CONSTRAINT FK_1611424D22B35429');
        $this->addSql('DROP TABLE auth_assignment');
        $this->addSql('DROP TABLE auth_item');
        $this->addSql('DROP TABLE auth_item_child');
        $this->addSql('DROP TABLE auth_rule');

        $this->addSql('CREATE SEQUENCE permission_rule_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE permission_rule (id SERIAL NOT NULL, name VARCHAR(64) NOT NULL, reason VARCHAR(255) DEFAULT NULL, attribute VARCHAR(128) NOT NULL, subject_type VARCHAR(255) DEFAULT NULL, condition VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, allow BOOLEAN DEFAULT true NOT NULL, sort INT DEFAULT 0 NOT NULL, active BOOLEAN DEFAULT true NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_permission_rule_active_sort ON permission_rule (active, sort)');
    }
}
