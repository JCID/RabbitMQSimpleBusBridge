<?php

namespace Jcid\RabbitMQBridge\MessageBus;

use Jcid\RabbitMQBridge\EventDispatcher\Events\PostMessageEvent;
use Jcid\RabbitMQBridge\EventDispatcher\Events\PreMessageEvent;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;
use SimpleBus\Message\Bus\MessageBus;
use SimpleBus\Message\Type\Command;
use SimpleBus\Message\Type\Event;

class DefaultConsumer implements ConsumerInterface
{
    /**
     * @var MessageBus
     */
    private $commandBus;

    /**
     * @var MessageBus
     */
    private $eventBus;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param MessageBus      $commandBus
     * @param MessageBus      $eventBus
     * @param LoggerInterface $logger
     */
    public function __construct(MessageBus $commandBus, MessageBus $eventBus, LoggerInterface $logger)
    {
        $this->commandBus = $commandBus;
        $this->eventBus   = $eventBus;
        $this->logger     = $logger;
    }

    /**
     * @param  AMQPMessage $msg
     * @return bool
     */
    public function execute(AMQPMessage $msg)
    {
        $this->eventBus->handle(new PreMessageEvent());
        $message = unserialize($msg->body);

        try {

            if ($message instanceof AsyncMessage) {
                if ($message->getMessage() instanceof Command) {
                    $this->commandBus->handle($message);
                } elseif ($message->getMessage() instanceof Event) {
                    $this->eventBus->handle($message);
                }
            }
        } catch (\Exception $e) {
            $this->logger->critical("Message not handled", [
                "message"   => get_class($message->getMessage()),
                "exception" => $e,
            ]);

            return ConsumerInterface::MSG_REJECT;
        } finally {
            $this->eventBus->handle(new PostMessageEvent());
        }
    }
}
