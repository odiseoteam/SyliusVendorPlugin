<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Sylius\Bundle\CoreBundle\Doctrine\Migrations\AbstractPostgreSQLMigration;

final class Version20211102135223 extends AbstractPostgreSQLMigration
{
    public function getDescription(): string
    {
        return 'Create vendor tables (PostgreSQL).';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE odiseo_vendor (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, logo_name VARCHAR(255) NOT NULL, enabled BOOLEAN NOT NULL, position INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B506F54F5E237E06 ON odiseo_vendor (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B506F54F989D9B62 ON odiseo_vendor (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B506F54FE7927C74 ON odiseo_vendor (email)');
        $this->addSql('CREATE TABLE odiseo_vendor_email (id SERIAL NOT NULL, vendor_id INT NOT NULL, value VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F58E945BF603EE73 ON odiseo_vendor_email (vendor_id)');
        $this->addSql('CREATE TABLE odiseo_vendor_translation (id SERIAL NOT NULL, translatable_id INT NOT NULL, description TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, locale VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5F5AE1AB2C2AC5D3 ON odiseo_vendor_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX odiseo_vendor_translation_uniq_trans ON odiseo_vendor_translation (translatable_id, locale)');
        $this->addSql('CREATE TABLE odiseo_vendor_channels (channel_id INT NOT NULL, vendor_id INT NOT NULL, PRIMARY KEY(channel_id, vendor_id))');
        $this->addSql('CREATE INDEX IDX_42A3C6D272F5A1AA ON odiseo_vendor_channels (channel_id)');
        $this->addSql('CREATE INDEX IDX_42A3C6D2F603EE73 ON odiseo_vendor_channels (vendor_id)');
        $this->addSql('ALTER TABLE odiseo_vendor_email ADD CONSTRAINT FK_F58E945BF603EE73 FOREIGN KEY (vendor_id) REFERENCES odiseo_vendor (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE odiseo_vendor_translation ADD CONSTRAINT FK_5F5AE1AB2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES odiseo_vendor (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE odiseo_vendor_channels ADD CONSTRAINT FK_42A3C6D272F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE odiseo_vendor_channels ADD CONSTRAINT FK_42A3C6D2F603EE73 FOREIGN KEY (vendor_id) REFERENCES odiseo_vendor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sylius_product ADD vendor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_product ADD CONSTRAINT FK_677B9B74F603EE73 FOREIGN KEY (vendor_id) REFERENCES odiseo_vendor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_677B9B74F603EE73 ON sylius_product (vendor_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE sylius_product DROP CONSTRAINT FK_677B9B74F603EE73');
        $this->addSql('ALTER TABLE odiseo_vendor_email DROP CONSTRAINT FK_F58E945BF603EE73');
        $this->addSql('ALTER TABLE odiseo_vendor_translation DROP CONSTRAINT FK_5F5AE1AB2C2AC5D3');
        $this->addSql('ALTER TABLE odiseo_vendor_channels DROP CONSTRAINT FK_42A3C6D272F5A1AA');
        $this->addSql('ALTER TABLE odiseo_vendor_channels DROP CONSTRAINT FK_42A3C6D2F603EE73');
        $this->addSql('DROP TABLE odiseo_vendor');
        $this->addSql('DROP TABLE odiseo_vendor_email');
        $this->addSql('DROP TABLE odiseo_vendor_translation');
        $this->addSql('DROP TABLE odiseo_vendor_channels');
        $this->addSql('DROP INDEX IDX_677B9B74F603EE73');
        $this->addSql('ALTER TABLE sylius_product DROP vendor_id');
    }
}
