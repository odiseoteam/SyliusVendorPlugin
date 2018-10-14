<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusReportPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Odiseo\SyliusReportPlugin\DataFetcher\DefaultDataFetchers;
use Odiseo\SyliusReportPlugin\Doctrine\ORM\ReportRepositoryInterface;
use Odiseo\SyliusReportPlugin\Model\ReportInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class ReportContext implements Context
{
    /** @var FactoryInterface */
    private $reportFactory;

    /** @var ReportRepositoryInterface */
    private $reportRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        FactoryInterface $reportFactory,
        ReportRepositoryInterface $reportRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->reportFactory = $reportFactory;
        $this->reportRepository = $reportRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $code
     * @Given there is an existing report with :code code
     */
    public function thereIsAReportWithCode(string $code): void
    {
        $report = $this->createReport($code, 'Sales 2018', 'Sales statistics for year 2018');

        $this->saveReport($report);
    }

    /**
     * @Given the store has( also) :firstReportCode and :secondReportCode reports
     */
    public function theStoreHasReports(...$reportsCodes)
    {
        foreach ($reportsCodes as $key => $reportCode) {
            $this->saveReport($this->createReport($reportCode, 'Sales 200'.$key, 'Sales statistics for year 200'.$key));
        }
    }

    /**
     * @param string $code
     * @param string $name
     * @param string $description
     *
     * @return ReportInterface
     */
    private function createReport(string $code, string $name, string $description): ReportInterface
    {
        /** @var ReportInterface $report */
        $report = $this->reportFactory->createNew();

        $report->setCode($code);
        $report->setName($name);
        $report->setDescription($description);
        $report->setDataFetcher(DefaultDataFetchers::PAYMENT_STATE_ORDERS);
        $report->setDataFetcherConfiguration([]);

        return $report;
    }

    /**
     * @param ReportInterface $report
     */
    private function saveReport(ReportInterface $report): void
    {
        $this->reportRepository->add($report);
    }
}
