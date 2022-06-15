<?php

namespace App\Console\Commands;

use App\Kafka\KafkaHandler;
use Illuminate\Console\Command;
use Junges\Kafka\Facades\Kafka;

class KafkaConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diag:kafka-consumer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'diag:kafka-consumer';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $consumerBuilder = Kafka::createConsumer(topics: ['patient-register'])->withBrokers('broker:9092');
        $consumerBuilder->withHandler(new KafkaHandler());
        $consumer = $consumerBuilder->build();

        $consumer->consume();
        return 0;
    }
}
