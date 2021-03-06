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
 * Uniques
 *
 * @author    Ronan Guilloux <ronan.guilloux@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class Uniques extends Command
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('csv:cols:uniques')
            ->setDescription("Get a deduplicated list of values from a column index or title")
            ->setHelp("This command fetch a column's unique values")
            ->addArgument('path', InputArgument::REQUIRED, 'CSV path to use', null)
            ->addArgument('column', InputArgument::REQUIRED, 'Column index/title to use', null);

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
        $csv = new CSV();
        $result = $csv->getColumnRecords($path, $column, true);
        $output->writeln(join("\n", $result));
    }
}
