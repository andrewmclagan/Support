<?php namespace Jiro\Support\Event;

use Illuminate\Container\Container;

/**
 * Base Event Handler.
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

abstract class EventHandler
{
    /**
     * The container instance.
     *
     * @var \Illuminate\Container\Container
     */
    protected $app;

    /**
     * Constructor.
     *
     * @param  \Illuminate\Container\Container  $app
     * @return void
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * Dynamically retrieve objects from the container.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->app[$key];
    }
}
