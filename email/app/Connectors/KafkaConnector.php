<?php

namespace App\Connectors;

use App\Queues\KafkaQueue;
use Illuminate\Queue\Connectors\ConnectorInterface;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Config\Sasl;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use Junges\Kafka\Facades\Kafka;

class KafkaConnector implements ConnectorInterface
{

    public function connect(array $config)
    {
        $consumer = Kafka::createConsumer(config('kafka.topics'))
            ->withSasl(new Sasl(
                config('kafka.username'),
                config('kafka.password'),
                config('kafka.mechanism'),
                config('kafka.security_protocol'),
            ))
            ->withHandler(function(KafkaConsumerMessage $message) {
                $mes = is_string($message->getBody()) ? $message->getBody() : json_encode($message->getBody()) ;
                Log::info('Consumed message: ' . $mes);
                echo "Consumed message: $mes\n";
            })
            ->build();

        return new KafkaQueue($consumer);
    }
}
