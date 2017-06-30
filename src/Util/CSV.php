<?php

namespace App\Util;

use Cocur\Slugify\Slugify;
use League\Csv\Reader;
use League\Csv\Statement;

/**
 * Reader
 *
 * @author    Ronan Guilloux <ronan.guilloux@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class CSV
{

    /**
     * @var
     */
    var $sluger;

    /**
     * @param string $path
     * @param string $delimiter
     * @param string $enclosure
     * @return array
     */
    public function getSlugifiedHeaders($path, $delimiter = ";", $enclosure = '"')
    {
        $headers = $this->getHeaders($path, $delimiter, $enclosure);

        return array_map([$this, 'slugify'], $headers);
    }

    /**
     * @param string $path
     * @param string $delimiter
     * @param string $enclosure
     * @return array
     */
    public function getUnslugifiedHeaders($path, $delimiter = ";", $enclosure = '"')
    {
        $headers = $this->getHeaders($path, $delimiter, $enclosure);

        return array_map([$this, 'unslugify'], $headers);
    }

    /**
     * @param string $path
     * @param string $delimiter
     * @param string $enclosure
     * @return array|\string[]
     */
    public function getHeaders($path, $delimiter = ";", $enclosure = '"')
    {
        $reader = $this->getReader($path, $delimiter, $enclosure);

        return $reader->getHeader();
    }

    /**
     * @param string $path
     * @param string $delimiter
     * @param string $enclosure
     * @return \League\Csv\ResultSet
     */
    public function getRecords($path, $delimiter = ";", $enclosure = '"')
    {
        $reader = $this->getReader($path, $delimiter, $enclosure);

        return (new Statement())->process($reader);
    }

    /**
     * @param string $path
     * @param string $delimiter
     * @param string $enclosure
     * @return \League\Csv\AbstractCsv|static
     */
    private function getReader($path, $delimiter = ";", $enclosure = '"')
    {
        $reader = Reader::createFromPath($path);
        $reader->setHeaderOffset(0);
        $reader->setDelimiter($delimiter);
        $reader->setEnclosure($enclosure);

        return $reader;
    }

    /**
     * @param string $str
     * @param string $delimiter
     * @return string
     */
    private function slugify($str, $delimiter = '_')
    {
        if (is_null($this->sluger)) {
            $this->sluger = new Slugify();
        }
        return $this->sluger->slugify($str, $delimiter); // hello-world
    }

    /**
     * @param string $slug
     * @param string $oldDelimiter
     * @param string $newDelimiter
     * @return string
     */
    private function unslugify($slug, $oldDelimiter = '_', $newDelimiter = ' ')
    {

        $slug = str_replace($oldDelimiter, $newDelimiter, $slug);

        return ucwords($slug);
    }
}
