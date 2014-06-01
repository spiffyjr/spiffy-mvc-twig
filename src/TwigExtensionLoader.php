<?php

namespace Spiffy\Mvc\Twig;

use Spiffy\Event\Plugin;
use Spiffy\Event\Manager;
use Spiffy\Inject\InjectorUtils;
use Spiffy\Mvc\MvcEvent;

class TwigExtensionLoader implements Plugin
{
    /**
     * @param Manager $events
     * @return void
     */
    public function plug(Manager $events)
    {
        $events->on(MvcEvent::EVENT_BOOTSTRAP, [$this, 'loadExtensions']);
    }

    /**
     * @param MvcEvent $e
     */
    public function loadExtensions(MvcEvent $e)
    {
        $app = $e->getApplication();
        $i = $app->getInjector();
        $config = $i['mvc.twig'];

        /** @var \Twig_Environment $twig */
        $twig = $i->nvoke('twig');

        $extensions = isset($config['extensions']) ? $config['extensions'] : [];
        foreach ($extensions as $name => &$extension) {
            if (empty($extension)) {
                unset($extensions[$name]);
                continue;
            }

            $twig->addExtension(InjectorUtils::get($i, $extension));
        }
    }
}
