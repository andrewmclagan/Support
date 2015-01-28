<?php namespace Jiro\Support;

use Illuminate\Support\ServiceProvider;
use Jiro\Support\Migration\MigrationCreatorInterface;
use Jiro\Support\Migration\MigratorInterface;

class SupportServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(MigrationCreatorInterface::class, IlluminateMigrationCreator::class);		
		$this->app->bind(MigratorInterface::class, IlluminateMigrator::class);		
	}			

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [
			'Jiro\Support\Migration\MigrationCreatorInterface',
			'Jiro\Support\Migration\MigratorInterface',
		];
	}

}
