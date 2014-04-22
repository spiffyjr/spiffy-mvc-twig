<?php

namespace Spiffy\Mvc\Twig;

use Spiffy\Inject\Injector;

/**
 * @coversDefaultClass \Spiffy\Mvc\Twig\TwigStrategyFactory
 */
class TwigStrategyFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::createService
     */
    public function testCreateService()
    {
        $f = new TwigStrategyFactory();
        $i = new Injector();
        $i->nject('Twig_Environment', new \Twig_Environment());

        $result = $f->createService($i);

        $this->assertInstanceOf('Spiffy\View\Twig\TwigStrategy', $result);
    }
}
