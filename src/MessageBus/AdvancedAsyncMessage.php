<?php

namespace Jcid\RabbitMQBridge\MessageBus;

interface AdvancedAsyncMessage extends ProducerAsyncMessage
{
    /**
     * @return string
     */
    public function getRoutingKey();

    /**
     * @return array
     */
    public function getAdditionalProperties();
}
