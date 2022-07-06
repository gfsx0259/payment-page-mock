<?php

namespace App\Service\Queue\Broker;

use App\Service\Queue\BrokerInterface;
use Bunny\Channel;
use Bunny\Client;
use Bunny\Message;
use Exception;
use Yiisoft\Arrays\ArrayHelper;

/**
 * Works with rabbit
 */
class RabbitMQBroker implements BrokerInterface
{
    public function __construct(
        private Client $client
    ) {}

    public function send(string $queueName, string $message, array $options = []): void
    {
        $delay = ArrayHelper::getValue($options, 'delay');
        $channel = $this->makeChanel($queueName);
        $destinationQueueName = $queueName;

        if ($delay) {
            $destinationQueueName = $this->declareDelayedChannel($channel, $queueName, $delay);
        }

        $channel->publish($message, [], '', $destinationQueueName);
    }

    public function listen(string $queueName, callable $messageHandler): void
    {
        $channel = $this->makeChanel($queueName);

        $channel->run(
            function (Message $message, Channel $channel) use ($messageHandler) {
                $success = $messageHandler($message->content);

                if ($success) {
                    $channel->ack($message);
                } else {
                    $channel->nack($message);
                }
            },
            $queueName
        );
    }

    /**
     * @inheritDoc
     */
    public function checkConnection(): bool
    {
        if (!$this->client->isConnected()) {
            try {
                $this->client->connect();
            } catch (Exception) {
                return false;
            }
        }

        return true;
    }

    private function declareDelayedChannel(Channel $channel, string $queueName, int $delay): string
    {
        $delayedQueueName = "$queueName-$delay";

        $channel->queueDeclare(
            $delayedQueueName,
            false,
            false,
            false,
            true,
            false,
            [
                # set the dead-letter exchange to the default queue
                'x-dead-letter-exchange' => '',
                # when the message expires, set change the routing key into the destination queue name
                'x-dead-letter-routing-key' => $queueName,
                # the time in milliseconds to keep the message in the queue
                'x-message-ttl' => $delay
            ]
        );

        return $delayedQueueName;
    }

    /**
     * @throws Exception
     */
    private function makeChanel(string $queueName): Channel
    {
        if (!$this->client->isConnected()) {
            $this->client->connect();
        }

        $channel = $this->client->channel();

        $channel->queueDeclare($queueName);

        return $channel;
    }
}
