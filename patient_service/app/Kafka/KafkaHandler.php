<?php

namespace App\Kafka;

use Junges\Kafka\Contracts\KafkaConsumerMessage;

class KafkaHandler
{
    public function __invoke(KafkaConsumerMessage $message)
    {
        $headers = $message->getHeaders();
        $event = $headers['event'];
        $status = $headers['status'];
        try {
            $handler = new KafkaEvent::$kafkaEventHandler[$event]($message->getKey(),$message->getBody());
            if ($status == 'PROCESSING') {
                $handler->handle();
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
