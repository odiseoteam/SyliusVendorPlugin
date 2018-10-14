<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusReportPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Odiseo\SyliusReportPlugin\Model\ReportInterface;
use Sylius\Behat\Page\SymfonyPageInterface;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Tests\Odiseo\SyliusReportPlugin\Behat\Page\Admin\Report\CreatePageInterface;
use Tests\Odiseo\SyliusReportPlugin\Behat\Page\Admin\Report\IndexPageInterface;
use Tests\Odiseo\SyliusReportPlugin\Behat\Page\Admin\Report\ShowPageInterface;
use Tests\Odiseo\SyliusReportPlugin\Behat\Page\Admin\Report\UpdatePageInterface;
use Webmozart\Assert\Assert;

final class ManagingReportsContext implements Context
{
    /** @var CurrentPageResolverInterface */
    private $currentPageResolver;

    /** @var NotificationCheckerInterface */
    private $notificationChecker;

    /** @var IndexPageInterface */
    private $indexPage;

    /** @var CreatePageInterface */
    private $createPage;

    /** @var UpdatePageInterface */
    private $updatePage;

    /** @var ShowPageInterface */
    private $showPage;

    /**
     * @param CurrentPageResolverInterface $currentPageResolver
     * @param NotificationCheckerInterface $notificationChecker
     * @param IndexPageInterface $indexPage
     * @param CreatePageInterface $createPage
     * @param UpdatePageInterface $updatePage
     * @param ShowPageInterface $showPage
     */
    public function __construct(
        CurrentPageResolverInterface $currentPageResolver,
        NotificationCheckerInterface $notificationChecker,
        IndexPageInterface $indexPage,
        CreatePageInterface $createPage,
        UpdatePageInterface $updatePage,
        ShowPageInterface $showPage
    ) {
        $this->currentPageResolver = $currentPageResolver;
        $this->notificationChecker = $notificationChecker;
        $this->indexPage = $indexPage;
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
        $this->showPage = $showPage;
    }

    /**
     * @Given I want to add a new report
     * @throws \Sylius\Behat\Page\UnexpectedPageException
     */
    public function iWantToAddNewReport()
    {
        $this->createPage->open(); // This method will send request.
    }

    /**
     * @When I fill the code with :reportCode
     * @param $reportCode
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iFillTheCodeWith($reportCode)
    {
        $this->createPage->fillCode($reportCode);
    }

    /**
     * @When I fill the name with :reportName
     * @When I rename it to :reportName
     * @param $reportName
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iFillTheNameWith($reportName)
    {
        $this->createPage->fillName($reportName);
    }

    /**
     * @When I fill the description with :reportDescription
     * @param $reportDescription
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iFillTheDescriptionWith($reportDescription)
    {
        $this->createPage->fillDescription($reportDescription);
    }

    /**
     * @When I select :reportDataFetcher as data fetcher
     * @param $reportDataFetcher
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iSelectTheDataFetcher($reportDataFetcher)
    {
        $this->createPage->selectDataFetcher($reportDataFetcher);
    }

    /**
     * @When I select :reportStartDate as start date
     * @param $reportStartDate
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iSelectTheStartDate($reportStartDate)
    {
        $this->createPage->selectStartDate(new \DateTime($reportStartDate));
    }

    /**
     * @When I select today as end date
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iSelectTheEndDate()
    {
        $this->createPage->selectEndDate(new \DateTime());
    }

    /**
     * @When I select :reportTimePeriod as time period
     * @param $reportTimePeriod
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iSelectTheTimePeriod($reportTimePeriod)
    {
        $this->createPage->selectTimePeriod($reportTimePeriod);
    }

    /**
     * @When I add it
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iAddIt()
    {
        $this->createPage->create();
    }

    /**
     * @Given /^I want to modify the (report "([^"]+)")/
     * @param ReportInterface $report
     * @throws \Sylius\Behat\Page\UnexpectedPageException
     */
    public function iWantToModifyReport(ReportInterface $report)
    {
        $this->updatePage->open(['id' => $report->getId()]);
    }

    /**
     * @When I save my changes
     */
    public function iSaveMyChanges()
    {
        $this->updatePage->saveChanges();
    }

    /**
     * @When I want to browse reports
     * @throws \Sylius\Behat\Page\UnexpectedPageException
     */
    public function iWantToBrowseReports()
    {
        $this->indexPage->open();
    }

    /**
     * @Then I should see :numberOfReports reports in the list
     * @param $numberOfReports
     */
    public function iShouldSeeReportsInTheList(int $numberOfReports = 1): void
    {
        Assert::same($this->indexPage->countItems(), (int) $numberOfReports);
    }

    /**
     * @When /^I view details of the (report "([^"]+)")/
     * @param ReportInterface $report
     * @throws \Sylius\Behat\Page\UnexpectedPageException
     */
    public function iViewDetailsOfTheReport(ReportInterface $report)
    {
        $this->showPage->open(['id' => $report->getId()]);
    }

    /**
     * @Then I should see the "Show report :reportName" header title
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iShouldSeeTheShowReportHeaderTitle($reportName)
    {
        Assert::contains($this->showPage->getHeaderTitle(), $reportName);
    }

    /**
     * @Then /^the (report "([^"]+)") should appear in the admin/
     * @param ReportInterface $report
     * @throws \Sylius\Behat\Page\UnexpectedPageException
     */
    public function reportShouldAppearInTheAdmin(ReportInterface $report) // This step use Report transformer to get Report object.
    {
        $this->indexPage->open();

        //Webmozart assert library.
        Assert::true(
            $this->indexPage->isSingleResourceOnPage(['code' => $report->getCode()]),
            sprintf('Report %s should exist but it does not', $report->getCode())
        );
    }

    /**
     * @Then I should be notified that the form contains invalid fields
     */
    public function iShouldBeNotifiedThatTheFormContainsInvalidFields(): void
    {
        Assert::true($this->resolveCurrentPage()->containsError(),
            sprintf('The form should be notified you that the form contains invalid field but it does not')
        );
    }

    /**
     * @Then I should be notified that there is already an existing report with provided code
     */
    public function iShouldBeNotifiedThatThereIsAlreadyAnExistingReportWithCode(): void
    {
        Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(
            'There is an existing report with this code.',
            false
        ));
    }

    /**
     * @return IndexPageInterface|CreatePageInterface|UpdatePageInterface|SymfonyPageInterface
     */
    private function resolveCurrentPage(): SymfonyPageInterface
    {
        return $this->currentPageResolver->getCurrentPageWithForm([
            $this->indexPage,
            $this->createPage,
            $this->updatePage,
            $this->showPage,
        ]);
    }
}
