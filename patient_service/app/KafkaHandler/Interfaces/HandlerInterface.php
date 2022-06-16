<?php
namespace App\KafkaHandler\Interfaces;

interface HandlerInterface
{
     public function handle();

     public function rollback();

     public function commit();
}
