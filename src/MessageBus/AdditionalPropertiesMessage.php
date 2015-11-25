<?php

namespace Jcid\RabbitMQBridge\MessageBus;

interface AdditionalPropertiesMessage extends IsHandledAsync
{
    /**
     * @return array
     */
    public function getAdditionalProperties();
}
