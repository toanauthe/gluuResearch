<?php

namespace App\KafkaHandler;

use App\Models\PatientUser;
use App\Services\Gluu\GluuService;
use Illuminate\Support\Facades\Redis;
use Junges\Kafka\Contracts\KafkaConsumerMessage;

class RegisterHandler extends BaseHandler
{

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
    }

    public function rollback()
    {
        Redis::del($this->uuid);
    }

    public function commit()
    {
        $patient = unserialize(Redis::get($this->uuid));
        $gluuService = new GluuService();
        $result = $gluuService->register(username: $patient->username,email: $patient->email,password: $patient->password);
        if($result)
        {
            $patient->save();
            Redis::del($this->uuid);
        }
    }
}
