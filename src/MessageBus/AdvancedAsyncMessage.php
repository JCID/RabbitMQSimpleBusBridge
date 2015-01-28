<?php

namespace Jcid\RabbitMQBridge\MessageBus;

interface AdvancedAsyncMessage
{
    /**
     * @return string
     */
    public function getProducer();

    /**
     * @return string
     */
    public function getRroutingKey();

    /**
     * @return array
     */
    public function getAdditionalProperties();
}
