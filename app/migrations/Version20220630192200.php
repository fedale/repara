<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630192200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'General stored procedures';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE OR REPLACE FUNCTION trigger_set_update()
            RETURNS TRIGGER AS $$
            BEGIN
            NEW.updated_at = NOW();
            RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ');       
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP FUNCTION trigger_set_update;');
    }
}
