<?php

namespace Spiffy\Mvc\Twig;

use Spiffy\Event\EventManager;
use Spiffy\Inject\Injector;
use Spiffy\Mvc\Application;
use Spiffy\Mvc\MvcEvent;

/**
 * @coversDefaultClass \Spiffy\Mvc\Twig\TwigExtensionLoader
 */
class TwigExtensionLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MvcEvent
     */
    protected $e;

    /**
     * @var TwigExtensionLoader
     */
    protected $l;

    /**
     * @covers ::attach
     */
    public function testAttach()
    {
        $em = new EventManager();

        $l = $this->l;
        $l->attach($em);

        $this->assertCount(1, $em->getEvents(MvcEvent::EVENT_BOOTSTRAP));
    }

    /**
     * @covers ::loadExtensions
     */
    public function testLoadExtensionsWithNoExtensions()
    {
        $e = $this->e;
        $l = $this->l;

        $i = $e->getApplication()->getInjector();
        /** @var \Twig_Environment $twig */
        $twig = $i->nvoke('Twig_Environment');
        $extCount = count($twig->getExtensions());

        $l->loadExtensions($e);
        $this->assertSame($extCount, count($twig->getExtensions()));
    }

    /**
     * @covers ::loadExtensions
     */
    public function testLoadingEmptyExtensions()
    {
        $e = $this->e;
        $l = $this->l;

        $i = $e->getApplication()->getInjector();
        $i['spiffy.mvc.twig'] = [
            'extensions' => [
                'empty' => null
            ]
        ];
        /** @var \Twig_Environment $twig */
        $twig = $i->nvoke('Twig_Environment');
        $extCount = count($twig->getExtensions());

        $l->loadExtensions($e);
        $this->assertSame($extCount, count($twig->getExtensions()));
    }

    /**
     * @covers ::loadExtensions
     */
    public function testLoadingStringExtension()
    {
        $e = $this->e;
        $l = $this->l;

        $i = $e->getApplication()->getInjector();
        $i->nject('extension', 'Spiffy\View\Twig\TestAsset\TestTwigExtension');
        $i['spiffy.mvc.twig'] = [
            'extensions' => [
                'test' => 'Spiffy\View\Twig\TestAsset\TestTwigExtension',
                'injector' => 'extension'
            ]
        ];
        /** @var \Twig_Environment $twig */
        $twig = $i->nvoke('Twig_Environment');
        $extCount = count($twig->getExtensions());

        $l->loadExtensions($e);
        $this->assertSame($extCount + 1, count($twig->getExtensions()));
        $this->assertSame($i->nvoke('extension'), $twig->getExtension('test'));
    }

    protected function setUp()
    {
        $app = new Application();
        $i = $app->getInjector();
        $i->nject('Twig_Environment', new \Twig_Environment(new \Twig_Loader_String()));
        $i['spiffy.mvc.twig'] = [];

        $this->e = new MvcEvent($app);
        $this->l = new TwigExtensionLoader();
    }
}
