<?php namespace Jiro\Support\Database;

/**
 * Base Repository interface.
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

interface BaseRepositoryInterface
{
	/**
	 * Returns a dataset compatible with data grid.
	 *
	 * @return \Jiro\Support\Database\Eloquent\Model
	 */
	public function grid();

	/**
	 * Returns all the model entries.
	 *
	 * @return \Jiro\Support\Database\Eloquent\Model
	 */
	public function findAll();

	/**
	 * Returns a model entry by its primary key.
	 *
	 * @param  int  $id
	 * @return \Jiro\Support\Database\Eloquent\Model
	 */
	public function find($id);

	/**
	 * Determines if the given model is valid for creation.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Support\MessageBag
	 */
	public function validForCreation(array $data);

	/**
	 * Determines if the given model is valid for update.
	 *
	 * @param  int  $id
	 * @param  array  $data
	 * @return \Illuminate\Support\MessageBag
	 */
	public function validForUpdate($id, array $data);

	/**
	 * Creates or updates the given model.
	 *
	 * @param  int  $id
	 * @param  array  $input
	 * @return bool|array
	 */
	public function store($id, array $input);
}