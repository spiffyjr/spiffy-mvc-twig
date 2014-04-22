<?php

namespace Spiffy\Mvc\Twig;

use Spiffy\Inject\Injector;
use Spiffy\Inject\ServiceFactory;
use Spiffy\View\Twig\TwigEnvironmentFactory as BaseTwigEnvironmentFactory;

class TwigEnvironmentFactory implements ServiceFactory
{
    /**
     * @param Injector $i
     * @return \Twig_Environment
     */
    public function createService(Injector $i)
    {
        $options = $i['spiffy.mvc.twig'];

        // Reverse loader_path from package load order so that Twig inherits properly.
        $options['loader_paths'] = array_reverse($options['loader_paths']);

        // Extensions are intentionally loaded onBootstrap via the TwigExtensionLoader listener.
        if (isset($options['extensions'])) {
            unset($options['extensions']);
        }

        $factory = new BaseTwigEnvironmentFactory();
        return $factory->createService($options);
    }
}
