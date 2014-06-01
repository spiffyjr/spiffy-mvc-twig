<?php

namespace Spiffy\Mvc\Twig\Command;

use Spiffy\Inject\Injector;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @coversDefaultClass \Spiffy\Mvc\Twig\Command\ClearCacheCommand
 */
class ClearCacheCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::configure, ::execute
     */
    public function testCommandWithNoCachePath()
    {
        $command = new ClearCacheCommand();
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $display = $commandTester->getDisplay();
        $this->assertRegExp('/Clearing twig cache/', $display);
        $this->assertRegExp('/Debug mode is .*off.*/', $display);
        $this->assertRegExp('/No cache path is set!/', $display);
        $this->assertSame(1, $commandTester->getStatusCode());
    }

    /**
     * @covers ::configure, ::execute, ::remove
     */
    public function testRemove()
    {
        $tmp = sys_get_temp_dir();
        $cache = $tmp . '/spiffy-mvc-twig-test';

        if (file_exists($cache)) {
            rmdir($cache);
        }

        mkdir($cache);
        mkdir($cache . '/leaf');
        mkdir($cache . '/parent');
        mkdir($cache . '/parent/child');
        file_put_contents($cache . '/leaf/leaf.php', '<?php');
        file_put_contents($cache . '/parent/parent.php', '<?php');
        file_put_contents($cache . '/parent/child/child.php', '<?php');
        file_put_contents($cache . '/parent/child/child2.php', '<?php');

        $this->assertFileExists($cache);
        $this->assertFileExists($cache . '/parent/child/child2.php');

        $i = new Injector();
        $i['mvc.twig'] = [
            'options' => [
                'cache' => $cache
            ]
        ];

        $command = new ClearCacheCommand();
        $command->setInjector($i);
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $display = $commandTester->getDisplay();
        $this->assertRegExp('/Clearing twig cache/', $display);
        $this->assertRegExp('/Debug mode is .*off.*/', $display);
        $this->assertRegExp('/Complete/', $display);
        $this->assertFileExists($cache);
        $this->assertFalse(file_exists($cache . '/parent/child/child2.php'));
        $this->assertSame(0, $commandTester->getStatusCode());
    }

    /**
     * @covers ::configure, ::execute
     */
    public function testCommandWithDebugOn()
    {
        $i = new Injector();
        $i['mvc.twig'] = [
            'options' => [
                'debug' => true
            ]
        ];

        $command = new ClearCacheCommand();
        $command->setInjector($i);
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $display = $commandTester->getDisplay();
        $this->assertRegExp('/Clearing twig cache/', $display);
        $this->assertRegExp('/Debug mode is .*on.*/', $display);
        $this->assertRegExp('/No cache path is set!/', $display);
        $this->assertSame(1, $commandTester->getStatusCode());
    }
}
