<?php

namespace Jcid\RabbitMQBridge\MessageBus;

use Psr\Log\LoggerInterface;
use SimpleBus\Message\Bus\Middleware\MessageBusMiddleware as BaseMessageBusMiddleware;
use SimpleBus\Message\Message;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MessageBusMiddleware implements BaseMessageBusMiddleware
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param LoggerInterface    $logger
     * @param ContainerInterface $container
     */
    public function __construct(LoggerInterface $logger, ContainerInterface $container)
    {
        $this->logger    = $logger;
        $this->container = $container;
    }

    /**
     * @param Message  $message
     * @param callable $next
     */
    public function handle(Message $message, callable $next)
    {
        // Handle and unpack async message
        if ($message instanceof AsyncMessage) {
            $next($message->getMessage());

        // Packing message for handeling async
        } elseif ($message instanceof IsHandledAsync) {
            try {
                $message = new AsyncMessage($message);
                // $producer = $message->getProducer() ?: "default_command_producer";
                $producer = "default_command_producer";
                $this->container
                    ->get(sprintf("old_sound_rabbit_mq.%s", $producer))
                    ->publish(serialize($message));
            } catch (\Exception $e) {
                $this->logger->critical("Message could not be send to RabbitMQ, forwarded the event to next handler", [
                    "exception" => $e,
                ]);
                $next($message);
            }

        // No async command / moving on
        } else {
            $next($message);
        }
    }
}
