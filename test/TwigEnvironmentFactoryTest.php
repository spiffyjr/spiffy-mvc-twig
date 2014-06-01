<?php

namespace Spiffy\Mvc\Twig;

use Spiffy\Event\EventManager;
use Spiffy\Inject\Injector;
use Spiffy\Mvc\Application;
use Spiffy\Mvc\MvcEvent;

/**
 * @coversDefaultClass \Spiffy\Mvc\Twig\TwigEnvironmentFactory
 */
class TwigEnvironmentFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::createService
     */
    public function testCreateService()
    {
        $f = new TwigEnvironmentFactory();
        $i = new Injector();
        $i['mvc.twig'] = [
            'loader_paths' => [
                realpath(__DIR__),
                realpath(__DIR__ . '/../')
            ],
            'extensions' => [
                'test' => 'Spiffy\View\Twig\TestAsset\TestTwigExtension'
            ],
            'options' => []
        ];

        $twig = $f->createService($i);
        $this->assertInstanceOf('Twig_Environment', $twig);
        $this->assertFalse($twig->hasExtension('test'));

        /** @var \Twig_Loader_Filesystem $loader */
        $loader = $twig->getLoader();

        $this->assertInstanceOf('Twig_Loader_Filesystem', $loader);

        $paths = $loader->getPaths();
        $this->assertSame(array_reverse($i['mvc.twig']['loader_paths']), $paths);
    }
}
