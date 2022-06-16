<?php
namespace App\Services\Kafka;

use App\KafkaHandler\RegisterHandler;

class KafkaEvent
{
    public static array $kafkaEventHandler = [
        'patient-register' => RegisterHandler::class,
    ];
}
