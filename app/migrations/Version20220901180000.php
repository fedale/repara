<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220901180000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
      $items = [
        ['Root path', '^/', 'IS_AUTHENTICATED_FULLY',  100],
        ['Authentication', '^/api/authentication', 'PUBLIC ACCESS', 5],
        ['Token refresh', '^/api/token/refresh', 'PUBLIC ACCESS',10],
        ['Docs', '^/api/docs', 'PUBLIC_ACCESS', 15]
      ];
        
      foreach($items as $k => $item) {
        $this->addSql('INSERT INTO access_control (name, path, roles, sort) VALUES (?, ?, ?, ?)', $item);
      }
    }

    public function down(Schema $schema): void
    {
      $this->addSql('TRUNCATE TABLE access_control');
    }
}
