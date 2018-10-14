<?php

namespace Tests\Odiseo\SyliusReportPlugin\Behat\Page\Admin\Report;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;
use Tests\Odiseo\SyliusReportPlugin\Behat\Behaviour\ContainsErrorInterface;

interface CreatePageInterface extends BaseCreatePageInterface, ContainsErrorInterface
{
    /**
     * @param string $code
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillCode($code);

    /**
     * @param string $name
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillName($name);

    /**
     * @param string $description
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillDescription($description);

    /**
     * @param string $dataFetcher
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function selectDataFetcher($dataFetcher);

    /**
     * @param \DateTime $startDate
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function selectStartDate(\DateTime $startDate);

    /**
     * @param \DateTime $endDate
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function selectEndDate(\DateTime $endDate);

    /**
     * @param string $timePeriod
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function selectTimePeriod($timePeriod);
}
