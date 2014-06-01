<?php

namespace Spiffy\Mvc\Twig\Command;

use Spiffy\Mvc\ConsoleCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearCacheCommand extends ConsoleCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('twig:clear-cache')
            ->setDescription('Clears the twig cache');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $i = $this->getInjector();
        $config = $i['mvc.twig'];
        $debug = isset($config['options']['debug']) && $config['options']['debug'] ? 'on' : 'off';

        $output->writeln('Clearing twig cache');
        $output->writeln(sprintf('Debug mode is <comment>%s</comment>', $debug));

        if (!isset($config['options']['cache'])) {
            $output->writeln('<error>No cache path is set!</error>');
            return 1;
        }

        $output->writeln(sprintf('Removing cache at <info>%s</info>', realpath($config['options']['cache'])));
        $this->remove($config['options']['cache']);
        $output->writeln('Complete');

        return 0;
    }

    /**
     * Recursively remove a directory.
     *
     * @param string $dir
     * @param bool $first
     */
    protected function remove($dir, $first = true)
    {
        foreach (glob($dir . '/*') as $file) {
            if (is_dir($file)) {
                $this->remove($file, false);
            } else {
                unlink($file);
            }
        }

        if ($first) {
            return;
        }
        rmdir($dir);
    }
}
