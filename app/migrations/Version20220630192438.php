<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630192438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Notification table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE notification (
            id SERIAL NOT NULL, 
            notification_entity_id INT DEFAULT NULL CHECK (notification_entity_id > 0), 
            entity_id INT DEFAULT NULL CHECK (entity_id > 0), 
            message TEXT NOT NULL, 
            status SMALLINT DEFAULT 1 NOT NULL, 
            created_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP, 
            updated_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP, 
            deleted_at timestamptz DEFAULT NULL, 
            PRIMARY KEY (id)
        )');
        $this->addSql('COMMENT ON COLUMN notification.entity_id IS  \'NULL with deleted entities\''); 
        $this->addSql('CREATE INDEX ON notification (created_at)'); 
        $this->addSql('CREATE INDEX ON notification (updated_at)');
        $this->addSql('CREATE INDEX ON notification (entity_id)');
        $this->addSql('CREATE INDEX ON notification (status)');
        $this->addSql('CREATE INDEX ON notification (notification_entity_id)');
        $this->addSql('CREATE TRIGGER set_updated_at
            BEFORE UPDATE ON notification
            FOR EACH ROW
            EXECUTE PROCEDURE trigger_set_update();
        ');
        
        $this->addSql('CREATE TABLE notification_entity (
            id SERIAL NOT NULL, 
            name VARCHAR(64) NOT NULL, 
            action VARCHAR(16) NOT NULL, 
            subject VARCHAR(128) NOT NULL, 
            template VARCHAR(255) NOT NULL, 
            PRIMARY KEY (id) 
        )');
        $this->addSql('COMMENT ON COLUMN notification_entity.name IS  \'post,comment,task,template\''); 
        $this->addSql('CREATE INDEX ON notification_entity (subject)');
        $this->addSql('CREATE INDEX ON notification_entity (name)');
        $this->addSql('CREATE INDEX ON notification_entity (action)');
        
        $this->addSql('CREATE TABLE notification_item (
            id SERIAL NOT NULL, 
            notification_id INT DEFAULT NULL CHECK (notification_id > 0), 
            recipient_id INT DEFAULT NULL CHECK (recipient_id > 0), 
            sender_id INT NOT NULL CHECK (sender_id > 0), 
            status SMALLINT NOT NULL,
            PRIMARY KEY (id)
        )');
        $this->addSql('CREATE INDEX ON notification_item (sender_id)');
        $this->addSql('CREATE INDEX ON notification_item (recipient_id)');
        $this->addSql('CREATE INDEX ON notification_item (status)');
        $this->addSql('CREATE INDEX ON notification_item (notification_id)');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE notification');
        
        $this->addSql('DROP TABLE notification_entity');
        
        $this->addSql('DROP TABLE notification_item');
    }
}