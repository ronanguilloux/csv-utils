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
class Quick
{

    var $sluger;

    public function getSlugifiedHeaders($path, $delimiter = ";", $enclosure = '"')
    {
        $headers = $this->getHeaders($path, $delimiter, $enclosure);

        return array_map([$this, 'slugify'], $headers);
    }

    public function getUnslugifiedHeaders($path, $delimiter = ";", $enclosure = '"')
    {
        $headers = $this->getHeaders($path, $delimiter, $enclosure);

        return array_map([$this, 'unslugify'], $headers);
    }

    public function getHeaders($path, $delimiter = ";", $enclosure = '"')
    {
        $csv = Reader::createFromPath($path);
        $csv->setHeaderOffset(0);
        $csv->setDelimiter($delimiter);
        $csv->setEnclosure($enclosure);

        return $csv->getHeader();
    }

    private function slugify($str, $delimiter = '_')
    {
        if (is_null($this->sluger)) {
            $this->sluger = new Slugify();
        }
        return $this->sluger->slugify($str,$delimiter); // hello-world
    }

    private function unslugify( $slug, $oldDelimiter = '_', $newDelimiter = ' ') {

        $slug = str_replace($oldDelimiter, $newDelimiter, $slug);

        return ucwords($slug);
    }
}
