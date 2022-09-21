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
        $this->addSql('CREATE TABLE notification (id INT UNSIGNED AUTO_INCREMENT NOT NULL, notification_entity_id INT UNSIGNED DEFAULT NULL, entity_id INT UNSIGNED DEFAULT NULL COMMENT \'NULL with deleted entities\', message MEDIUMTEXT NOT NULL, status TINYINT(1) DEFAULT 1 NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, deleted_at TIMESTAMP DEFAULT NULL, INDEX created_at (created_at), INDEX updated_at (updated_at), INDEX entity_id (entity_id), INDEX active (status), INDEX entity_type_id (notification_entity_id), PRIMARY KEY(id)) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE notification_entity (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL COMMENT \'post,comment,task,template\', action VARCHAR(16) NOT NULL, subject VARCHAR(128) NOT NULL, template VARCHAR(255) NOT NULL, INDEX subject (subject), INDEX name (name), PRIMARY KEY(id)) ENGINE = InnoDB COMMENT = \'\' ');
        
        $this->addSql('CREATE TABLE notification_item (id INT UNSIGNED AUTO_INCREMENT NOT NULL, notification_id INT UNSIGNED DEFAULT NULL, recipient_id INT UNSIGNED DEFAULT NULL, sender_id INT UNSIGNED NOT NULL, status SMALLINT NOT NULL, INDEX sender_id (sender_id), INDEX recipient_id (recipient_id), INDEX status (status), INDEX notification_id (notification_id), PRIMARY KEY(id)) ENGINE = InnoDB COMMENT = \'\' ');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE notification');
        
        $this->addSql('DROP TABLE notification_entity');
        
        $this->addSql('DROP TABLE notification_item');
    }
}
