<?php namespace spec\Jiro\Support\Handlers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Illuminate\Container\Container;
use Jiro\Support\Handlers\EventHandler;

class EventHandlerSpec extends ObjectBehavior
{
    function let()
    {
        $container = new Container;
        $container->bind('foo', function () { return 'bar'; });

        $this->beConstructedWith($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Jiro\Support\Handlers\EventHandler');
    }    

    function it_can_retrieve_dynamic_objects_from_the_container()
    {

        $this->foo->shouldReturn('bar');
    }
}

class EventHandlerStub extends EventHandler
{
}
