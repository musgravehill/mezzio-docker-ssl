<?php

declare(strict_types=1);

namespace Oauth2\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231014173201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oauth2_auth_code (identifier VARCHAR(80) NOT NULL, expiryDateTime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, userIdentifier UUID NOT NULL, PRIMARY KEY(identifier))');
        $this->addSql('COMMENT ON COLUMN oauth2_auth_code.expiryDateTime IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN oauth2_auth_code.userIdentifier IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE oauth2_refresh_token (identifier VARCHAR(80) NOT NULL, expiryDateTime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, userIdentifier UUID NOT NULL, PRIMARY KEY(identifier))');
        $this->addSql('COMMENT ON COLUMN oauth2_refresh_token.expiryDateTime IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN oauth2_refresh_token.userIdentifier IS \'(DC2Type:uuid)\'');
        $this->addSql('DROP INDEX idx_1dd399507b00651c');
        $this->addSql('ALTER TABLE news ALTER text TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE news ALTER created_date TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE news ALTER status SET NOT NULL');
        $this->addSql('COMMENT ON COLUMN news.created_date IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE oauth2_auth_code');
        $this->addSql('DROP TABLE oauth2_refresh_token');
        $this->addSql('ALTER TABLE news ALTER text TYPE TEXT');
        $this->addSql('ALTER TABLE news ALTER status DROP NOT NULL');
        $this->addSql('ALTER TABLE news ALTER created_date TYPE TEXT');
        $this->addSql('COMMENT ON COLUMN news.created_date IS NULL');
        $this->addSql('CREATE INDEX idx_1dd399507b00651c ON news (status)');
    }
}
