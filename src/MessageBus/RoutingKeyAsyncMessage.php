<?php

namespace Jcid\RabbitMQBridge\MessageBus;

interface RoutingKeyAsyncMessage extends IsHandledAsync
{
    /**
     * @return string
     */
    public function getRoutingKey();
}
