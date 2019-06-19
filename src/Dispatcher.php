<?php

namespace Viloveul\Event;

use InvalidArgumentException;
use Viloveul\Event\Contracts\Provider as IProvider;
use Viloveul\Event\Contracts\Dispatcher as IDispatcher;

class Dispatcher implements IDispatcher
{
    /**
     * @var mixed
     */
    protected $providers = [];

    /**
     * @param IProvider $provider
     */
    public function __construct(IProvider $provider)
    {
        $this->addProvider($provider);
    }

    /**
     * @param $listener
     */
    public function addProvider(IProvider $provider): void
    {
        $class = get_class($provider);
        if (!array_key_exists($class, $this->providers)) {
            $this->providers[$class] = $provider;
        } else {
            throw new InvalidArgumentException("Listener Provider already registered");
        }
    }

    /**
     * @param object $evt
     */
    public function dispatch(object $payload)
    {
        $context = clone $payload;
        foreach ($this->providers as $provider) {
            foreach ($provider->getListenersForEvent($context) as $listener) {
                $listener($context);
            }
        }
    }
}
