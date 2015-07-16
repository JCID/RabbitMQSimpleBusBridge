<?php

namespace Jcid\RabbitMQBridge\MessageBus;

interface ProducerAsyncMessage extends IsHandledAsync
{
    /**
     * @return string
     */
    public function getProducer();
}
