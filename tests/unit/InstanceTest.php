<?php 

use ViloveulEventSample;

class InstanceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected $myEvent;

    protected $myListener;
    
    protected function _before()
    {
        $this->myEvent = new Viloveul\Event\Dispatcher();
        $this->myListener = new ViloveulEventSample\MyListener();
    }

    protected function _after()
    {
    }

    // tests
    public function testAddClosureListener()
    {
        $this->myEvent->addListener('foo', function() {
            return 'bar';
        });
        $this->tester->assertTrue($this->myEvent->hasListeners('foo'));
    }

    public function testAddClassListener()
    {
        $this->myEvent->addListener('foo', [$this->myListener, 'foo']);
        $this->tester->assertTrue($this->myEvent->hasListeners('foo'));
    }

    public function testDispatchEvent()
    {
        $this->myEvent->addListener('foo', [$this->myListener, 'foo']);
        $this->myEvent->addListener('foo', [$this->myListener, 'bar']);
        $this->myEvent->addListener('foo', function() {
            return 'baz';
        });
        $this->tester->assertEquals('baz', $this->myEvent->dispatch('foo'));
    }

    public function testErrorDuplicateListener()
    {
        $this->tester->expectThrowable(Viloveul\Event\ListenerException::class, function() {
            $this->myEvent->addListener('foo', [$this->myListener, 'foo']);
            $this->myEvent->addListener('foo', [$this->myListener, 'foo']);
        });
    }
}
