<?php namespace spec\Jiro\Support\Migration;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;

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

    function it_skips_hidden_dot_files()
    {
        // virtual file system
        $structure = [
            '.' => [],
            '.hiddenFile' => 'some text content',
            '..' => '',
        ];
        $path = vfsStream::setup('root_dir', null, $structure); 

        $this->beConstructedWith($path->url());

        $this->find()->shouldReturn([]);
    }
}
