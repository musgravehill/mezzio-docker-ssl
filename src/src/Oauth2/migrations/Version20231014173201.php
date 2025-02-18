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
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE oauth2_auth_code');
        $this->addSql('DROP TABLE oauth2_refresh_token');          
    }
}
