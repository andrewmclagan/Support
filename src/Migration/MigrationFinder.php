<?php namespace Jiro\Support\Migration;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Discovers migration files in a directory
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

class MigrationFinder
{
    /**
     * The base directory to conduct the search.
     *
     * @var string
     */
    private $basePath;

    /**
     * Create a new instance.
     *
     * @param string $basePath
     */
    function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

	public function find()
    {
        $files = [];

        foreach($this->getDirectoryIterator() as $file)
        {
            $files[] = $file->getPathname();
        }

        return $files;
    }

    /**
     * Get the directory iterator.
     *
     * @return RecursiveIteratorIterator
     */
    private function getDirectoryIterator()
    {
        $directoryIterator = new RecursiveDirectoryIterator($this->basePath);
        $directoryIterator->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);

        return new RecursiveIteratorIterator($directoryIterator);
    }    
}
