<?php

namespace Viloveul\Event;

use Viloveul\Event\Contracts\Dispatcher as IDispatcher;
use Viloveul\Event\ListenerException;

class Dispatcher implements IDispatcher
{
    /**
     * @var array
     */
    protected $listeners = [];

    /**
     * @param $event
     * @param $handler
     * @param $priority
     */
    public function addListener($event, callable $handler, $priority = 10): void
    {
        if (!$this->hasListeners($event)) {
            $this->listeners[$event] = [];
        }
        $key = abs($priority);
        $id = $this->buildId($handler, $key);
        if (isset($this->listeners[$event][$key][$id])) {
            throw new ListenerException("Listener already registered.");
        }
        $this->listeners[$event][$key][$id] = $handler;
    }

    /**
     * @param  $event
     * @param  array    $payload
     * @return mixed
     */
    public function dispatch($event, array $payload = [])
    {
        $result = $payload;

        $listeners = $this->getListeners($event);

        do {
            foreach ((array) current($listeners) as $callback):
                if (is_callable($callback)) {
                    $filtered = call_user_func($callback, $result, $payload);
                    if ($filtered !== null) {
                        $result = $filtered;
                    }
                }
            endforeach;

        } while (false !== next($listeners));

        return $result;
    }

    /**
     * @param  $event
     * @return mixed
     */
    public function getListeners($event): array
    {
        if (!$this->hasListeners($event)) {
            return [];
        }

        $listeners = $this->listeners[$event];

        // sort by key (its mean about priority)
        ksort($listeners);

        return $listeners;
    }

    /**
     * @param $event
     */
    public function hasListeners($event): bool
    {
        return array_key_exists($event, $this->listeners) && count($this->listeners[$event]) > 0;
    }

    /**
     * @param $event
     * @param $handler
     * @param $priority
     */
    public function listen($event, callable $handler, $priority = 10): void
    {
        $this->addListener($event, $handler, $priority);
    }

    /**
     * @param  $handler
     * @return mixed
     */
    protected function buildId($handler, $suffix)
    {
        if (is_string($handler)) {
            return $handler;
        }
        $callback = is_object($handler) ? [$handler, $suffix] : $handler;
        if (is_object($callback[0])) {
            return spl_object_hash($callback[0]) . $callback[1];
        } elseif (is_string($callback[0])) {
            return $callback[0] . '::' . $callback[1];
        } else {
            return (string) mt_rand();
        }
    }
}
