<?php namespace spec\Jiro\Support\Migration;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MigrationFinderSpec extends ObjectBehavior
{
	function let()
	{
		$this->beConstructedWith(__DIR__.'/helpers');
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Jiro\Support\Migration\MigrationFinder');
    }

    function it_hunts_down_the_migration_file_like_a_dog()
    {
    	$this->find()->shouldReturn([__DIR__.'/helpers/test_table.stub']);
    }
}
