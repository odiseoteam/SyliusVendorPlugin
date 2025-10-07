<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusVendorPlugin\Behat\Behaviour;

use Sylius\Behat\Behaviour\DocumentAccessor;

trait ContainsErrorTrait
{
    use DocumentAccessor;

    public function containsError(): bool
    {
        $validationMessageElements = $this->getDocument()->findAll('css', '[data-test-form-error-alert]');

        return count($validationMessageElements) > 0;
    }
}
