<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Sylius\Bundle\CoreBundle\Doctrine\Migrations\AbstractPostgreSQLMigration;

final class Version20260616120001 extends AbstractPostgreSQLMigration
{
    public function getDescription(): string
    {
        return 'Rename odiseo_vendor.logo_name column to logo_path (PostgreSQL).';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE odiseo_vendor RENAME COLUMN logo_name TO logo_path');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE odiseo_vendor RENAME COLUMN logo_path TO logo_name');
    }
}
