<?php

namespace Viloveul\Event;

use Fig\EventDispatcher\ParameterDeriverTrait;
use Viloveul\Event\Contracts\Provider as IProvider;

class Provider implements IProvider
{
    use ParameterDeriverTrait;

    /**
     * @var array
     */
    protected $listeners = [];

    /**
     * @param $listener
     */
    public function addListener(callable $listener): void
    {
        $this->listeners[$this->getParameterType($listener)][] = $listener;
    }

    /**
     * @param object $evt
     */
    public function getListenersForEvent(object $evt): iterable
    {
        $listeners = [];
        $className = get_class($evt);
        if (isset($this->listeners[$className])) {
            foreach ($this->listeners[$className] as $listener) {
                array_push($listeners, $listener);
            }
        }
        foreach (class_parents($evt) as $parent) {
            if (isset($this->listeners[$parent])) {
                foreach ($this->listeners[$parent] as $listener) {
                    array_push($listeners, $listener);
                }
            }
        }
        foreach (class_implements($evt) as $interface) {
            if (isset($this->listeners[$interface])) {
                foreach ($this->listeners[$interface] as $listener) {
                    array_push($listeners, $listener);
                }
            }
        }
        return $listeners;
    }
}
