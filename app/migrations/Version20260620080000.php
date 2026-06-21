<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Riporta project_task_user_assigned a una join table ManyToMany "pura"
 * (solo project_task_id + user_id, PK composita, FK con ON DELETE CASCADE).
 *
 * La tabella era stata promossa a association entity (ProjectTaskUserAssigned,
 * con id/active/timestamp) ma il mapping era incompleto e in conflitto con la
 * ManyToMany su ProjectTask. Scelta la M2M semplice: l'entity e' stata rimossa,
 * qui si allinea lo schema. La tabella era vuota, quindi nessun dato da migrare.
 */
final class Version20260620080000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'project_task_user_assigned torna join table ManyToMany pura';
    }

    public function up(Schema $schema): void
    {
        // CASCADE rimuove anche il DEFAULT su id legato alla sequence.
        $this->addSql('DROP SEQUENCE IF EXISTS project_task_user_assigned_id_seq CASCADE');
        $this->addSql('ALTER TABLE project_task_user_assigned DROP CONSTRAINT project_task_user_assigned_ibfk_1');
        $this->addSql('ALTER TABLE project_task_user_assigned DROP CONSTRAINT project_task_user_assigned_ibfk_2');
        $this->addSql('DROP INDEX project_task_user_assigned_active_idx');
        $this->addSql('DROP INDEX project_task_user_assigned_created_at_idx');
        $this->addSql('DROP INDEX project_task_user_assigned_updated_at_idx');
        $this->addSql('ALTER TABLE project_task_user_assigned DROP CONSTRAINT project_task_user_assigned_pkey');
        $this->addSql('ALTER TABLE project_task_user_assigned DROP id');
        $this->addSql('ALTER TABLE project_task_user_assigned DROP active');
        $this->addSql('ALTER TABLE project_task_user_assigned DROP created_at');
        $this->addSql('ALTER TABLE project_task_user_assigned DROP updated_at');
        $this->addSql('ALTER TABLE project_task_user_assigned DROP deleted_at');
        $this->addSql('ALTER TABLE project_task_user_assigned ADD CONSTRAINT FK_18521BAA1BA80DE3 FOREIGN KEY (project_task_id) REFERENCES project_task (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE project_task_user_assigned ADD CONSTRAINT FK_18521BAAA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE project_task_user_assigned ADD PRIMARY KEY (project_task_id, user_id)');
        $this->addSql('ALTER INDEX project_task_user_assigned_project_task_id_idx RENAME TO IDX_18521BAA1BA80DE3');
        $this->addSql('ALTER INDEX project_task_user_assigned_user_id_idx RENAME TO IDX_18521BAAA76ED395');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER INDEX IDX_18521BAA1BA80DE3 RENAME TO project_task_user_assigned_project_task_id_idx');
        $this->addSql('ALTER INDEX IDX_18521BAAA76ED395 RENAME TO project_task_user_assigned_user_id_idx');
        $this->addSql('ALTER TABLE project_task_user_assigned DROP CONSTRAINT FK_18521BAA1BA80DE3');
        $this->addSql('ALTER TABLE project_task_user_assigned DROP CONSTRAINT FK_18521BAAA76ED395');
        $this->addSql('ALTER TABLE project_task_user_assigned DROP CONSTRAINT project_task_user_assigned_pkey');
        $this->addSql('ALTER TABLE project_task_user_assigned ADD id SERIAL NOT NULL');
        $this->addSql('ALTER TABLE project_task_user_assigned ADD active BOOLEAN DEFAULT true NOT NULL');
        $this->addSql('ALTER TABLE project_task_user_assigned ADD created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE project_task_user_assigned ADD updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE project_task_user_assigned ADD deleted_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE project_task_user_assigned ADD PRIMARY KEY (id)');
        $this->addSql('CREATE INDEX project_task_user_assigned_active_idx ON project_task_user_assigned (active)');
        $this->addSql('CREATE INDEX project_task_user_assigned_created_at_idx ON project_task_user_assigned (created_at)');
        $this->addSql('CREATE INDEX project_task_user_assigned_updated_at_idx ON project_task_user_assigned (updated_at)');
        $this->addSql('ALTER TABLE project_task_user_assigned ADD CONSTRAINT project_task_user_assigned_ibfk_1 FOREIGN KEY (project_task_id) REFERENCES project_task (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE project_task_user_assigned ADD CONSTRAINT project_task_user_assigned_ibfk_2 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
