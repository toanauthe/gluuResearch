<?php

namespace App\KafkaHandler;

use App\KafkaHandler\Interfaces\HandlerInterface;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;


abstract class BaseHandler implements HandlerInterface
{

    public function __construct(public string $topic,public string $event,public string $uuid,public array $payload){
    }
     abstract public function handle();
     abstract public function rollback();
     abstract public function commit();

     public function __invoke()
     {
         try {
             $this->handle();

         } catch(\Exception $e) {
             throw $e;
         }
     }
     public function success()
     {
         $message = new Message(
             headers: ['event' => $this->event,'status' => 'PRE-COMMIT'],
             body: [],
             key: $this->uuid
         );
         $producer = Kafka::publishOn($this->topic)
             ->withMessage($message);
         $producer->send();
     }

     public function error()
     {
         $message = new Message(
             headers: ['event' => $this->event,'status' => 'ROLLBACK'],
             body: [],
             key: $this->uuid
         );
         $producer = Kafka::publishOn($this->topic)
             ->withMessage($message);
         $producer->send();
     }
}
