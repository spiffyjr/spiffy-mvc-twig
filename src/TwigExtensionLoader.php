<?php

namespace Spiffy\Mvc\Twig;

use Spiffy\Event\Listener;
use Spiffy\Event\Manager;
use Spiffy\Mvc\MvcEvent;

class TwigExtensionLoader implements Listener
{
    /**
     * @param Manager $events
     * @return void
     */
    public function attach(Manager $events)
    {
        $events->on(MvcEvent::EVENT_BOOTSTRAP, [$this, 'onBootstrap']);
    }

    /**
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $app = $e->getApplication();
        $i = $app->getInjector();
        $config = $i['spiffy.mvc.twig'];

        /** @var \Twig_Environment $twig */
        $twig = $i->nvoke('Twig_Environment');

        $extensions = isset($config['extensions']) ? $config['extensions'] : [];
        foreach ($extensions as $name => &$extension) {
            if (empty($extension)) {
                unset($extensions[$name]);
                continue;
            }

            if (is_string($extension)) {
                $extension = $i->has($extension) ? $i->nvoke($extension) : new $extension();
            }

            $twig->addExtension($extension);
        }
    }
}
