<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630192436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user_type (
            id SMALLSERIAL NOT NULL,
            name VARCHAR(128) NOT NULL,
            slug VARCHAR(128) NOT NULL,
            PRIMARY KEY (id)
        )');
        $this->addSql('CREATE INDEX ON user_type (name)');
        $this->addSql('CREATE UNIQUE INDEX ON user_type (slug)');

        $this->addSql('CREATE TABLE "user" (
            id SERIAL NOT NULL,
            code VARCHAR(64) NOT NULL,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(60) NOT NULL,
            confirmed_at INT DEFAULT NULL,
            unconfirmed_email VARCHAR(255) DEFAULT NULL,
            blocked_at INT DEFAULT NULL,
            registration_ip VARCHAR(45) DEFAULT NULL,
            type_id SMALLINT DEFAULT 1,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at timestamptz DEFAULT NULL,
            last_login_at timestamptz DEFAULT NULL,
            PRIMARY KEY (id)
        )');
        $this->addSql('CREATE UNIQUE INDEX ON "user" (email)');
        $this->addSql('CREATE UNIQUE INDEX ON "user" (username)');
        $this->addSql('CREATE UNIQUE INDEX ON "user" (code)');
        $this->addSql('CREATE INDEX ON "user" (type_id)');
        $this->addSql('CREATE INDEX ON "user" (active)');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT user_ibfk_1 FOREIGN KEY (type_id) REFERENCES user_type (id) ON DELETE NO ACTION ON UPDATE NO ACTION');
        $this->addSql('CREATE TRIGGER set_updated_at
            BEFORE UPDATE ON "user"
            FOR EACH ROW
            EXECUTE PROCEDURE trigger_set_update();
        ');

        $this->addSql('CREATE TABLE user_customer_assigned (
            id SERIAL NOT NULL,
            user_id INT NOT NULL,
            customer_id INT NOT NULL,
            customer_location_id INT DEFAULT NULL,
            customer_location_place_id INT DEFAULT NULL,
            customer_location_place_asset_id INT DEFAULT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at timestamptz DEFAULT NULL,
            PRIMARY KEY (id)
        )');
        $this->addSql('CREATE INDEX ON user_customer_assigned (customer_location_place_asset_id)');
        $this->addSql('CREATE INDEX ON user_customer_assigned (active)');
        $this->addSql('CREATE INDEX ON user_customer_assigned (updated_at)');
        $this->addSql('CREATE INDEX ON user_customer_assigned (customer_location_place_id)');
        $this->addSql('CREATE INDEX ON user_customer_assigned (user_id)');
        $this->addSql('CREATE UNIQUE INDEX ON user_customer_assigned (
                customer_id,
                customer_location_id,
                customer_location_place_id,
                customer_location_place_asset_id,
                user_id
            )');
        $this->addSql('CREATE INDEX ON user_customer_assigned (created_at)');
        $this->addSql('CREATE INDEX ON user_customer_assigned (customer_location_id)');
        $this->addSql('CREATE TRIGGER set_updated_at
            BEFORE UPDATE ON user_customer_assigned
            FOR EACH ROW
            EXECUTE PROCEDURE trigger_set_update();
        ');
        
        $this->addSql('CREATE TABLE user_attachment (
            id SERIAL NOT NULL,
            user_id INT DEFAULT NULL,
            name VARCHAR(255) NOT NULL,
            type VARCHAR(32) NOT NULL,
            size INT NOT NULL,
            path VARCHAR(128) NOT NULL,
            filename VARCHAR(128) NOT NULL,
            active SMALLINT DEFAULT 1 NOT NULL,
            created_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamptz NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at timestamptz DEFAULT NULL,
            PRIMARY KEY (id)
        )');
        $this->addSql('CREATE INDEX ON user_attachment (user_id)');
        $this->addSql('CREATE INDEX ON user_attachment (updated_at)');
        $this->addSql('CREATE INDEX ON user_attachment (created_at)');
        $this->addSql('CREATE INDEX ON user_attachment (active)');
        $this->addSql('CREATE INDEX ON user_attachment (size)');
        $this->addSql('CREATE INDEX ON user_attachment (type)');
        $this->addSql('CREATE INDEX ON user_attachment (name)');
        $this->addSql('CREATE INDEX ON user_attachment (filename)');
        $this->addSql('CREATE INDEX ON user_attachment (path)');
        $this->addSql('CREATE INDEX ON user_attachment (type)');
        $this->addSql('CREATE TRIGGER set_updated_at
            BEFORE UPDATE ON user_attachment
            FOR EACH ROW
            EXECUTE PROCEDURE trigger_set_update();
        ');
        
        $this->addSql('CREATE TABLE user_group (
            id SMALLSERIAL NOT NULL,
            name VARCHAR(64) NOT NULL,
            slug VARCHAR(64) NOT NULL,
            sort SMALLINT NOT NULL DEFAULT 0,
            PRIMARY KEY (id)
        )');
        $this->addSql('CREATE INDEX ON user_group (name)');
        $this->addSql('CREATE INDEX ON user_group (sort)');
        $this->addSql('CREATE UNIQUE INDEX ON user_group (slug)');

        $this->addSql('CREATE TABLE user_profile (
            id SERIAL NOT NULL,
            user_id INT NOT NULL,
            firstname VARCHAR(255) DEFAULT NULL,
            lastname VARCHAR(64) DEFAULT NULL,
            public_email VARCHAR(255) DEFAULT NULL,
            gravatar_email VARCHAR(255) DEFAULT NULL,
            gravatar_id VARCHAR(32) DEFAULT NULL,
            location VARCHAR(255) DEFAULT NULL,
            website VARCHAR(255) DEFAULT NULL,
            bio TEXT DEFAULT NULL,
            timezone VARCHAR(40) DEFAULT NULL,
            setting TEXT DEFAULT NULL,
            PRIMARY KEY (id)
        )');
        $this->addSql('CREATE UNIQUE INDEX ON user_profile (user_id)');
        $this->addSql('ALTER TABLE user_profile ADD CONSTRAINT user_profile_ibfk_1 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE NO ACTION ON UPDATE NO ACTION');
        
        $this->addSql('CREATE TABLE user_role (
            id SMALLSERIAL NOT NULL,
            name VARCHAR(64) NOT NULL,
            slug VARCHAR(64) NOT NULL,
            code VARCHAR(64) NOT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX ON user_role (name)');
        $this->addSql('CREATE UNIQUE INDEX ON user_role (slug)');
        $this->addSql('CREATE UNIQUE INDEX ON user_role (code)');
        
        $this->addSql('CREATE TABLE user_role_assigned (
            user_id SERIAL NOT NULL,
            user_role_id SMALLINT NOT NULL,
            PRIMARY KEY(user_id, user_role_id)
        )');
        $this->addSql('CREATE INDEX FK_D95AB405A76ED397 ON user_role_assigned (user_role_id)');
        $this->addSql('CREATE INDEX IDX_CFC787FBA76ED395 ON user_role_assigned (user_id)');
        $this->addSql('ALTER TABLE user_role_assigned ADD CONSTRAINT user_role_assigned_ibfk_1 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE NO ACTION ON UPDATE NO ACTION');
        $this->addSql('ALTER TABLE user_role_assigned ADD CONSTRAINT user_role_assigned_ibfk_2 FOREIGN KEY (user_role_id) REFERENCES user_role (id) ON DELETE NO ACTION ON UPDATE NO ACTION');
        
        $this->addSql('CREATE TABLE user_group_assigned (
            id SERIAL NOT NULL,
            user_id INT NOT NULL CHECK (user_id > 0),
            user_group_id SMALLINT NOT NULL CHECK(user_group_id > 0),
            PRIMARY KEY (id)
            )');
        $this->addSql('CREATE INDEX ON user_group_assigned (user_id)');
        $this->addSql('CREATE INDEX ON user_group_assigned (user_group_id)');
        $this->addSql('ALTER TABLE user_group_assigned ADD CONSTRAINT user_group_assigned_ibfk_1 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE NO ACTION ON UPDATE NO ACTION');
        $this->addSql('ALTER TABLE user_group_assigned ADD CONSTRAINT user_group_assigned_ibfk_2 FOREIGN KEY (user_group_id) REFERENCES user_group (id) ON DELETE NO ACTION ON UPDATE NO ACTION');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE user_customer_assigned');
        
        $this->addSql('DROP TABLE user_attachment');
        
        $this->addSql('DROP TABLE user_group_assigned');
        
        $this->addSql('DROP TABLE user_group');
        
        $this->addSql('DROP TABLE user_profile');
        
        $this->addSql('DROP TABLE user_role_assigned');
        
        $this->addSql('DROP TABLE user_role');

        $this->addSql('DROP TABLE "user"');

        $this->addSql('DROP TABLE user_type');
    }
}
