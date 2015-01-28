<?php

namespace Jcid\RabbitMQBridge\MessageBus;

use SimpleBus\Message\Message;

class AsyncMessage implements Message
{
    /**
     * @var Message
     */
    private $message;

    /**
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message  = $message;
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }
}
