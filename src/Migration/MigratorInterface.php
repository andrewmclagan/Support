<?php namespace Jiro\Support\Migration;

/**
 * Migraton Creator interface.
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

interface MigratorInterface
{
	/**
	 * Runs the migrations
	 *
	 * @return void
	 */
	public function migrate();
}