<?php namespace Jiro\Support\Migration;

use Jiro\Support\Exceptions\JiroException;

/**
 * Executes migration files in a directory
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

class Migrator
{
	/**
	 * Runs all migrations in a directory
	 *
	 * @param string $direction 
	 * @return void
	 */
	public function migrateDirectory($source, $direction = 'up')
	{
		$this->assertSourceDirectoryExists($source);

		foreach((new MigrationLoader($source))->load() as $migrationName => $stubFile)
		{			
			$migration = new $migrationName;

			$this->runMigration($migration, $direction);
		}
	}			

	/**
	 * Run the migration on the class instance 
	 *
	 * @param string $direction
	 * @param Migration $migration
	 * @return void
	 */
	public function runMigration($migration, $direction = 'up')
	{
		if (method_exists($migration, $direction))
		{
			$migration->{$direction}();
		}
		else 
		{
			throw new \BadMethodCallException('Migration '.get_class($migration).' does not have the '.$direction.'() method. ');
		}
	}		

    /**
     * Assert that the source directory exists.
     *
     * @param string $source
     * @return void
     */
    private function assertSourceDirectoryExists($source)
    {
        if ( ! is_dir($source))
        {
            throw new JiroException("The source directory path provided, ".$source.", does not exist.");
        }       
    }  	
}