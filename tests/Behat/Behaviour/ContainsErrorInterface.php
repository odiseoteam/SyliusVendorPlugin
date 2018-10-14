<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusReportPlugin\Behat\Behaviour;

interface ContainsErrorInterface
{
    /**
     * @return bool
     */
    public function containsError(): bool;

    /**
     * @param string $message
     * @param bool $strict
     * @return bool
     */
    public function containsErrorWithMessage(string $message, bool $strict = true): bool;
}
