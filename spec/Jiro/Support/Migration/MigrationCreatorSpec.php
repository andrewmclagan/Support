<?php namespace spec\Jiro\Support\Migration;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;

class MigrationCreatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Jiro\Support\Migration\MigrationCreator');
    }

    function let()
    {
        $source = __DIR__ . '/helpers'; // real file system

        $destination = vfsStream::setup('root_dir'); // virtual file system

        $this->beConstructedWith($source, $destination->url());
    }

    function it_throws_exception_if_source_directory_does_not_exist()
    {
        $this->shouldThrow('Jiro\Support\Exceptions\JiroException')
             ->during__construct(__DIR__.'/nonexistent-folder', '/destination');
    }

    function it_throws_exception_if_destination_directory_does_not_exist()
    {
        $this->shouldThrow('Jiro\Support\Exceptions\JiroException')
             ->during__construct('/source', __DIR__.'/nonexistent-folder');
    } 

    function it_creates_migration_files_at_the_destination()
    {
        $this->createMigrations()->shouldCreateFiles();
    }   

    function it_generates_correct_migration_file_content()
    {
        $this->createMigrations()->shouldGenerateCorrectContent();
    }

    public function getMatchers()
    {
        return [
            'createFiles' => function($returned)
            { 
                foreach ($returned as $file)
                {
                    foreach (vfsStreamWrapper::getRoot()->getChildren() as $child)
                    {
                        if ($child->url() !== $file)
                        {
                            return false;
                        }
                    }
                }
                
                return true;
            },
            'generateCorrectContent' => function()
            {
                foreach (vfsStreamWrapper::getRoot()->getChildren() as $child)
                {
                    if ($child->getContent() !== file_get_contents(__DIR__.'/helpers/test_table.stub'))
                    {
                        return false;
                    }

                    return true;
                }
            }
        ];
    }
}
