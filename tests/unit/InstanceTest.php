<?php 

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
        $listener = new ViloveulEventSample\MyListener();
        $provider = new Viloveul\Event\Provider();
        $provider->addListener([$listener, 'foo']);
        $provider->addListener([$listener, 'bar']);
        $this->myEvent = new Viloveul\Event\Dispatcher($provider);
    }

    protected function _after()
    {

    }

    public function testFooListener()
    {
        $this->tester->expectThrowable(new Exception('foo'), function() {
            $this->myEvent->dispatch(new ViloveulEventSample\MyEventFoo());
        });
    }

    public function testBarListener()
    {
        $this->tester->expectThrowable(new Exception('bar'), function() {
            $this->myEvent->dispatch(new ViloveulEventSample\MyEventBar());
        });
    }
}
