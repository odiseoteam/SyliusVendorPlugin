<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Sylius\Bundle\CoreBundle\Doctrine\Migrations\AbstractMigration;

final class Version20260616120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename odiseo_vendor.logo_name column to logo_path (MySQL).';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE odiseo_vendor CHANGE logo_name logo_path VARCHAR(255) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE odiseo_vendor CHANGE logo_path logo_name VARCHAR(255) NOT NULL
        SQL);
    }
}
