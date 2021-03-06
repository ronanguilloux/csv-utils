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
class SlugHeaders extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('csv:head:slug')
            ->setDescription("Perform csv slug on your CSV's headers")
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
        $result = $csv->getSlugifiedHeaders($path);

        $output->writeln(join(';', $result));


    }
}
