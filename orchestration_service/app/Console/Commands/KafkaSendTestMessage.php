<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use Illuminate\Support\Str;

class KafkaSendTestMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diag:kafka-send-test-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $message = new Message(
            headers: ['event' => 'patient-register','status' => 'PROCESSING'],
            body: ['key' => 'value'],
            key: (string) Str::uuid()
        );
        $producer = Kafka::publishOn('patient-register')
            ->withKafkaKey('kafka-key')
            ->withMessage($message)
            ->withHeaders(['header-key' => 'header-value'])
        ->withDebugEnabled();
        $producer->send();
    }
}
