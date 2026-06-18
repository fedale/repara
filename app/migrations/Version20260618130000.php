<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Collega project_milestone a un Project aggiungendo la colonna project_id
 * (FK NOT NULL + indice). La junction project_task_milestone esiste già con le
 * FK corrette, quindi qui non viene toccata.
 *
 * Le righe esistenti di project_milestone / project_task_milestone sono solo
 * dati demo (rigenerati dalle fixtures): vengono eliminate per poter aggiungere
 * la colonna NOT NULL senza backfill.
 */
final class Version20260618130000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Aggiunge project_id a project_milestone (FK verso project)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DELETE FROM project_task_milestone');
        $this->addSql('DELETE FROM project_milestone');
        $this->addSql('ALTER TABLE project_milestone ADD project_id INT NOT NULL');
        $this->addSql('ALTER TABLE project_milestone ADD CONSTRAINT FK_project_milestone_project FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX project_milestone_project_id_idx ON project_milestone (project_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE project_milestone DROP CONSTRAINT FK_project_milestone_project');
        $this->addSql('DROP INDEX project_milestone_project_id_idx');
        $this->addSql('ALTER TABLE project_milestone DROP COLUMN project_id');
    }
}
