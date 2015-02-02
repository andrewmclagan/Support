<?php namespace spec\Jiro\Support\Migration;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MigrationLoaderSpec extends ObjectBehavior
{
    function it_throws_exception_if_the_given_migrations_directory_path_does_not_exist()
    {
        $this->beConstructedWith(__DIR__.'/nonexistent-folder');
        $this->shouldThrow('Jiro\Support\Exceptions\JiroException')->duringLoad();
    }

    function let()
    {
        $this->beConstructedWith(__DIR__.'/helpers');
    }    

    function it_is_initializable()
    {
        $this->shouldHaveType('Jiro\Support\Migration\MigrationLoader');
    }

    function it_loads_a_directory_of_user_provided_migrations()
    {
        $migrations = $this->load(__DIR__.'/helpers');

        $migrations->shouldBeArray();
        $migrations->shouldHaveCount(1);
        $migrations->shouldHaveKey('CreateSomeTestTable');
        $migrations['CreateSomeTestTable']->shouldBe(__DIR__.'/helpers/test_table.stub');
    }

    public function getMatchers()
    {
        return [
            'haveKey' => function($subject, $key) {
                return array_key_exists($key, $subject);
            }
        ];
    }
}
