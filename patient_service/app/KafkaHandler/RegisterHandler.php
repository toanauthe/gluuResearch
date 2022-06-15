<?php

namespace App\KafkaHandler;

use App\Models\PatientUser;
use Illuminate\Support\Facades\Redis;
use Junges\Kafka\Contracts\KafkaConsumerMessage;

class RegisterHandler
{
    public array $payload;
    public string $uuid;

    public function __construct($uuid, array $payload){
        $this->payload = $payload;
        $this->uuid = $uuid;
    }
    public function handle()
    {
        $patient = new PatientUser();
        $patient->username = $this->payload['username'];
        $patient->password = $this->payload['password'];
        $patient->email = $this->payload['email'];
        $patient->first_name = $this->payload['first_name'];
        $patient->last_name = $this->payload['last_name'];
        $patient->phone_number = $this->payload['phone_number'];
        Redis::set($this->uuid,serialize($patient));
        echo $this->uuid;
    }

    public function rollback()
    {
    }

    public function commit()
    {
        $patient = unserialize(Redis::get($this->uuid));
        $patient->save();
        Redis::del($this->uuid);
        echo 'haha';
    }
}
