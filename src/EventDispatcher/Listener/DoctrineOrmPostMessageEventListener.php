<?php

namespace Jcid\RabbitMQBridge\EventDispatcher\Listener;

use Jcid\RabbitMQBridge\EventDispatcher\Events\PostMessageEvent;
use SimpleBus\Message\Message;
use SimpleBus\Message\Subscriber\MessageSubscriber;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DoctrineOrmPostMessageEventListener implements MessageSubscriber
{
    /**
     * @var RegistryInterface
     */
    private $registry;

    /**
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param PostMessageEvent|Message $message
     */
    public function notify(Message $message)
    {
        $managers = $this->registry->getManagers();

        foreach ($managers as $name => $manager) {
            $manager->clear();
        }
    }
}
