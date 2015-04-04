<?php namespace Jiro\Support\Database\Eloquent;

use Validator;
use Illuminate\Container\Container;
use Symfony\Component\Finder\Finder;
use Jiro\Support\Database\BaseRepositoryInterface;
use Jiro\Support\Database\Eloquent\RepositoryTrait;
use Jiro\Support\Validator\ValidatorTrait;
use Jiro\Support\Database\ContainerTrait;
use Jiro\Support\Event\EventTrait;

/**
 * Base Repository.
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

abstract class BaseRepository implements BaseRepositoryInterface
{
	use ContainerTrait, EventTrait, RepositoryTrait, ValidatorTrait;

	/**
	 * The Data handler.
	 *
	 * @var \Jiro\____\Handlers\DataHandlerInterface
	 */
	protected $data;

	/**
	 * The Eloquent model.
	 *
	 * @var string
	 */
	protected $model;

	/**
	 * Constructor.
	 *
	 * @param  \Illuminate\Container\Container  $app
	 * @return void
	 */
	public function __construct(Container $app)
	{
		$this->setContainer($app);

		$this->setDispatcher($app['events']);		
	}	

	/**
	 * {@inheritDoc}
	 */
	public function grid()
	{
		return $this
			->createModel();
	}

	/**
	 * {@inheritDoc}
	 */
	public function findAll()
	{
		return $this->container['cache']->rememberForever('jiro.'.strtolower($this->getModel()).'.all', function()
		{
			return $this->createModel()->get();
		});
	}

	/**
	 * {@inheritDoc}
	 */
	public function find($id)
	{
		return $this->container['cache']->rememberForever('jiro.'.strtolower($this->getModel()).$id, function() use ($id)
		{
			return $this->createModel()->find($id);
		});
	}

	/**
	 * {@inheritDoc}
	 */
	public function validForCreation(array $input)
	{
		return $this->validator->on('create')->validate($input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function validForUpdate($id, array $input)
	{
		return $this->validator->on('update')->validate($input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function store($id, array $input)
	{
		return ! $id ? $this->create($input) : $this->update($id, $input);
	}

}