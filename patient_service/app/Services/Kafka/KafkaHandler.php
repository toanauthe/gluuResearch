<?php

namespace App\Services\Kafka;

use Junges\Kafka\Contracts\KafkaConsumerMessage;

class KafkaHandler
{
    public function __invoke(KafkaConsumerMessage $message)
    {
        $headers = $message->getHeaders();
        $event = $headers['event'];
        $status = $headers['status'];
        try {
            $handler = new KafkaEvent::$kafkaEventHandler[$event](topic:$message->getTopicName(),event:$event,uuid: $message->getKey(),payload: $message->getBody());
            if ($status == 'PROCESSING') {
                $handler();
            } elseif ($status == 'ROLLBACK') {
                $handler->rollback();
            } elseif ($status == 'FINISHED') {
                $handler->commit();
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
