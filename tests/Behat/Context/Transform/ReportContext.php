<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusReportPlugin\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Webmozart\Assert\Assert;

final class ReportContext implements Context
{
    /**
     * @var RepositoryInterface
     */
    private $reportRepository;

    /**
     * @param RepositoryInterface $reportRepository
     */
    public function __construct(
        RepositoryInterface $reportRepository
    ) {
        $this->reportRepository = $reportRepository;
    }

    /**
     * @Transform /^report "([^"]+)"$/
     * @Transform /^"([^"]+)" report$/
     */
    public function getReportByCode($reportCode)
    {
        $report = $this->reportRepository->findOneBy(['code' => $reportCode]);

        Assert::notNull(
            $report,
            'Report with code %s does not exist'
        );

        return $report;
    }
}
