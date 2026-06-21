<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Crea la tabella permission_rule per l'entità del bundle
 * fedale/access-control-voter-bundle
 * (Fedale\AccessControlVoterBundle\Bridge\Doctrine\Entity\PermissionRule).
 *
 * Il bundle non spedisce migration: lo schema è ricavato dal mapping
 * dell'entità. Indice composito (active, sort) allineato a
 * PermissionRuleRepository::findActive().
 */
final class Version20260620070000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Crea permission_rule per fedale/access-control-voter-bundle';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE permission_rule (
            id SERIAL NOT NULL,
            name VARCHAR(64) NOT NULL,
            reason VARCHAR(255) DEFAULT NULL,
            attribute VARCHAR(128) NOT NULL,
            subject_type VARCHAR(255) DEFAULT NULL,
            "condition" VARCHAR(255) DEFAULT NULL,
            roles JSON NOT NULL,
            allow BOOLEAN DEFAULT true NOT NULL,
            sort INT DEFAULT 0 NOT NULL,
            active BOOLEAN DEFAULT true NOT NULL,
            created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX idx_permission_rule_active_sort ON permission_rule (active, sort)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE permission_rule');
    }
}
