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
        $messageUUID = (string) Str::uuid();
        $message = new Message(
            headers: ['event' => 'patient-register','status' => 'PROCESSING'],
            body: ['username' => 'toanauthe',
            'password' => '123456',
            'email' => 'toan.au@diag.vn',
            'first_name' => 'Toan',
            'last_name' => 'Au',
            'phone_number' => '0906550097',],
            key: $messageUUID
        );
        $producer = Kafka::publishOn('patient-register')
            ->withMessage($message);
        $producer->send();
        $this->info('uuid '.$messageUUID);
    }
}
