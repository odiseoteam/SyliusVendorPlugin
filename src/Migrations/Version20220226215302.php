<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220226215302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE sylius_product CHANGE vendor_id vendor_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE sylius_product CHANGE vendor_id vendor_id INT DEFAULT NULL');
    }
}
