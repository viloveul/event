<?php 

class InstanceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testAddClosureListener()
    {
        $dispatcher = new Viloveul\Event\Dispatcher();
        $dispatcher->addListener('foo', function() {
            return 'bar';
        });
        $this->tester->assertTrue($dispatcher->hasListeners('foo'));
    }

    public function testAddClassListener()
    {
        $mine = new ViloveulEventExample\MyListener();
        $dispatcher = new Viloveul\Event\Dispatcher();
        $dispatcher->addListener('foo', [$mine, 'foo']);
        $this->tester->assertTrue($dispatcher->hasListeners('foo'));
    }

    public function testDispatchEvent()
    {
        $mine = new ViloveulEventExample\MyListener();
        $dispatcher = new Viloveul\Event\Dispatcher();

        $dispatcher->addListener('foo', [$mine, 'foo']);
        $dispatcher->addListener('foo', [$mine, 'bar']);
        $dispatcher->addListener('foo', function() {
            return 'baz';
        });
        $this->tester->assertEquals('baz', $dispatcher->dispatch('foo'));
    }

    public function testErrorDuplicateListener()
    {
        $this->tester->expectThrowable(Viloveul\Event\ListenerException::class, function() {
            $mine = new ViloveulEventExample\MyListener();
            $dispatcher = new Viloveul\Event\Dispatcher();
            $dispatcher->addListener('foo', [$mine, 'foo']);
            $dispatcher->addListener('foo', [$mine, 'foo']);
        });
    }
}
