<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200622145647 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE bot_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "group_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE data_lake_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE bot (id INT NOT NULL, token VARCHAR(255) NOT NULL, telegram_user_id BIGINT NOT NULL, telegram_bot_id INT NOT NULL, is_enable BOOLEAN NOT NULL, comment TEXT NOT NULL, telegram_origin_webhook_url VARCHAR(255) NOT NULL, telegram_proxy_webhook_url VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_11F0411A0E2F38 ON bot (telegram_bot_id)');
        $this->addSql('CREATE TABLE bot_user (bot_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(bot_id, user_id))');
        $this->addSql('CREATE INDEX IDX_C355A3B92C1C487 ON bot_user (bot_id)');
        $this->addSql('CREATE INDEX IDX_C355A3BA76ED395 ON bot_user (user_id)');
        $this->addSql('CREATE TABLE bot_group (bot_id INT NOT NULL, group_id INT NOT NULL, PRIMARY KEY(bot_id, group_id))');
        $this->addSql('CREATE INDEX IDX_D34AF25992C1C487 ON bot_group (bot_id)');
        $this->addSql('CREATE INDEX IDX_D34AF259FE54D947 ON bot_group (group_id)');
        $this->addSql('CREATE TABLE "group" (id INT NOT NULL, telegram_id BIGINT NOT NULL, title VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6DC044C5CC0B3066 ON "group" (telegram_id)');
        $this->addSql('CREATE TABLE data_lake (id INT NOT NULL, bot_id INT NOT NULL, data JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, hash VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_193FDAE9D1B862B8 ON data_lake (hash)');
        $this->addSql('CREATE INDEX IDX_193FDAE992C1C487 ON data_lake (bot_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, telegram_id INT NOT NULL, is_bot BOOLEAN NOT NULL, first_name VARCHAR(255) DEFAULT NULL, username VARCHAR(255) NOT NULL, last_name VARCHAR(255) DEFAULT NULL, language_code VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649CC0B3066 ON "user" (telegram_id)');
        $this->addSql('ALTER TABLE bot_user ADD CONSTRAINT FK_C355A3B92C1C487 FOREIGN KEY (bot_id) REFERENCES bot (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bot_user ADD CONSTRAINT FK_C355A3BA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bot_group ADD CONSTRAINT FK_D34AF25992C1C487 FOREIGN KEY (bot_id) REFERENCES bot (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bot_group ADD CONSTRAINT FK_D34AF259FE54D947 FOREIGN KEY (group_id) REFERENCES "group" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE data_lake ADD CONSTRAINT FK_193FDAE992C1C487 FOREIGN KEY (bot_id) REFERENCES bot (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE bot_user DROP CONSTRAINT FK_C355A3B92C1C487');
        $this->addSql('ALTER TABLE bot_group DROP CONSTRAINT FK_D34AF25992C1C487');
        $this->addSql('ALTER TABLE data_lake DROP CONSTRAINT FK_193FDAE992C1C487');
        $this->addSql('ALTER TABLE bot_group DROP CONSTRAINT FK_D34AF259FE54D947');
        $this->addSql('ALTER TABLE bot_user DROP CONSTRAINT FK_C355A3BA76ED395');
        $this->addSql('DROP SEQUENCE bot_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "group_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE data_lake_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE bot');
        $this->addSql('DROP TABLE bot_user');
        $this->addSql('DROP TABLE bot_group');
        $this->addSql('DROP TABLE "group"');
        $this->addSql('DROP TABLE data_lake');
        $this->addSql('DROP TABLE "user"');
    }
}
