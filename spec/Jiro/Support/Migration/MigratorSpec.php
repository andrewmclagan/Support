<?php namespace spec\Jiro\Support\Migration;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MigratorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Jiro\Support\Migration\Migrator');
    }

    function it_should_call_the_up_method_on_a_migration_class(\CreateSomeTestTable $migration)
    {
        $migration->up()->shouldBeCalled();

        $this->runMigration($migration);
    }

    function it_should_throw_exception_if_up_method_does_not_exist()
    {
        $migration = new \stdClass;

        $this->shouldThrow('BadMethodCallException')->duringRunMigration($migration);
    }
}
