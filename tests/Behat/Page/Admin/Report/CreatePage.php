<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusReportPlugin\Behat\Page\Admin\Report;

use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Tests\Odiseo\SyliusReportPlugin\Behat\Behaviour\ContainsErrorTrait;

class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    use ContainsErrorTrait;

    /**
     * @inheritdoc
     */
    public function fillCode($code)
    {
        $this->getDocument()->fillField('Code', $code);
    }

    /**
     * @inheritdoc
     */
    public function fillName($name)
    {
        $this->getDocument()->fillField('Name', $name);
    }

    /**
     * @inheritdoc
     */
    public function fillDescription($description)
    {
        $this->getDocument()->fillField('Description', $description);
    }

    /**
     * {@inheritdoc}
     */
    public function selectDataFetcher($dataFetcher)
    {
        $this->getElement('data_fetcher')->selectOption($dataFetcher);
    }

    /**
     * {@inheritdoc}
     */
    public function selectStartDate(\DateTime $startDate)
    {
        $this->getElement('day_start_date')->selectOption($startDate->format('j'));
        $this->getElement('month_start_date')->selectOption($startDate->format('M'));
        $this->getElement('year_start_date')->selectOption($startDate->format('Y'));
    }

    /**
     * {@inheritdoc}
     */
    public function selectEndDate(\DateTime $endDate)
    {
        $this->getElement('day_end_date')->selectOption($endDate->format('j'));
        $this->getElement('month_end_date')->selectOption($endDate->format('M'));
        $this->getElement('year_end_date')->selectOption($endDate->format('Y'));
    }

    /**
     * {@inheritdoc}
     */
    public function selectTimePeriod($timePeriod)
    {
        $this->getElement('time_period')->selectOption($timePeriod);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements()
    {
        return array_merge(parent::getDefinedElements(), [
            'data_fetcher' => '#odiseo_sylius_report_dataFetcher',
            'day_start_date' => '#odiseo_sylius_report_dataFetcherConfiguration_start_day',
            'month_start_date' => '#odiseo_sylius_report_dataFetcherConfiguration_start_month',
            'year_start_date' => '#odiseo_sylius_report_dataFetcherConfiguration_start_year',
            'day_end_date' => '#odiseo_sylius_report_dataFetcherConfiguration_end_day',
            'month_end_date' => '#odiseo_sylius_report_dataFetcherConfiguration_end_month',
            'year_end_date' => '#odiseo_sylius_report_dataFetcherConfiguration_end_year',
            'time_period' => '#odiseo_sylius_report_dataFetcherConfiguration_period'
        ]);
    }
}
