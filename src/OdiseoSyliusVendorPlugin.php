<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class OdiseoSyliusVendorPlugin extends Bundle
{
    use SyliusPluginTrait;
}
