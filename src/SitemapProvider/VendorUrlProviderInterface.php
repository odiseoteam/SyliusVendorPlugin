<?php

declare(strict_types=1);

namespace Odiseo\SyliusVendorPlugin\SitemapProvider;

use Sylius\Component\Core\Model\ChannelInterface;

interface VendorUrlProviderInterface
{
    /**
     * @param ChannelInterface|null $channel
     * @return iterable
     */
    public function generate(?ChannelInterface $channel): iterable;

    /**
     * @return string
     */
    public function getName(): string;
}
