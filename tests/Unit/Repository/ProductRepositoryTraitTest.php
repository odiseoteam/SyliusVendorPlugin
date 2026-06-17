<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Unit\Repository;

use Doctrine\ORM\QueryBuilder;
use Odiseo\SyliusVendorPlugin\Entity\Vendor;
use Odiseo\SyliusVendorPlugin\Repository\ProductRepositoryTrait;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Core\Model\Channel;

final class ProductRepositoryTraitTest extends TestCase
{
    public function testItBuildsAQueryBuilderFilteredByChannelVendorAndLocale(): void
    {
        $queryBuilder = $this->createMock(QueryBuilder::class);
        $queryBuilder->method('distinct')->willReturnSelf();
        $queryBuilder->method('addSelect')->willReturnSelf();
        $queryBuilder->method('innerJoin')->willReturnSelf();
        $queryBuilder->method('andWhere')->willReturnSelf();

        $channel = new Channel();
        $vendor = new Vendor();

        $capturedParameters = [];
        $queryBuilder->method('setParameter')
            ->willReturnCallback(function (string $key, mixed $value) use ($queryBuilder, &$capturedParameters): QueryBuilder {
                $capturedParameters[$key] = $value;

                return $queryBuilder;
            });

        $repository = $this->createRepository($queryBuilder);

        $result = $repository->createShopListByVendorQueryBuilder($channel, $vendor, 'en_US');

        $this->assertSame($queryBuilder, $result);
        $this->assertSame('en_US', $capturedParameters['locale']);
        $this->assertSame($channel, $capturedParameters['channel']);
        $this->assertSame($vendor, $capturedParameters['vendor']);
    }

    private function createRepository(QueryBuilder $queryBuilder): object
    {
        return new class($queryBuilder) {
            use ProductRepositoryTrait;

            public function __construct(private QueryBuilder $queryBuilder)
            {
            }

            public function createQueryBuilder(string $alias, ?string $indexBy = null): QueryBuilder
            {
                return $this->queryBuilder;
            }
        };
    }
}
