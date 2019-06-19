<?php

namespace Viloveul\Event\Contracts;

use Psr\EventDispatcher\ListenerProviderInterface;

interface Provider extends ListenerProviderInterface
{
    /**
     * @param $listener
     */
    public function addListener(callable $listener): void;

    /**
     * @param object $event
     */
    public function getListenersForEvent(object $event): iterable;
}
