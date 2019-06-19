<?php

namespace Viloveul\Event\Contracts;

use Viloveul\Event\Contracts\Provider;
use Psr\EventDispatcher\EventDispatcherInterface;

interface Dispatcher extends EventDispatcherInterface
{
    /**
     * @param Provider $provider
     */
    public function addProvider(Provider $provider): void;

    /**
     * @param object $payload
     */
    public function dispatch(object $payload);
}
