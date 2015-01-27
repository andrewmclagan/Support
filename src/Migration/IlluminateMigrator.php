<?php namespace Jiro\Support\Migration;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Filesystem\ClassFinder;

class IlluminateMigrator implements MigratorInterface 
{
	/**
	 * The filesystem instance.
	 *
	 * @var \Illuminate\Filesystem\Filesystem
	 */
	protected $fileSystem; 

	/**
	 * The classfinder instance.
	 *
	 * @var \Illuminate\Filesystem\ClassFinder
	 */
	protected $classFinder;

	/**
	 * constructor
	 *
	 * @param  \Illuminate\Filesystem\Filesystem $fileSystem
	 * @param  \Illuminate\Foundation\Composer $composer
	 * @return void
	 */
	public function __construct(Filesystem $fileSystem, ClassFinder $classFinder)
	{
		$this->fileSystem = $fileSystem;
		$this->classFinder = $classFinder;
	}

	/**
	 * Runs the migrations
	 *
	 * @param string $path
	 * @return void
	 */
	public function migrate($path)
	{
		foreach ($this->getMigrations($path) as $file)
		{
			$this->fileSystem->requireOnce($file);

			$className = $this->getMigrationClass($file);
			
			$this->runMigration($className);
		}
	}

	/**
	 * Returns array of migration files
	 *
	 * @param string $path
	 * @return array
	 */
	protected function getMigrations($path)
	{
		return $this->fileSystem->files($path);
	}	

	/**
	 * Discovers the migration class
	 *
	 * @param File $file
	 * @return string
	 */
	protected function getMigrationClass($file)
	{
		$className = $this->classFinder->findClass($file);

		if ($className == '')
		{
			throw new \UnexpectedValueException('Could not locate migration class in file "$file"');
		}

		return $className;
	}	

	/**
	 * Run the migration on the class
	 *
	 * @return void
	 */
	protected function runMigration($className)
	{
		$migration = new $migrationClass;

		if (method_exists($migration, 'up'))
		{
			$migration->up();
		}
		else 
		{
			throw new \BadMethodCallException('Migration "$migration" does not have a up() method. ');
		}
	}	
}