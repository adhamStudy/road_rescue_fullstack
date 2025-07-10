<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twilio\Rest\Client;

class TestTwilio extends Command
{
    protected $signature = 'twilio:test';
    protected $description = 'Test Twilio credentials';

    public function handle()
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $messagingServiceSid = env('TWILIO_MESSAGING_SERVICE_SID');

        try {
            $twilio = new Client($sid, $token);
            $service = $twilio->messaging->v1->services($messagingServiceSid)->fetch();

            $this->info('✅ Twilio credentials are valid!');
            $this->info("Service name: {$service->friendlyName}");
        } catch (\Exception $e) {
            $this->error('❌ Invalid Twilio credentials!');
            $this->error($e->getMessage());
        }
    }
}
