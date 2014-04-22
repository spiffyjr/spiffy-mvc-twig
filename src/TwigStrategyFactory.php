<?php

namespace Spiffy\Mvc\Twig;

use Spiffy\Inject\Injector;
use Spiffy\Inject\ServiceFactory;
use Spiffy\View\Twig\TwigStrategy;
use Spiffy\View\Twig\TwigStrategyFactory as BaseTwigStrategyFactory;

class TwigStrategyFactory implements ServiceFactory
{
    /**
     * @param Injector $i
     * @return TwigStrategy
     */
    public function createService(Injector $i)
    {
        $twig = $i->nvoke('Twig_Environment');
        $factory = new BaseTwigStrategyFactory();

        return $factory->createService($twig);
    }
}
