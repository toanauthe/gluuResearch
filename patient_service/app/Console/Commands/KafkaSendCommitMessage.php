<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use Illuminate\Support\Str;

class KafkaSendCommitMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diag:kafka-send-commit-message {uuid}';

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
        $messageUUID = $this->argument('uuid');
        $message = new Message(
            headers: ['event' => 'patient-register','status' => 'FINISHED'],
            body: [],
            key: $messageUUID
        );
        $producer = Kafka::publishOn('patient-register')
            ->withKafkaKey('kafka-key')
            ->withMessage($message);
        $producer->send();
        $this->info('Success');
    }
}
