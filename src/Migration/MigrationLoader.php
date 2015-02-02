<?php namespace Jiro\Support\Migration;

use RecursiveDirectoryIterator;
use Illuminate\Filesystem\ClassFinder;
use Jiro\Support\Exceptions\JiroException;

/**
 * Loads migration classes from a directory
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

class MigrationLoader
{
    /**
     * Array of migration $className => $filePath 
     *
     * @var string
     */
    private $migrations;    

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

    /**
     * Load the migrations.
     *
     * @param  string $basePath
     * @return Array $migrations of migration $className => $filePath 
     */
    public function load()
    {
        $migrations = [];
        $this->assertMigrationsDirectoryExists();

        foreach ((new MigrationFinder($this->basePath))->find() as $filePath)
        {
            require_once($filePath);

            $this->migrations[$this->getMigrationClass($filePath)] = $filePath;
        }

        return $this->migrations;
    }  

    /**
     * Discovers the migration class
     *
     * @param File $file
     * @return string
     */
    private function getMigrationClass($file)
    {
        $className = (new ClassFinder)->findClass($file);

        if ($className == '')
        {
            throw new \UnexpectedValueException('Could not locate migration class in file "$file"');
        }

        return $className;
    }       

    /**
     * Assert that the given migrations directory exists.
     *
     * @return mixed
     */
    private function assertMigrationsDirectoryExists()
    {
        if ( ! is_dir($this->basePath))
        {
            throw new JiroException(
                "The path provided for the migrations directory, ".$this->basePath.", does not exist."
            );
        }
    }   
}
