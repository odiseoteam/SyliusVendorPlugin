<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250406024705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE odiseo_vendors_channels (vendor_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_C2DB56EDF603EE73 (vendor_id), INDEX IDX_C2DB56ED72F5A1AA (channel_id), PRIMARY KEY(vendor_id, channel_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE odiseo_vendors_channels ADD CONSTRAINT FK_C2DB56EDF603EE73 FOREIGN KEY (vendor_id) REFERENCES odiseo_vendor (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE odiseo_vendors_channels ADD CONSTRAINT FK_C2DB56ED72F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE odiseo_vendor_channels DROP FOREIGN KEY FK_42A3C6D272F5A1AA
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE odiseo_vendor_channels DROP FOREIGN KEY FK_42A3C6D2F603EE73
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE odiseo_vendor_channels
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE odiseo_vendor_channels (channel_id INT NOT NULL, vendor_id INT NOT NULL, INDEX IDX_42A3C6D272F5A1AA (channel_id), INDEX IDX_42A3C6D2F603EE73 (vendor_id), PRIMARY KEY(channel_id, vendor_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE odiseo_vendor_channels ADD CONSTRAINT FK_42A3C6D272F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE odiseo_vendor_channels ADD CONSTRAINT FK_42A3C6D2F603EE73 FOREIGN KEY (vendor_id) REFERENCES odiseo_vendor (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE odiseo_vendors_channels DROP FOREIGN KEY FK_C2DB56EDF603EE73
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE odiseo_vendors_channels DROP FOREIGN KEY FK_C2DB56ED72F5A1AA
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE odiseo_vendors_channels
        SQL);
    }
}
