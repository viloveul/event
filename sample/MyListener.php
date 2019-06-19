<?php

namespace ViloveulEventSample;

use Exception;
use ViloveulEventSample\MyEventBar;
use ViloveulEventSample\MyEventFoo;

class MyListener
{
    /**
     * @param MyEventBar $bar
     */
    public function bar(MyEventBar $bar)
    {
        if ($bar->name === 'bar') {
            throw new Exception("bar");
        } else {
            throw new Exception("fail");
        }
    }

    /**
     * @param MyEventFoo $foo
     */
    public function foo(MyEventFoo $foo)
    {
        if ($foo->name === 'foo') {
            throw new Exception("foo");
        } else {
            throw new Exception("fail");
        }
    }
}
