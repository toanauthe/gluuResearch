<?php
namespace App\Kafka;

use Junges\Kafka\Contracts\KafkaConsumerMessage;

class KafkaEvent
{

    protected $kafkaEventHandler = [
        'patient-register' => \App\Http\Middleware\Authenticate::class,
    ];
}
