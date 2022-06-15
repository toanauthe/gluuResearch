<?php

namespace App\Kafka;

use Junges\Kafka\Contracts\KafkaConsumerMessage;

class KafkaHandler
{
    public function __invoke(KafkaConsumerMessage $message){
        // Handle your message here
    }
}
