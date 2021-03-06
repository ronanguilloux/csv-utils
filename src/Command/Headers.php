<?php

namespace App\Command;

use App\Util\CSV;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Quick
 *
 * @author    Ronan Guilloux <ronan.guilloux@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class Headers extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('csv:head')
            // the short description shown while running "php bin/console list"
            ->setDescription("Fetch your CSV's headers")
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command allows you to perform csv actions: type csv csv <action> help for more")
            ->addArgument('path', InputArgument::REQUIRED, 'CSV path to use', null);

    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');
        if (!is_file($path)) {
            throw new \InvalidArgumentException("$path is not a valid path file");
        }

        $csv = new CSV();
        $result = $csv->getHeaders($path);

        $output->writeln(join(';', $result));


    }
}
