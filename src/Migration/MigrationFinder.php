<?php namespace Jiro\Support\Migration;

use DirectoryIterator;
use Jiro\Support\Exceptions\JiroException;

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

        foreach($this->getDirectoryIterator() as $fileInfo)
        {
            if ($this->filter($fileInfo))
            {
                $files[] = $fileInfo->getPathname();
            }
        }

        if (empty($files))
        {   
            throw new JiroException('Migrations path is empty!');
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
        $directoryIterator = new DirectoryIterator($this->basePath);

        return $directoryIterator;
    }  

    /**
     * Filter out the files we dont want  
     *
     * @param \DirectoryIterator $fileInfo
     * @return boolean
     */
    private function filter($file)
    {
        return ( ! $file->isDot() && $file->isFile() && ($file->getFileName()[0] !== '.') );
    }  
}
