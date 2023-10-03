<?php

namespace App\Queues;

use Carbon\Exceptions\Exception;
use Illuminate\Contracts\Queue\Queue as QueueContract;
use Illuminate\Queue\Queue;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Contracts\CanConsumeMessages;
use Junges\Kafka\Exceptions\KafkaConsumerException;

class KafkaQueue extends Queue implements QueueContract
{
    public function __construct(
        protected readonly CanConsumeMessages $consumer,
    ) {
    }

    public function size($queue = null)
    {
        // TODO: Implement size() method.
    }

    public function push($job, $data = '', $queue = null)
    {
        // TODO: Implement push() method.
    }

    public function pushRaw($payload, $queue = null, array $options = [])
    {
        // TODO: Implement pushRaw() method.
    }

    public function later($delay, $job, $data = '', $queue = null)
    {
        // TODO: Implement later() method.
    }

    public function pop($queue = null)
    {
        try {
            $this->consumer->consume();
        } catch (Exception|KafkaConsumerException $e) {
            Log::error(self::class . ' ' . $e->getMessage());
        }
    }
}
