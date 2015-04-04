<?php namespace Jiro\Support\Event;

use Illuminate\Events\Dispatcher;

/**
 * Base Event Handler interface.
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

interface EventHandlerInterface
{
    /**
     * Registers the event listeners using the given dispatcher instance.
     *
     * @param  \Illuminate\Events\Dispatcher  $dispatcher
     * @return void
     */
    public function subscribe(Dispatcher $dispatcher);
}
