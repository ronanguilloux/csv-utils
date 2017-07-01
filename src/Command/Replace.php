<?php

namespace App\Command;

use App\Util\CSV;
use League\Csv\Reader;
use League\Csv\Statement;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Replace
 *
 * @author    Ronan Guilloux <ronan.guilloux@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class Replace extends Command
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('csv:cols:replace')
            ->setDescription("Replace a value by another in a whole column")
            ->setHelp("This command replaces a value by another in a column's records")
            ->addArgument('path', InputArgument::REQUIRED, 'CSV path to use', null)
            ->addArgument('column', InputArgument::REQUIRED, 'Column index/title to use', null)
            ->addArgument('search', InputArgument::REQUIRED, 'haystack', null)
            ->addArgument('replace', InputArgument::REQUIRED, 'needle', null)
        ;

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
        $column = $input->getArgument('column');
        $search = $input->getArgument('search');
        $replace = $input->getArgument('replace');
        $csv = new CSV();
        $result = str_replace($search, $replace, $csv->getColumnRecords($path, $column));
        $output->writeln(join("\n", $result));
    }
}
