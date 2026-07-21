<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Sylius\Bundle\CoreBundle\Doctrine\Migrations\AbstractPostgreSQLMigration;

final class Version20250406024706 extends AbstractPostgreSQLMigration
{
    public function getDescription(): string
    {
        return 'Rename odiseo_vendor_channels join table to odiseo_vendors_channels (PostgreSQL).';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE odiseo_vendors_channels (vendor_id INT NOT NULL, channel_id INT NOT NULL, PRIMARY KEY(vendor_id, channel_id))');
        $this->addSql('CREATE INDEX IDX_C2DB56EDF603EE73 ON odiseo_vendors_channels (vendor_id)');
        $this->addSql('CREATE INDEX IDX_C2DB56ED72F5A1AA ON odiseo_vendors_channels (channel_id)');
        $this->addSql('ALTER TABLE odiseo_vendors_channels ADD CONSTRAINT FK_C2DB56EDF603EE73 FOREIGN KEY (vendor_id) REFERENCES odiseo_vendor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE odiseo_vendors_channels ADD CONSTRAINT FK_C2DB56ED72F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE odiseo_vendor_channels DROP CONSTRAINT FK_42A3C6D272F5A1AA');
        $this->addSql('ALTER TABLE odiseo_vendor_channels DROP CONSTRAINT FK_42A3C6D2F603EE73');
        $this->addSql('DROP TABLE odiseo_vendor_channels');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE odiseo_vendor_channels (channel_id INT NOT NULL, vendor_id INT NOT NULL, PRIMARY KEY(channel_id, vendor_id))');
        $this->addSql('CREATE INDEX IDX_42A3C6D272F5A1AA ON odiseo_vendor_channels (channel_id)');
        $this->addSql('CREATE INDEX IDX_42A3C6D2F603EE73 ON odiseo_vendor_channels (vendor_id)');
        $this->addSql('ALTER TABLE odiseo_vendor_channels ADD CONSTRAINT FK_42A3C6D272F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE odiseo_vendor_channels ADD CONSTRAINT FK_42A3C6D2F603EE73 FOREIGN KEY (vendor_id) REFERENCES odiseo_vendor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE odiseo_vendors_channels DROP CONSTRAINT FK_C2DB56EDF603EE73');
        $this->addSql('ALTER TABLE odiseo_vendors_channels DROP CONSTRAINT FK_C2DB56ED72F5A1AA');
        $this->addSql('DROP TABLE odiseo_vendors_channels');
    }
}
