<?php

namespace Spiffy\Mvc\Twig;

use Spiffy\Package\Feature\ConfigProvider;
use Spiffy\Package\Feature\OptionsProvider;
use Spiffy\Package\Feature\OptionsProviderTrait;

class Package implements ConfigProvider, OptionsProvider
{
    use OptionsProviderTrait;

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/config.php';
    }
}
