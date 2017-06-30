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
            ->setName('csv:columns:uniques')
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
        $records = $csv->getRecords($path);
        $names = $records->getColumnNames();

        if (!is_numeric($column) && is_string($column) && !in_array($column, $names)) {
            throw new \InvalidArgumentException("$column is not a existing column title in your CSV");
        }

        if (is_numeric($column) && ($column > count($records->getColumnNames()))) {
            throw new \InvalidArgumentException("$column is not a existing column index in your CSV");
        }

        if (is_numeric($column)) {
            $column = (int)$column;
        }

        $result = array_unique(iterator_to_array($records->fetchColumn($column)));

        $output->writeln(join("\n", $result));
    }
}
