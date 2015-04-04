<?php namespace Jiro\Support\Testing;

use Illuminate\Foundation\Testing\TestCase;
use Jiro\Support\Migration\Migrator;
use Laracasts\TestDummy\Factory;

/**
 * Sets up application instance and DB for integration testing
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

abstract class DbTestCase extends TestCase 
{
	/**
	 * Boots the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
		require __DIR__.'/../../../../bootstrap/autoload.php';
		
		$app = require __DIR__.'/../../../../laravel/laravel/bootstrap/app.php';

		$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

		return $app;		
	}	

	/**
	 * Setup before each test.
	 *
	 * @return void	 
	 */
	public function setUp()
	{ 
		parent::setUp();

		Factory::$factoriesPath = __DIR__.'/factories';

		$this->registerServiceProviders();

		$this->app['config']->set('database.default','sqlite');	
		$this->app['config']->set('database.connections.sqlite.database', ':memory:');

		$this->migrate();
	}

	/**
	 * Registers package service providers.
	 *
	 * @return array 
	 */
	public function registerServiceProviders()
	{
		foreach ($this->getServiceProviders() as $provider)
		{
			$this->app->register($provider);
		}
	}

	/**
	 * run package database migrations
	 *
	 * @return void
	 */
	public function migrate()
	{ 
		(new Migrator)->migrateDirectory($this->getMigrationsDirectory());
	}	

	/**
	 * Returns an array of package service providers
	 *
	 * @return array 
	 */
	abstract public function getServiceProviders();

	/**
	 * Returns path to migration files
	 *
	 * @return string 
	 */
	abstract public function getMigrationsDirectory();				
}