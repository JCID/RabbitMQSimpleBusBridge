<?php

namespace Jcid\RabbitMQBridge\EventDispatcher\Listener;

use Jcid\RabbitMQBridge\EventDispatcher\Events\PostMessageEvent;
use LongRunning\Core\Cleaner;
use SimpleBus\Message\Message;
use SimpleBus\Message\Subscriber\MessageSubscriber;

class LongRunningListener implements MessageSubscriber
{
    /**
     * @var Cleaner
     */
    private $cleaner;

    /**
     * @param Cleaner $cleaner
     */
    public function __construct(Cleaner $cleaner)
    {
        $this->cleaner = $cleaner;
    }

    /**
     * @param PostMessageEvent|Message $message
     */
    public function notify(Message $message)
    {
        $this->cleaner->cleanUp();
    }
}
