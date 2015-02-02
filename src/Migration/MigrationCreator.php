<?php namespace Jiro\Support\Migration;

use Jiro\Support\Exceptions\JiroException;
use Illuminate\Filesystem\FileSystem;
use Illuminate\Database\Migrations\MigrationCreator as IlluminateMigrationCreator;

/**
 * Creates migration files from stub files
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

class MigrationCreator
{
    /**
     * Destination path for finnished migrations 
     *
     * @var string
     */
    private $destination;  

    /**
     * Source directory containing migration stubs
     *
     * @var string
     */
    private $source;           	

    /**
     * Migration creator instance
     *
     * @var Illuminate\Database\Migrations\MigrationCreator
     */
    private $migrationCreator;        

	/**
	 * constructor
	 *
	 * @return void
	 */
	public function __construct($source, $destination)
	{
		$this->source = $source;			
		
		$this->destination = $destination;	

		$this->assertDirectoriesExists();

		$this->migrationCreator = new IlluminateMigrationCreator(new FileSystem);
	}

	/**
	 * Creates migration files from stubs
	 *
	 * @return array $migrationFilePaths Paths to the migration files.
	 */
	public function createMigrations()
	{
		$migrationFilePaths = [];

		foreach((new MigrationLoader($this->source))->load() as $migrationName => $stubFile)
		{
			$path = $this->createEmptyMigrationFile($migrationName);

			$migrationFilePaths[] = $path;

			$this->createMigrationContent($path, $stubFile);
		}

		return $migrationFilePaths;
	}

	/**
	 * Generates the filename and empty file for the migration
	 *
	 * @param  string  $migrationName
	 * @return string  Path to the migration file.
	 */
	private function createEmptyMigrationFile($migrationName)
	{ 
		return $this->migrationCreator->create($migrationName, $this->destination);		
	}

	/**
	 * Creates the content of the migration from a stub
	 *
	 * @param  string  $path
	 * @param  string  $stubFile
	 * @return void
	 */
	private function createMigrationContent($path, $stubFile)
	{
		file_put_contents($path, $this->getMigrationContent($stubFile));
	}

	/**
	 * Retrieves the content of a migration stubfile
	 *
	 * @param  string  $path
	 * @return void
	 */
	private function getMigrationContent($path)
	{
		if ($this->isFile($path)) 
		{
			return file_get_contents($path);
		}

		throw new FileNotFoundException("Migration stub file does not exist at path {$path}");
	}	

    /**
     * Check if path is file
     *
     * @return boolean
     */
    private function isFile($path)
    {	
    	return is_file($path);
    }

    /**
     * Assert that destination and source directories exists.
     *
     * @return void
     */
    private function assertDirectoriesExists()
    {
        if ( ! is_dir($this->source))
        {
            throw new JiroException(
                "The source directory path provided, ".$this->source.", does not exist."
            );
        }

        if ( ! is_dir($this->destination))
        {
            throw new JiroException(
                "The destination directory path provided, ".$this->destination.", does not exist."
            );
        }        
    }   		
}