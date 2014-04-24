<?php

namespace Spiffy\Mvc\Twig;

/**
 * @coversDefaultClass \Spiffy\Mvc\Twig\Package
 */
class PackageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::getConfig
     */
    public function testGetConfig()
    {
        $p = new Package();
        $this->assertSame(include __DIR__ . '/../config/config.php', $p->getConfig());
    }
}
