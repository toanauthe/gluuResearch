<?php
namespace App\Kafka;

use App\KafkaHandler\RegisterHandler;

class KafkaEvent
{
    public static array $kafkaEventHandler = [
        'patient-register' => RegisterHandler::class,
    ];
}
