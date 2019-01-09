<?php

namespace Viloveul\Event\Contracts;

interface Dispatcher
{
    /**
     * @param $event
     * @param array    $payload
     */
    public function dispatch($event, array $payload = []);

    /**
     * @param $event
     */
    public function getListeners($event): array;

    /**
     * @param $event
     */
    public function hasListeners($event): bool;

    /**
     * @param $event
     * @param $handler
     * @param $priority
     */
    public function listen($event, callable $handler, $priority = 10): void;
}
